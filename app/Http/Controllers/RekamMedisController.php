<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use App\Models\Kunjungan;
use App\Models\Pembayaran;
use App\Models\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;

class RekamMedisController extends Controller
{
    public function index(Request $request)
    {
        $query = RekamMedis::with(['pasien', 'dokter.user', 'kunjungan', 'tindakanMedis', 'inputBy']);

        $user = auth()->user();
        
        // Filter by logged-in dokter if user has dokter role
        if ($user && $user->role === 'dokter') {
            $dokter = Dokter::where('user_id', $user->id)->first();
            if ($dokter) {
                $query->where('dokter_id', $dokter->id);
            } else {
                $query->whereRaw('1 = 0');
            }
        }
        
        // Filter untuk perawat: hanya rekam medis dari dokter yang dibantu
        if ($user && $user->role === 'perawat') {
            $perawat = $user->perawat;
            if ($perawat) {
                $dokterIds = $perawat->dokters->pluck('id');
                $query->whereIn('dokter_id', $dokterIds);
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        // Search by pasien name or diagnosa
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('pasien', function($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                })
                ->orWhere('diagnosa', 'like', "%{$search}%");
            });
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $rekamMedis = $query->latest()->paginate(10)->withQueryString();
        return view('rekam_medis.index', compact('rekamMedis'));
    }

    public function create()
    {
        $kunjungansQuery = Kunjungan::with(['pasien', 'dokter.user'])
            ->where('status', 'disetujui')
            ->whereDoesntHave('rekamMedis') 
            ->orderBy('waktu_kunjungan', 'asc');

        $user = auth()->user();
        
        // Filter by logged-in dokter if user has dokter role
        if ($user && $user->role === 'dokter') {
            $dokter = Dokter::where('user_id', $user->id)->first();
            if ($dokter) {
                $kunjungansQuery->where('dokter_id', $dokter->id);
            } else {
                $kunjungansQuery->whereRaw('1 = 0');
            }
        }
        
        // Filter untuk perawat: hanya kunjungan dari dokter yang dibantu
        if ($user && $user->role === 'perawat') {
            $perawat = $user->perawat;
            if ($perawat) {
                $dokterIds = $perawat->dokters->pluck('id');
                $kunjungansQuery->whereIn('dokter_id', $dokterIds);
            } else {
                $kunjungansQuery->whereRaw('1 = 0');
            }
        }

        $kunjungans = $kunjungansQuery->get();

        return view('rekam_medis.create', compact('kunjungans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kunjungan_id'      => 'required|exists:kunjungans,id',
            'keluhan'           => 'required|string',
            'diagnosa'          => 'required|string',
            'tindakan'          => 'nullable|string',
            'biaya_pemeriksaan' => 'required|integer|min:0',
            'catatan_obat'      => 'nullable|string',
            'tindakan_medis'    => 'nullable|array',
            'tindakan_medis.*.nama_tindakan' => 'nullable|string|max:255',
            'tindakan_medis.*.biaya'         => 'nullable|integer|min:0',
            'tindakan_medis.*.keterangan'    => 'nullable|string',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // 1. Ambil Data Kunjungan
                $kunjungan = Kunjungan::with(['pasien', 'dokter'])->findOrFail($request->kunjungan_id);

                // 2. Simpan Data Rekam Medis
                $user = auth()->user();
                $rekamMedis = RekamMedis::create([
                    'kunjungan_id'      => $kunjungan->id,
                    'pasien_id'         => $kunjungan->pasien_id, 
                    'dokter_id'         => $kunjungan->dokter_id, 
                    'keluhan'           => $request->keluhan,
                    'diagnosa'          => $request->diagnosa,
                    'tindakan'          => $request->tindakan,
                    'biaya_pemeriksaan' => $request->biaya_pemeriksaan,
                    'catatan_obat'      => $request->catatan_obat,
                    'input_by_user_id'  => $user->id,
                    'input_by_role'     => $user->role === 'perawat' ? 'perawat' : 'dokter',
                ]);

                // 3. Proses Tindakan Medis Tambahan
                $totalTindakan = 0;
                if ($request->has('tindakan_medis') && is_array($request->tindakan_medis)) {
                    foreach ($request->tindakan_medis as $tindakan) {
                        if (!empty($tindakan['nama_tindakan'])) {
                            $rekamMedis->tindakanMedis()->create([
                                'nama_tindakan' => $tindakan['nama_tindakan'],
                                'keterangan'    => $tindakan['keterangan'] ?? null,
                                'biaya'         => $tindakan['biaya'] ?? 0,
                            ]);
                            $totalTindakan += $tindakan['biaya'] ?? 0;
                        }
                    }
                }

                // 4. Generate Pembayaran (Midtrans)
                $serverKey = config('services.midtrans.server_key');

                if (!$serverKey) {
                    throw new \Exception("Midtrans Server Key belum dikonfigurasi");
                }

                // Total = Biaya Pemeriksaan + Total Tindakan Medis
                $grandTotal = $request->biaya_pemeriksaan + $totalTindakan;

                // Konfigurasi Midtrans
                Config::$serverKey = $serverKey;
                Config::$isProduction = config('services.midtrans.is_production') ?? env('MIDTRANS_IS_PRODUCTION', false);
                Config::$isSanitized = true;
                Config::$is3ds = true;

                Config::$curlOptions = [
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_HTTPHEADER => [],
                ];

                $orderId = 'INV-' . time() . '-' . $kunjungan->id;

                $params = [
                    'transaction_details' => [
                        'order_id' => $orderId,
                        'gross_amount' => (int) $grandTotal,
                    ],
                    'customer_details' => [
                        'first_name' => $kunjungan->pasien->nama,
                        'phone'      => $kunjungan->pasien->no_telepon,
                    ],
                ];

                // Request Snap Token
                try {
                    $snapToken = Snap::getSnapToken($params);
                } catch (\Exception $midtransError) {
                    throw new \Exception("Gagal menghubungi Midtrans: " . $midtransError->getMessage());
                }

                // Simpan ke Database Pembayaran
                Pembayaran::create([
                    'kunjungan_id' => $kunjungan->id,
                    'order_id'     => $orderId,
                    'total_harga'  => $grandTotal,
                    'status_pembayaran' => 'pending',
                    'metode_pembayaran' => null,
                    'snap_token'   => $snapToken,
                ]);

                // 5. Update Status Kunjungan
                $kunjungan->update(['status' => 'selesai']);
            });

            return redirect()->route('rekam_medis.index')->with('success', 'Rekam medis berhasil disimpan & Tagihan dibuat.');

        } catch (\Exception $e) {
            Log::error('Error Simpan Rekam Medis: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    } 

    public function edit(RekamMedis $rekam_medi)
    {
        $rekamMedis = $rekam_medi; 
        $rekamMedis->load(['tindakanMedis', 'pasien', 'dokter.user', 'kunjungan']);

        return view('rekam_medis.edit', compact('rekamMedis'));
    }

    public function update(Request $request, $id)
    {
        $rekamMedis = RekamMedis::findOrFail($id);

        $request->validate([
            'keluhan'           => 'required|string',
            'diagnosa'          => 'required|string',
            'tindakan'          => 'nullable|string',
            'biaya_pemeriksaan' => 'required|integer|min:0',
            'catatan_obat'      => 'nullable|string',
            'tindakan_medis'    => 'nullable|array',
            'tindakan_medis.*.nama_tindakan' => 'nullable|string|max:255',
            'tindakan_medis.*.biaya'         => 'nullable|integer|min:0',
            'tindakan_medis.*.keterangan'    => 'nullable|string',
        ]);

        try {
            DB::transaction(function () use ($request, $rekamMedis) {
                // Update Data Dasar
                $rekamMedis->update([
                    'keluhan'           => $request->keluhan,
                    'diagnosa'          => $request->diagnosa,
                    'tindakan'          => $request->tindakan,
                    'biaya_pemeriksaan' => $request->biaya_pemeriksaan,
                    'catatan_obat'      => $request->catatan_obat,
                ]);

                // Hapus tindakan medis lama
                $rekamMedis->tindakanMedis()->delete();

                // Tambah tindakan medis baru
                $totalTindakan = 0;
                if ($request->has('tindakan_medis') && is_array($request->tindakan_medis)) {
                    foreach ($request->tindakan_medis as $tindakan) {
                        if (!empty($tindakan['nama_tindakan'])) {
                            $rekamMedis->tindakanMedis()->create([
                                'nama_tindakan' => $tindakan['nama_tindakan'],
                                'keterangan'    => $tindakan['keterangan'] ?? null,
                                'biaya'         => $tindakan['biaya'] ?? 0,
                            ]);
                            $totalTindakan += $tindakan['biaya'] ?? 0;
                        }
                    }
                }

                // Update Pembayaran jika ada
                $kunjungan = $rekamMedis->kunjungan;
                if ($kunjungan && $kunjungan->pembayaran) {
                    $grandTotal = $request->biaya_pemeriksaan + $totalTindakan;
                    $kunjungan->pembayaran->update(['total_harga' => $grandTotal]);
                }
            });

            return redirect()->route('rekam_medis.index')->with('success', 'Rekam medis berhasil diperbarui.');

        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show(RekamMedis $rekam_medi) 
    {
        $rekam_medi->load(['pasien', 'dokter.user', 'kunjungan', 'tindakanMedis']);
        return response()->json(['rekam_medis' => $rekam_medi]);
    }

    public function destroy($id)
    {
        $rekamMedis = RekamMedis::findOrFail($id);

        try {
            DB::transaction(function () use ($rekamMedis) {
                $kunjungan = $rekamMedis->kunjungan;

                // 1. Hapus tindakan medis
                $rekamMedis->tindakanMedis()->delete();

                // 2. Hapus Pembayaran
                if($kunjungan && $kunjungan->pembayaran) {
                    $kunjungan->pembayaran->delete();
                }

                // 3. Hapus Data
                $rekamMedis->delete();
                if ($kunjungan) {
                    $kunjungan->delete();
                }
            });

            return redirect()->route('rekam_medis.index')->with('success', 'Data berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->route('rekam_medis.index')->withErrors(['error' => $e->getMessage()]);
        }
    }
}