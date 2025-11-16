<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use App\Models\User;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RekamMedisController extends Controller
{
    /**
     * Menampilkan daftar semua rekam medis.
     */
    public function index()
    {
        // Eager load relasi pasien & dokter (dari tabel users)
        $rekamMedis = RekamMedis::with(['pasien', 'dokter'])
                                ->latest()
                                ->paginate(10);
                                
        return view('rekam_medis.index', compact('rekamMedis'));
    }

    /**
     * Menampilkan form untuk membuat rekam medis baru.
     */
    public function create()
    {
        // Ambil semua data yang diperlukan untuk dropdown form
        $pasiens = User::where('role', 'pasien')->get();
        $dokters = User::where('role', 'dokter')->get();
        $obats = Obat::orderBy('nama_obat')->get();
        
        return view('rekam_medis.create', compact('pasiens', 'dokters', 'obats'));
    }

    /**
     * Menyimpan rekam medis baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi data utama
        $request->validate([
            'pasien_id' => ['required', 'exists:users,id'],
            'dokter_id' => ['required', 'exists:users,id'],
            'tanggal_kunjungan' => ['required', 'date'],
            'keluhan' => ['required', 'string'],
            'diagnosa' => ['required', 'string'],
            'tindakan' => ['nullable', 'string'],
            
            // Validasi untuk resep (obats)
            'obats' => ['nullable', 'array'],
            'obats.*.obat_id' => ['required_with:obats', 'exists:obats,id'],
            'obats.*.jumlah' => ['required_with:obats', 'integer', 'min:1'],
            'obats.*.dosis' => ['required_with:obats', 'string', 'max:255'],
        ]);

        $rekamMedis = null;
        
        DB::transaction(function () use ($request, &$rekamMedis) {
            // 1. Buat data rekam medis utama
            $rekamMedis = RekamMedis::create([
                'pasien_id' => $request->pasien_id,
                'dokter_id' => $request->dokter_id,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
                'keluhan' => $request->keluhan,
                'diagnosa' => $request->diagnosa,
                'tindakan' => $request->tindakan,
            ]);

            // 2. Simpan data resep (jika ada)
            if ($request->has('obats')) {
                $resepData = [];
                foreach ($request->obats as $resep) {
                    // Siapkan data untuk tabel pivot
                    $resepData[$resep['obat_id']] = [
                        'jumlah' => $resep['jumlah'],
                        'dosis' => $resep['dosis'],
                    ];
                }
                // attach() data ke tabel pivot (obat_rekam_medis)
                $rekamMedis->obats()->attach($resepData);
            }
        });

        return redirect()->route('rekam-medis.index')
                         ->with('success', 'Rekam medis berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail rekam medis.
     */

    public function show(RekamMedis $rekamMedi)  // <-- PERBAIKI INI
    {
        // Eager load semua relasi (pasien, dokter, dan obats)
        $rekamMedi->load(['pasien', 'dokter', 'obats']);
        
        return view('rekam_medis.show', ['rekamMedis' => $rekamMedi]);
    }

    /**
     * Menampilkan form untuk mengedit rekam medis.
     */
    public function edit(RekamMedis $rekamMedi)
    {
        // Eager load resep obat yang sudah ada
        $rekamMedi->load('obats');
        
        // Ambil data untuk dropdown
        $pasiens = User::where('role', 'pasien')->get();
        $dokters = User::where('role', 'dokter')->get();
        $obats = Obat::orderBy('nama_obat')->get();
        
        return view('rekam_medis.edit', [
            'rekamMedis' => $rekamMedi,
            'pasiens' => $pasiens,
            'dokters' => $dokters,
            'obats' => $obats,
        ]);
    }

    /**
     * Mengupdate data rekam medis di database.
     */
    public function update(Request $request, RekamMedis $rekamMedi)
    {
        // Validasi
        $request->validate([
            'pasien_id' => ['required', 'exists:users,id'],
            'dokter_id' => ['required', 'exists:users,id'],
            'tanggal_kunjungan' => ['required', 'date'],
            'keluhan' => ['required', 'string'],
            'diagnosa' => ['required', 'string'],
            'tindakan' => ['nullable', 'string'],
            
            'obats' => ['nullable', 'array'],
            'obats.*.obat_id' => ['required_with:obats', 'exists:obats,id'],
            'obats.*.jumlah' => ['required_with:obats', 'integer', 'min:1'],
            'obats.*.dosis' => ['required_with:obats', 'string', 'max:255'],
        ]);
        
        DB::transaction(function () use ($request, $rekamMedi) {
            // 1. Update data rekam medis utama
            $rekamMedi->update([
                'pasien_id' => $request->pasien_id,
                'dokter_id' => $request->dokter_id,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
                'keluhan' => $request->keluhan,
                'diagnosa' => $request->diagnosa,
                'tindakan' => $request->tindakan,
            ]);

            // 2. Siapkan data resep
            $resepData = [];
            if ($request->has('obats')) {
                foreach ($request->obats as $resep) {
                    $resepData[$resep['obat_id']] = [
                        'jumlah' => $resep['jumlah'],
                        'dosis' => $resep['dosis'],
                    ];
                }
            }
            
            // 3. Sinkronkan data resep
            // sync() akan otomatis menambah, update, atau hapus
            // data di tabel pivot sesuai $resepData.
            $rekamMedi->obats()->sync($resepData);
        });
        
        return redirect()->route('rekam-medis.index')
                         ->with('success', 'Rekam medis berhasil diperbarui.');
    }

    /**
     * Menghapus rekam medis dari database.
     */
    public function destroy(RekamMedis $rekamMedi)
    {
        // Hapus data rekam medis
        // Data di tabel pivot 'obat_rekam_medis' akan terhapus
        // otomatis karena onDelete('cascade') di migrasi.
        $rekamMedi->delete();
        
        return redirect()->route('rekam-medis.index')
                         ->with('success', 'Rekam medis berhasil dihapus.');
    }
}