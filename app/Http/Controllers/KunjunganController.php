<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\Dokter;
use Illuminate\Http\Request;

class KunjunganController extends Controller
{
    public function index(Request $request)
    {
        $query = Kunjungan::with(['pasien', 'dokter.user']);

        // Filter by logged-in dokter if user has dokter role
        $user = auth()->user();
        if ($user && $user->role === 'dokter') {
            $dokter = Dokter::where('user_id', $user->id)->first();
            if ($dokter) {
                $query->where('dokter_id', $dokter->id);
            } else {
                // Dokter profile not found, show empty
                $query->whereRaw('1 = 0');
            }
        }

        // Search by pasien name, keluhan, or dokter name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('pasien', function($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                })
                ->orWhere('keluhan_awal', 'like', "%{$search}%")
                ->orWhereHas('dokter.user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            });
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('waktu_kunjungan', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('waktu_kunjungan', '<=', $request->date_to);
        }

        $kunjungans = $query->latest()->paginate(10)->withQueryString();
        return view('kunjungans.index', compact('kunjungans'));
    }

    public function create()
    {
        // Dokter tidak bisa menambah kunjungan baru
        $user = auth()->user();
        if ($user && $user->role === 'dokter') {
            return redirect()->route('kunjungans.index')->with('error', 'Dokter tidak memiliki akses untuk menambah kunjungan baru.');
        }
        
        $pasiens = Pasien::orderBy('nama')->get();
        // Hanya dokter yang bisa dipilih
        $dokters = Dokter::with('user')->get(); 
        return view('kunjungans.create', compact('pasiens', 'dokters'));
    }

    public function store(Request $request)
    {
        // Dokter tidak bisa menambah kunjungan baru
        $user = auth()->user();
        if ($user && $user->role === 'dokter') {
            return redirect()->route('kunjungans.index')->with('error', 'Dokter tidak memiliki akses untuk menambah kunjungan baru.');
        }
        
        $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'keluhan_awal' => 'required|string',
            // Dokter & Waktu bisa null dulu kalau Admin belum setujui saat input awal
            'dokter_id' => 'nullable|exists:dokters,id',
            'waktu_kunjungan' => 'nullable|date|after:now',
            'status' => 'required|in:menunggu,disetujui,selesai,batal',
        ], [
            'waktu_kunjungan.after' => 'Tanggal dan jam periksa tidak boleh sebelum waktu sekarang.',
        ]);

        // Cek konflik jadwal dokter (jika dokter dan waktu sudah ditentukan)
        if ($request->filled('dokter_id') && $request->filled('waktu_kunjungan')) {
            $existingKunjungan = Kunjungan::where('dokter_id', $request->dokter_id)
                ->where('waktu_kunjungan', $request->waktu_kunjungan)
                ->whereNotIn('status', ['batal', 'selesai']) // Abaikan yang sudah batal/selesai
                ->exists();

            if ($existingKunjungan) {
                return back()->withErrors([
                    'waktu_kunjungan' => 'Dokter sudah memiliki jadwal kunjungan pada waktu tersebut. Silakan pilih waktu lain.'
                ])->withInput();
            }
        }

        Kunjungan::create($request->all());

        return redirect()->route('kunjungans.index')->with('success', 'Kunjungan berhasil didaftarkan.');
    }

    public function edit(Kunjungan $kunjungan)
    {
        $pasiens = Pasien::orderBy('nama')->get();
        $dokters = Dokter::with('user')->get();
        $hasRekamMedis = $kunjungan->rekamMedis()->exists();
        
        // Check if user is dokter
        $user = auth()->user();
        $isDokter = $user && $user->role === 'dokter';
        
        return view('kunjungans.edit', compact('kunjungan', 'pasiens', 'dokters', 'hasRekamMedis', 'isDokter'));
    }

    public function update(Request $request, Kunjungan $kunjungan)
    {
        $hasRekamMedis = $kunjungan->rekamMedis()->exists();
        $user = auth()->user();
        $isDokter = $user && $user->role === 'dokter';
        
        // Validasi khusus untuk dokter
        if ($isDokter) {
            // Dokter tidak bisa mengubah status ke menunggu
            if ($request->status === 'menunggu') {
                return back()->withErrors([
                    'status' => 'Dokter tidak dapat memilih status Menunggu.'
                ])->withInput();
            }
            
            // Dokter tidak bisa mengubah dokter_id
            // Force use original dokter_id value
            $request->merge([
                'dokter_id' => $kunjungan->dokter_id,
            ]);
        }
        
        // Jika rekam medis sudah ada, status tidak boleh diubah
        if ($hasRekamMedis && $request->status !== $kunjungan->status) {
            return back()->withErrors([
                'status' => 'Status tidak dapat diubah karena rekam medis sudah tercatat untuk kunjungan ini.'
            ])->withInput();
        }
        
        // Jika rekam medis belum ada, status 'selesai' tidak boleh dipilih
        if (!$hasRekamMedis && $request->status === 'selesai') {
            return back()->withErrors([
                'status' => 'Status selesai tidak dapat dipilih karena rekam medis belum tercatat.'
            ])->withInput();
        }
        
        // Jika status batal, dokter dan waktu tidak diperlukan
        if ($request->status === 'batal') {
            $request->validate([
                'pasien_id' => 'required|exists:pasiens,id',
                'keluhan_awal' => 'required|string',
                'status' => 'required|in:menunggu,disetujui,selesai,batal',
            ]);
            
            $kunjungan->update([
                'pasien_id' => $request->pasien_id,
                'keluhan_awal' => $request->keluhan_awal,
                'status' => 'batal',
                'dokter_id' => null,
                'waktu_kunjungan' => null,
            ]);
            
            return redirect()->route('kunjungans.index')->with('success', 'Kunjungan dibatalkan.');
        }
        
        $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'keluhan_awal' => 'required|string',
            'dokter_id' => 'required|exists:dokters,id',
            'waktu_kunjungan' => 'required|date|after:now',
            'status' => 'required|in:menunggu,disetujui,selesai,batal',
        ], [
            'waktu_kunjungan.after' => 'Tanggal dan jam periksa tidak boleh sebelum waktu sekarang.',
        ]);

        // Cek konflik jadwal dokter (exclude kunjungan ini sendiri)
        $existingKunjungan = Kunjungan::where('dokter_id', $request->dokter_id)
            ->where('waktu_kunjungan', $request->waktu_kunjungan)
            ->where('id', '!=', $kunjungan->id) // Exclude current kunjungan
            ->whereNotIn('status', ['batal', 'selesai']) // Abaikan yang sudah batal/selesai
            ->exists();

        if ($existingKunjungan) {
            return back()->withErrors([
                'waktu_kunjungan' => 'Dokter sudah memiliki jadwal kunjungan pada waktu tersebut. Silakan pilih waktu lain.'
            ])->withInput();
        }

        $kunjungan->update($request->all());

        return redirect()->route('kunjungans.index')->with('success', 'Status kunjungan diperbarui.');
    }

    public function destroy(Kunjungan $kunjungan)
    {
        $kunjungan->delete();
        return redirect()->route('kunjungans.index')->with('success', 'Data dihapus.');
    }
}