<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use App\Models\Kunjungan;
use App\Models\Obat;
use App\Models\Pembayaran; // Pastikan model ini ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class RekamMedisController extends Controller
{
    public function index()
    {
        // Tambahkan 'obats' ke eager load agar muncul di tabel index
        $rekamMedis = RekamMedis::with(['pasien', 'dokter.user', 'kunjungan', 'obats'])
                                ->latest()
                                ->paginate(10);
        return view('rekam_medis.index', compact('rekamMedis'));
    }

    public function create()
    {
        // Ambil kunjungan yang disetujui tapi belum punya rekam medis
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
                $kunjungan = Kunjungan::with(['pasien', 'dokter'])->findOrFail($request->kunjungan_id);

                // 1. Simpan Data Rekam Medis
                $rekamMedis = RekamMedis::create([
                    'kunjungan_id' => $kunjungan->id,
                    // Jika kolom pasien_id/dokter_id ada di tabel rekam_medis, uncomment baris bawah:
                    // 'pasien_id'    => $kunjungan->pasien_id,
                    // 'dokter_id'    => $kunjungan->dokter_id,
                    'keluhan'      => $request->keluhan,
                    'diagnosa'     => $request->diagnosa,
                    'tindakan'     => $request->tindakan,
                ]);

                // 2. Proses Obat & Hitung Total Harga
                $totalHargaObat = 0;
                
                if ($request->has('obats') && is_array($request->obats)) {
                    foreach ($request->obats as $resep) {
                        $jumlah = $resep['jumlah'];
                        $dosis = $resep['dosis'];
                        $obatId = $resep['obat_id'];
                        
                        // Lock obat untuk menghindari race condition stok
                        $obat = Obat::lockForUpdate()->find($obatId);
                        
                        // Cek stok
                        if (!$obat || $obat->stok < $jumlah) {
                            throw new \Exception("Stok obat {$obat->nama_obat} tidak mencukupi. Sisa: {$obat->stok}");
                        }

                        // Hitung Subtotal
                        $subtotal = $obat->harga * $jumlah;
                        $totalHargaObat += $subtotal;

                        // Simpan ke Pivot Table
                        $rekamMedis->obats()->attach($obatId, [
                            'jumlah' => $jumlah,
                            'dosis' => $dosis
                        ]);

                        // Kurangi Stok
                        $obat->decrement('stok', $jumlah);
                    }
                }

                // 3. Generate Pembayaran (Midtrans)
                
                // Hitung Grand Total (Jasa Dokter + Obat)
                $biayaJasa = $kunjungan->dokter->biaya_jasa ?? 50000;
                $grandTotal = $biayaJasa + $totalHargaObat;

                // Konfigurasi Midtrans
                Config::$serverKey = config('services.midtrans.server_key') ?? env('MIDTRANS_SERVER_KEY');
                Config::$isProduction = config('services.midtrans.is_production') ?? env('MIDTRANS_IS_PRODUCTION', false);
                Config::$isSanitized = true;
                Config::$is3ds = true;

                $orderId = 'INV-' . time() . '-' . $kunjungan->id;

                $params = [
                    'transaction_details' => [
                        'order_id' => $orderId,
                        'gross_amount' => (int) $grandTotal, // Pastikan integer
                    ],
                    'customer_details' => [
                        'first_name' => $kunjungan->pasien->nama,
                        'phone' => $kunjungan->pasien->no_telepon,
                    ],
                ];

                $snapToken = Snap::getSnapToken($params);

                // Simpan ke database pembayaran
                Pembayaran::create([
                    'kunjungan_id' => $kunjungan->id,
                    'order_id' => $orderId,
                    'total_harga' => $grandTotal,
                    'status_pembayaran' => 'pending',
                    'snap_token' => $snapToken,
                ]);

                // 4. Update status kunjungan jadi selesai
                $kunjungan->update(['status' => 'selesai']);
            });

            return redirect()->route('rekam_medis.index')->with('success', 'Rekam medis disimpan & Tagihan dibuat.');

        } catch (\Exception $e) {
            // Rollback otomatis terjadi jika ada error karena DB::transaction
            return back()->withInput()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    } 

    public function edit(RekamMedis $rekam_medi)
    {
        // Ubah variabel binding agar sesuai
        $rekamMedis = $rekam_medi; 

        $rekamMedis->load(['obats', 'pasien', 'dokter.user', 'kunjungan']);
        $obats = Obat::orderBy('nama_obat')->get();

        return view('rekam_medis.edit', compact('rekamMedis', 'obats'));
    }

    public function update(Request $request, $id)
    {
        // Cari manual menggunakan ID
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
                // Update Data Medis Dasar
                $rekamMedis->update($request->only(['keluhan', 'diagnosa', 'tindakan']));

                // --- LOGIKA PERBAIKAN STOK & SYNC ---
                
                // A. Ambil data obat lama & Kembalikan Stok
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

                        // Validasi Stok
                        if (!$obat || $obat->stok < $jumlahBaru) {
                            throw new \Exception("Stok obat {$obat->nama_obat} tidak mencukupi. Tersedia: {$obat->stok}");
                        }

                        // Kurangi Stok
                        $obat->decrement('stok', $jumlahBaru);

                        // Siapkan data sync
                        $syncData[$resep['obat_id']] = [
                            'jumlah' => $jumlahBaru,
                            'dosis'  => $resep['dosis'] ?? '-',
                        ];
                    }
                }

                // C. Sync (Hapus lama, masukkan baru)
                $rekamMedis->obats()->sync($syncData);
                
                // Catatan: Update ini TIDAK memperbarui harga di tabel Pembayaran
                // Jika ingin update harga pembayaran juga, tambahkan logika update Pembayaran di sini.
            });

            return redirect()->route('rekam_medis.index')->with('success', 'Rekam medis berhasil diperbarui.');

        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['obats' => $e->getMessage()]);
        }
    }

    public function show(RekamMedis $rekam_medi) 
    {
        $rekam_medi->load(['pasien', 'dokter.user', 'kunjungan', 'obats']);

        return response()->json([
            'rekam_medis' => $rekam_medi
        ]);
    }

    public function destroy($id)
    {
        $rekamMedis = RekamMedis::findOrFail($id);

        try {
            DB::transaction(function () use ($rekamMedis) {
                $kunjungan = $rekamMedis->kunjungan;

                // 1. Kembalikan stok obat sebelum dihapus (Opsional, tapi disarankan)
                foreach($rekamMedis->obats as $obat) {
                    $obat->increment('stok', $obat->pivot->jumlah);
                }

                // 2. Hapus relasi obat di pivot
                $rekamMedis->obats()->detach();

                // 3. Hapus Pembayaran terkait (jika ada)
                if($kunjungan && $kunjungan->pembayaran) {
                    $kunjungan->pembayaran->delete();
                }

                // 4. Hapus Rekam Medis
                $rekamMedis->delete();

                // 5. Hapus Kunjungan
                if ($kunjungan) {
                    $kunjungan->delete();
                }
            });

            return redirect()->route('rekam_medis.index')
                             ->with('success', 'Rekam Medis dan data Kunjungan berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->route('rekam_medis.index')
                             ->withErrors(['error' => 'Gagal menghapus data: ' . $e->getMessage()]);
        }
    }
}