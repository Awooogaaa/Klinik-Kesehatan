<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use App\Models\Kunjungan;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                $kunjungan = Kunjungan::findOrFail($request->kunjungan_id);

                // 1. Simpan Data Utama
                $rekamMedis = RekamMedis::create([
                    'kunjungan_id' => $kunjungan->id,
                    'pasien_id'    => $kunjungan->pasien_id,
                    'dokter_id'    => $kunjungan->dokter_id,
                    'keluhan'      => $request->keluhan,
                    'diagnosa'     => $request->diagnosa,
                    'tindakan'     => $request->tindakan,
                ]);

                // 2. Proses Obat (Cek Stok & Kurangi)
                if ($request->has('obats')) {
                    foreach ($request->obats as $resep) {
                        $obat = Obat::lockForUpdate()->find($resep['obat_id']); // Lock agar aman jika banyak akses

                        // Validasi Stok
                        if (!$obat || $obat->stok < $resep['jumlah']) {
                            throw new \Exception("Stok obat {$obat->nama_obat} tidak mencukupi. Sisa: {$obat->stok}");
                        }

                        // Kurangi Stok
                        $obat->decrement('stok', $resep['jumlah']);

                        // Simpan ke Pivot
                        $rekamMedis->obats()->attach($resep['obat_id'], [
                            'jumlah' => $resep['jumlah'],
                            'dosis'  => $resep['dosis'],
                        ]);
                    }
                }

                // 3. Update Status Kunjungan
                $kunjungan->update(['status' => 'selesai']);
            });

            return redirect()->route('rekam_medis.index')->with('success', 'Pemeriksaan selesai. Stok obat telah diperbarui.');

        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['obats' => $e->getMessage()]);
        }
    }

    public function edit(RekamMedis $rekam_medi)
    {
        // PERBAIKAN: Ubah argumen dari $rekamMedis menjadi $rekam_medi agar binding berhasil
        // Lalu kita masukkan ke variabel $rekamMedis agar view tidak error
        $rekamMedis = $rekam_medi; 

        $rekamMedis->load(['obats', 'pasien', 'dokter.user', 'kunjungan']);
        $obats = Obat::orderBy('nama_obat')->get();

        return view('rekam_medis.edit', compact('rekamMedis', 'obats'));
    }

    public function update(Request $request, RekamMedis $rekam_medi)
    {
        // PERBAIKAN: Ubah argumen juga di sini menjadi $rekam_medi
        $rekamMedis = $rekam_medi;

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
                // 1. Update Data Medis Dasar
                $rekamMedis->update($request->only(['keluhan', 'diagnosa', 'tindakan']));

                // 2. KEMBALIKAN STOK LAMA (Restore Stock)
                foreach ($rekamMedis->obats as $obatLama) {
                    $obatLama->increment('stok', $obatLama->pivot->jumlah);
                }

                // 3. KURANGI STOK BARU & SYNC
                $syncData = [];
                if ($request->has('obats')) {
                    foreach ($request->obats as $resep) {
                        // Gunakan isset untuk menghindari error undefined index jika ada input kosong
                        if (!isset($resep['obat_id']) || !isset($resep['jumlah'])) continue;

                        $obat = Obat::lockForUpdate()->find($resep['obat_id']);

                        if (!$obat || $obat->stok < $resep['jumlah']) {
                            throw new \Exception("Stok obat {$obat->nama_obat} tidak mencukupi. Sisa: {$obat->stok}");
                        }

                        $obat->decrement('stok', $resep['jumlah']);

                        $syncData[$resep['obat_id']] = [
                            'jumlah' => $resep['jumlah'],
                            'dosis'  => $resep['dosis'] ?? '-',
                        ];
                    }
                }
                
                // Sync data baru (otomatis hapus relasi lama)
                $rekamMedis->obats()->sync($syncData);
            });

            return redirect()->route('rekam_medis.index')->with('success', 'Rekam medis diperbarui. Stok obat disesuaikan.');

        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['obats' => $e->getMessage()]);
        }
    }


public function show(RekamMedis $rekam_medi) 
{
    // PERBAIKAN: Tambahkan '.user' pada dokter agar nama dokter terbawa
    $rekam_medi->load(['pasien', 'dokter.user', 'kunjungan', 'obats']);

    return response()->json([
        'rekam_medis' => $rekam_medi
    ]);
}

    public function destroy($id)
    {
        // 1. Cari data secara manual menggunakan ID agar PASTI TERAMBIL
        // Jika ID tidak ditemukan, akan otomatis error 404 (Not Found)
        $rekamMedis = RekamMedis::findOrFail($id);

        try {
            DB::transaction(function () use ($rekamMedis) {
                // 2. Ambil data kunjungan terkait sebelum rekam medis dihapus
                $kunjungan = $rekamMedis->kunjungan;

                // 3. Hapus relasi obat di tabel pivot (obat_rekam_medis) terlebih dahulu
                // Langkah ini WAJIB agar tidak terkena Foreign Key Constraint error
                $rekamMedis->obats()->detach();

                // 4. Hapus Rekam Medis
                $rekamMedis->delete();

                // 5. Hapus Kunjungan terkait (Sesuai permintaan Anda)
                // Pengecekan if($kunjungan) untuk jaga-jaga jika data kunjungan sudah hilang duluan
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