<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use App\Models\Kunjungan;
use App\Models\Obat;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;

class RekamMedisController extends Controller
{
    public function index()
    {
        $rekamMedis = RekamMedis::with(['pasien', 'dokter.user', 'kunjungan', 'obats'])
                                ->latest()
                                ->paginate(10);
        return view('rekam_medis.index', compact('rekamMedis'));
    }

    public function create()
    {
        $kunjungans = Kunjungan::with(['pasien', 'dokter.user'])
            ->where('status', 'disetujui')
            ->whereDoesntHave('rekamMedis') 
            ->orderBy('waktu_kunjungan', 'asc')
            ->get();

        $obats = Obat::orderBy('nama_obat')->get();

        return view('rekam_medis.create', compact('kunjungans', 'obats'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'kunjungan_id' => 'required|exists:kunjungans,id',
            'keluhan'      => 'required|string',
            'diagnosa'     => 'required|string',
            'tindakan'     => 'nullable|string',
            'obats'        => 'nullable|array',
            'obats.*.obat_id' => 'required|exists:obats,id',
            'obats.*.jumlah'  => 'required|integer|min:1',
            'obats.*.dosis'   => 'required|string|max:255',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // 1. Ambil Data Kunjungan
                $kunjungan = Kunjungan::with(['pasien', 'dokter'])->findOrFail($request->kunjungan_id);

                // 2. Simpan Data Rekam Medis
                $rekamMedis = RekamMedis::create([
                    'kunjungan_id' => $kunjungan->id,
                    'pasien_id'    => $kunjungan->pasien_id, 
                    'dokter_id'    => $kunjungan->dokter_id, 
                    'keluhan'      => $request->keluhan,
                    'diagnosa'     => $request->diagnosa,
                    'tindakan'     => $request->tindakan,
                ]);

                // 3. Proses Obat & Hitung Total Harga
                $totalHargaObat = 0;
                
                if ($request->has('obats') && is_array($request->obats)) {
                    foreach ($request->obats as $resep) {
                        $jumlah = (int) $resep['jumlah'];
                        $dosis  = $resep['dosis'];
                        $obatId = $resep['obat_id'];
                        
                        // Lock obat
                        $obat = Obat::lockForUpdate()->find($obatId);
                        
                        // Validasi Stok
                        if (!$obat || $obat->stok < $jumlah) {
                            throw new \Exception("Stok obat {$obat->nama_obat} tidak mencukupi. Sisa: {$obat->stok}");
                        }

                        // Hitung Subtotal
                        $subtotal = $obat->harga * $jumlah;
                        $totalHargaObat += $subtotal;

                        // Simpan ke Pivot
                        $rekamMedis->obats()->attach($obatId, [
                            'jumlah' => $jumlah,
                            'dosis'  => $dosis
                        ]);

                        // Kurangi Stok
                        $obat->decrement('stok', $jumlah);
                    }
                }

                // 4. Generate Pembayaran (Midtrans)
                
                $serverKey = config('services.midtrans.server_key');

if (!$serverKey) {
    throw new \Exception("Midtrans Server Key belum dikonfigurasi");
}


                $biayaJasa = $kunjungan->dokter->biaya_jasa ?? 50000;
                $grandTotal = $biayaJasa + $totalHargaObat;

                // Konfigurasi Midtrans
                Config::$serverKey = $serverKey;
                Config::$isProduction = config('services.midtrans.is_production') ?? env('MIDTRANS_IS_PRODUCTION', false);
                Config::$isSanitized = true;
                Config::$is3ds = true;

                // --- PERBAIKAN: FIX UNDEFINED ARRAY KEY 10023 & SSL ---
                Config::$curlOptions = [
                    CURLOPT_SSL_VERIFYPEER => false, // Bypass SSL Error
                    CURLOPT_HTTPHEADER => [],        // Fix Undefined Key 10023
                ];
                // ------------------------------------------------------

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
        $rekamMedis->load(['obats', 'pasien', 'dokter.user', 'kunjungan']);
        $obats = Obat::orderBy('nama_obat')->get();

        return view('rekam_medis.edit', compact('rekamMedis', 'obats'));
    }

    public function update(Request $request, $id)
    {
        $rekamMedis = RekamMedis::findOrFail($id);

        $request->validate([
            'keluhan'      => 'required|string',
            'diagnosa'     => 'required|string',
            'tindakan'     => 'nullable|string',
            'obats'        => 'nullable|array',
            'obats.*.obat_id' => 'required|exists:obats,id',
            'obats.*.jumlah'  => 'required|integer|min:1',
            'obats.*.dosis'   => 'required|string|max:255',
        ]);

        try {
            DB::transaction(function () use ($request, $rekamMedis) {
                // Update Data Dasar
                $rekamMedis->update($request->only(['keluhan', 'diagnosa', 'tindakan']));

                // A. Kembalikan Stok Lama
                $oldObats = $rekamMedis->obats()->get();
                foreach ($oldObats as $obatLama) {
                    $obatLama->increment('stok', $obatLama->pivot->jumlah);
                }

                // B. Proses Obat Baru
                $syncData = [];
                if ($request->filled('obats') && is_array($request->obats)) {
                    foreach ($request->obats as $resep) {
                        if (empty($resep['obat_id']) || empty($resep['jumlah'])) continue;

                        $obat = Obat::lockForUpdate()->find($resep['obat_id']);
                        $jumlahBaru = (int) $resep['jumlah'];

                        if (!$obat || $obat->stok < $jumlahBaru) {
                            throw new \Exception("Stok obat {$obat->nama_obat} tidak mencukupi. Tersedia: {$obat->stok}");
                        }

                        $obat->decrement('stok', $jumlahBaru);

                        $syncData[$resep['obat_id']] = [
                            'jumlah' => $jumlahBaru,
                            'dosis'  => $resep['dosis'] ?? '-',
                        ];
                    }
                }

                // C. Sync
                $rekamMedis->obats()->sync($syncData);
            });

            return redirect()->route('rekam_medis.index')->with('success', 'Rekam medis berhasil diperbarui.');

        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show(RekamMedis $rekam_medi) 
    {
        $rekam_medi->load(['pasien', 'dokter.user', 'kunjungan', 'obats']);
        return response()->json(['rekam_medis' => $rekam_medi]);
    }

    public function destroy($id)
    {
        $rekamMedis = RekamMedis::findOrFail($id);

        try {
            DB::transaction(function () use ($rekamMedis) {
                $kunjungan = $rekamMedis->kunjungan;

                // 1. Kembalikan Stok
                foreach($rekamMedis->obats as $obat) {
                    $obat->increment('stok', $obat->pivot->jumlah);
                }
                $rekamMedis->obats()->detach();

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