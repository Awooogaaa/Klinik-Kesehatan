<?php

namespace App\Http\Controllers;

use App\Models\Perawat;
use App\Models\Dokter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules as ValidationRules;

class PerawatController extends Controller
{
    /**
     * Dashboard untuk Perawat.
     */
    public function dashboard()
    {
        $user = auth()->user();
        $perawat = $user->perawat;
        
        if (!$perawat) {
            abort(404, 'Data perawat tidak ditemukan.');
        }
        
        $perawat->load('dokters.user');
        
        // Statistik
        $dokterIds = $perawat->dokters->pluck('id');
        $totalRekamMedisHariIni = \App\Models\RekamMedis::whereIn('dokter_id', $dokterIds)
            ->whereDate('created_at', today())
            ->count();
        
        $totalKunjunganMenunggu = \App\Models\Kunjungan::whereIn('dokter_id', $dokterIds)
            ->where('status', 'menunggu')
            ->count();
        
        // Kunjungan yang perlu diinput rekam medisnya
        $kunjungansPerluInput = \App\Models\Kunjungan::with(['pasien', 'dokter.user'])
            ->whereIn('dokter_id', $dokterIds)
            ->where('status', 'selesai')
            ->whereDoesntHave('rekamMedis')
            ->latest()
            ->take(10)
            ->get();
        
        return view('perawat-dashboard', compact('perawat', 'totalRekamMedisHariIni', 'totalKunjunganMenunggu', 'kunjungansPerluInput'));
    }

    /**
     * Menampilkan daftar semua perawat.
     */
    public function index(Request $request)
    {
        $query = Perawat::with(['user', 'dokters.user']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $perawats = $query->latest()->paginate(10)->withQueryString();
        return view('perawats.index', compact('perawats'));
    }

    /**
     * Menampilkan form untuk membuat perawat baru.
     */
    public function create()
    {
        $dokters = Dokter::with('user')->get();
        return view('perawats.create', compact('dokters'));
    }

    /**
     * Menyimpan data perawat baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', ValidationRules\Password::defaults()],
            'no_telepon' => ['required', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'dokter_ids' => ['nullable', 'array'],
            'dokter_ids.*' => ['exists:dokters,id'],
        ]);

        DB::transaction(function () use ($request) {
            // Upload Foto
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('fotos-perawat', 'public');
            }

            // Buat Akun User (Role: perawat)
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'perawat',
            ]);

            // Simpan Data Profil Perawat
            $perawat = $user->perawat()->create([
                'no_telepon' => $request->no_telepon,
                'alamat' => $request->alamat,
                'foto' => $fotoPath,
            ]);

            // Assign Dokter yang dibantu
            if ($request->has('dokter_ids')) {
                $perawat->dokters()->sync($request->dokter_ids);
            }
        });

        return redirect()->route('perawats.index')->with('success', 'Perawat berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail perawat.
     */
    public function show(Perawat $perawat)
    {
        $perawat->load(['user', 'dokters.user']);
        return view('perawats.show', compact('perawat'));
    }

    /**
     * Menampilkan form untuk edit perawat.
     */
    public function edit(Perawat $perawat)
    {
        $perawat->load(['user', 'dokters']);
        $dokters = Dokter::with('user')->get();
        $assignedDokterIds = $perawat->dokters->pluck('id')->toArray();
        return view('perawats.edit', compact('perawat', 'dokters', 'assignedDokterIds'));
    }

    /**
     * Mengupdate data perawat di database.
     */
    public function update(Request $request, Perawat $perawat)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($perawat->user_id)],
            'no_telepon' => ['required', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
            'password' => ['nullable', 'confirmed', ValidationRules\Password::defaults()],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'dokter_ids' => ['nullable', 'array'],
            'dokter_ids.*' => ['exists:dokters,id'],
        ]);

        DB::transaction(function () use ($request, $perawat) {
            // Update User
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];
            
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            
            $perawat->user->update($userData);

            // Update Data Perawat
            $perawatData = [
                'no_telepon' => $request->no_telepon,
                'alamat' => $request->alamat,
            ];

            // Handle Ganti Foto
            if ($request->hasFile('foto')) {
                if ($perawat->foto && Storage::disk('public')->exists($perawat->foto)) {
                    Storage::disk('public')->delete($perawat->foto);
                }
                $perawatData['foto'] = $request->file('foto')->store('fotos-perawat', 'public');
            }

            $perawat->update($perawatData);

            // Update Dokter yang dibantu
            $perawat->dokters()->sync($request->dokter_ids ?? []);
        });

        return redirect()->route('perawats.index')->with('success', 'Data perawat diperbarui.');
    }

    /**
     * Menghapus data perawat dari database.
     */
    public function destroy(Perawat $perawat)
    {
        if ($perawat->foto && Storage::disk('public')->exists($perawat->foto)) {
            Storage::disk('public')->delete($perawat->foto);
        }
        
        $perawat->user->delete(); // Hapus user, perawat ikut terhapus (cascade)

        return redirect()->route('perawats.index')->with('success', 'Perawat dihapus.');
    }

    /**
     * Menampilkan form untuk assign dokter ke perawat.
     */
    public function assignForm(Perawat $perawat)
    {
        $perawat->load('dokters');
        $dokters = Dokter::with('user')->get();
        $assignedDokterIds = $perawat->dokters->pluck('id')->toArray();
        return view('perawats.assign', compact('perawat', 'dokters', 'assignedDokterIds'));
    }

    /**
     * Menyimpan assignment dokter ke perawat.
     */
    public function assign(Request $request, Perawat $perawat)
    {
        $request->validate([
            'dokter_ids' => ['nullable', 'array'],
            'dokter_ids.*' => ['exists:dokters,id'],
        ]);

        $perawat->dokters()->sync($request->dokter_ids ?? []);

        return redirect()->route('perawats.index')->with('success', 'Penugasan dokter berhasil diperbarui.');
    }
}
