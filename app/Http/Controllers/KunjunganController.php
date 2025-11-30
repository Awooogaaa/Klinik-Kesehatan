<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\Dokter;
use Illuminate\Http\Request;

class KunjunganController extends Controller
{
    public function index()
    {
        $kunjungans = Kunjungan::with(['pasien', 'dokter'])->latest()->paginate(10);
        return view('kunjungans.index', compact('kunjungans'));
    }

    public function create()
    {
        $pasiens = Pasien::orderBy('nama')->get();
        // Hanya dokter yang bisa dipilih
        $dokters = Dokter::with('user')->get(); 
        return view('kunjungans.create', compact('pasiens', 'dokters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'keluhan_awal' => 'required|string',
            // Dokter & Waktu bisa null dulu kalau Admin belum setujui saat input awal
            'dokter_id' => 'nullable|exists:dokters,id',
            'waktu_kunjungan' => 'nullable|date',
            'status' => 'required|in:menunggu,disetujui,selesai,batal',
        ]);

        Kunjungan::create($request->all());

        return redirect()->route('kunjungans.index')->with('success', 'Kunjungan berhasil didaftarkan.');
    }

    public function edit(Kunjungan $kunjungan)
    {
        $pasiens = Pasien::orderBy('nama')->get();
        $dokters = Dokter::with('user')->get();
        return view('kunjungans.edit', compact('kunjungan', 'pasiens', 'dokters'));
    }

    public function update(Request $request, Kunjungan $kunjungan)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'keluhan_awal' => 'required|string',
            'dokter_id' => 'nullable|exists:dokters,id',
            'waktu_kunjungan' => 'nullable|date',
            'status' => 'required|in:menunggu,disetujui,selesai,batal',
        ]);

        $kunjungan->update($request->all());

        return redirect()->route('kunjungans.index')->with('success', 'Status kunjungan diperbarui.');
    }

    public function destroy(Kunjungan $kunjungan)
    {
        $kunjungan->delete();
        return redirect()->route('kunjungans.index')->with('success', 'Data dihapus.');
    }
}