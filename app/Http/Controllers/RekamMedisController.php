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
        // Eager load relasi yang dibutuhkan untuk tabel index
        $rekamMedis = RekamMedis::with(['pasien', 'dokter.user', 'kunjungan'])->latest()->paginate(10);
        return view('rekam_medis.index', compact('rekamMedis'));
    }

    public function create()
    {
        // Ambil kunjungan yang disetujui & belum diperiksa
        $kunjungans = Kunjungan::with(['pasien', 'dokter.user'])
            ->where('status', 'disetujui')
            ->whereDoesntHave('rekamMedis') 
            ->orderBy('waktu_kunjungan', 'asc')
            ->get();

        // Ambil data obat untuk dropdown resep
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
            // Validasi Array Obat
            'obats'        => 'nullable|array',
            'obats.*.obat_id' => 'required|exists:obats,id',
            'obats.*.jumlah'  => 'required|integer|min:1',
            'obats.*.dosis'   => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            $kunjungan = Kunjungan::findOrFail($request->kunjungan_id);

            // 1. Simpan Rekam Medis Utama
            $rekamMedis = RekamMedis::create([
                'kunjungan_id' => $kunjungan->id,
                'pasien_id'    => $kunjungan->pasien_id,
                'dokter_id'    => $kunjungan->dokter_id,
                'keluhan'      => $request->keluhan,
                'diagnosa'     => $request->diagnosa,
                'tindakan'     => $request->tindakan,
            ]);

            // 2. Simpan Resep Obat (Many-to-Many)
            if ($request->has('obats')) {
                foreach ($request->obats as $resep) {
                    $rekamMedis->obats()->attach($resep['obat_id'], [
                        'jumlah' => $resep['jumlah'],
                        'dosis'  => $resep['dosis'],
                    ]);
                }
            }

            // 3. Update Status Kunjungan
            $kunjungan->update(['status' => 'selesai']);
        });

        return redirect()->route('rekam_medis.index')
                         ->with('success', 'Pemeriksaan selesai dan resep obat tersimpan.');
    }

    public function edit(RekamMedis $rekamMedis)
    {
        // Load data obat yang sudah ada di resep ini
        $rekamMedis->load(['obats', 'pasien', 'dokter.user', 'kunjungan']);
        
        // Ambil master data obat untuk pilihan tambahan
        $obats = Obat::orderBy('nama_obat')->get();

        return view('rekam_medis.edit', compact('rekamMedis', 'obats'));
    }

    public function update(Request $request, RekamMedis $rekamMedis)
    {
        $request->validate([
            'keluhan'      => 'required|string',
            'diagnosa'     => 'required|string',
            'tindakan'     => 'nullable|string',
            'obats'        => 'nullable|array',
            'obats.*.obat_id' => 'required|exists:obats,id',
            'obats.*.jumlah'  => 'required|integer|min:1',
            'obats.*.dosis'   => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($request, $rekamMedis) {
            // 1. Update Data Medis
            $rekamMedis->update($request->only(['keluhan', 'diagnosa', 'tindakan']));

            // 2. Sync Resep Obat (Hapus yang lama, ganti yang baru sesuai input form)
            $syncData = [];
            if ($request->has('obats')) {
                foreach ($request->obats as $resep) {
                    // Format untuk sync: [obat_id => ['jumlah' => x, 'dosis' => y]]
                    $syncData[$resep['obat_id']] = [
                        'jumlah' => $resep['jumlah'],
                        'dosis'  => $resep['dosis'],
                    ];
                }
            }
            $rekamMedis->obats()->sync($syncData);
        });

        return redirect()->route('rekam_medis.index')
                         ->with('success', 'Data rekam medis dan resep berhasil diperbarui.');
    }

    public function show(RekamMedis $rekamMedis)
    {
        $rekamMedis->load(['pasien', 'dokter.user', 'obats', 'kunjungan']);
        return view('rekam_medis.show', compact('rekamMedis'));
    }

    public function destroy(RekamMedis $rekamMedis)
    {
        $rekamMedis->delete();
        return redirect()->route('rekam_medis.index')->with('success', 'Data dihapus.');
    }
}