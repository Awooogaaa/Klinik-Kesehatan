<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekamMedisController extends Controller
{
    /**
     * Menampilkan daftar riwayat rekam medis.
     */
    public function index()
    {
        $rekamMedis = RekamMedis::with(['pasien', 'dokter', 'kunjungan'])
                                ->latest()
                                ->paginate(10);
                                
        return view('rekam_medis.index', compact('rekamMedis'));
    }

    /**
     * Menampilkan form pemeriksaan (membuat rekam medis baru).
     * Hanya menampilkan Kunjungan yang statusnya 'disetujui' dan belum diperiksa.
     */
    public function create()
    {
        // Ambil kunjungan yang statusnya 'disetujui'
        // DAN belum memiliki data di tabel rekam_medis (agar tidak double)
        $kunjungans = Kunjungan::with(['pasien', 'dokter'])
            ->where('status', 'disetujui')
            ->whereDoesntHave('rekamMedis') 
            ->orderBy('waktu_kunjungan', 'asc')
            ->get();

        return view('rekam_medis.create', compact('kunjungans'));
    }

    /**
     * Menyimpan data rekam medis dan menyelesaikan kunjungan.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kunjungan_id' => 'required|exists:kunjungans,id',
            'keluhan'      => 'required|string',
            'diagnosa'     => 'required|string',
            'tindakan'     => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Cari data kunjungan berdasarkan ID yang dipilih
            $kunjungan = Kunjungan::findOrFail($request->kunjungan_id);

            // 2. Simpan Rekam Medis
            // Pasien ID dan Dokter ID diambil otomatis dari data Kunjungan
            RekamMedis::create([
                'kunjungan_id' => $kunjungan->id,
                'pasien_id'    => $kunjungan->pasien_id,
                'dokter_id'    => $kunjungan->dokter_id,
                'keluhan'      => $request->keluhan,
                'diagnosa'     => $request->diagnosa,
                'tindakan'     => $request->tindakan,
            ]);

            // 3. Update status Kunjungan menjadi 'selesai'
            $kunjungan->update(['status' => 'selesai']);
        });

        return redirect()->route('rekam_medis.index')
                         ->with('success', 'Pemeriksaan selesai. Data rekam medis berhasil disimpan.');
    }

    /**
     * Menampilkan detail satu rekam medis.
     */
    public function show(RekamMedis $rekamMedis)
    {
        $rekamMedis->load(['pasien', 'dokter', 'kunjungan']);
        return view('rekam_medis.show', compact('rekamMedis'));
    }

    /**
     * Menampilkan form edit rekam medis.
     */
    public function edit(RekamMedis $rekamMedis)
    {
        // Kita tidak perlu load list pasien/dokter/kunjungan lagi
        // karena data tersebut tidak boleh diubah (sudah terkunci dari kunjungan awal).
        // Dokter hanya boleh mengedit diagnosa/tindakan/keluhan.
        return view('rekam_medis.edit', compact('rekamMedis'));
    }

    /**
     * Mengupdate data rekam medis.
     */
    public function update(Request $request, RekamMedis $rekamMedis)
    {
        $request->validate([
            'keluhan'  => 'required|string',
            'diagnosa' => 'required|string',
            'tindakan' => 'nullable|string',
        ]);
        
        // Hanya update kolom medis, jangan ubah pasien/dokter/kunjungan_id
        $rekamMedis->update($request->only(['keluhan', 'diagnosa', 'tindakan']));
        
        return redirect()->route('rekam_medis.index')
                         ->with('success', 'Data rekam medis berhasil diperbarui.');
    }

    /**
     * Menghapus data rekam medis.
     */
    public function destroy(RekamMedis $rekamMedis)
    {
        // Opsional: Jika rekam medis dihapus, apakah status kunjungan dikembalikan ke 'disetujui'?
        // Untuk saat ini kita biarkan status kunjungannya tetap 'selesai' atau bisa kita ubah manual jika perlu.
        
        $rekamMedis->delete();
        
        return redirect()->route('rekam_medis.index')
                         ->with('success', 'Rekam medis berhasil dihapus.');
    }
}