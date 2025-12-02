<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\User; // <-- Import User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <-- Import DB
use Illuminate\Support\Facades\Hash; // <-- Import Hash
use Illuminate\Validation\Rule; // <-- Import Rule
use Illuminate\Validation\Rules as ValidationRules; // <-- Import ValidationRules

class DokterController extends Controller
{
    /**
     * Menampilkan daftar semua dokter.
     */
    public function index()
    {
        $dokters = Dokter::with('user')->latest()->paginate(10);
        return view('dokters.index', compact('dokters'));
    }

    /**
     * Menampilkan form untuk membuat dokter baru.
     */
    public function create()
    {
        return view('dokters.create');
    }

    /**
     * Menyimpan data dokter baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi (no_str dihapus)
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', ValidationRules\Password::defaults()],
            'spesialisasi' => ['required', 'string', 'max:255'],
            'no_telepon' => ['required', 'string', 'max:20'],
        ]);

        DB::transaction(function () use ($request) {
            // 1. Buat data user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'dokter',
            ]);

            // 2. Buat data dokter (no_str dihapus)
            $user->dokter()->create([
                'spesialisasi' => $request->spesialisasi,
                'no_telepon' => $request->no_telepon,
            ]);
        });

        return redirect()->route('dokters.index')
                         ->with('success', 'Dokter berhasil ditambahkan.');
    }

    public function edit(Dokter $dokter)
    {
        $dokter->load('user'); 
        return view('dokters.edit', compact('dokter'));
    }

    /**
     * Mengupdate data dokter di database.
     */
   /**
     * Mengupdate data dokter di database.
     */
    public function update(Request $request, Dokter $dokter)
    {
        // Validasi (no_str dihapus)
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($dokter->user_id)],
            'spesialisasi' => ['required', 'string', 'max:255'],
            'no_telepon' => ['required', 'string', 'max:20'],
            'password' => ['nullable', 'confirmed', ValidationRules\Password::defaults()],
        ]);

        DB::transaction(function () use ($request, $dokter) {
            // 1. Update data di tabel users
            $dokter->user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // 2. Update data di tabel dokters (no_str dihapus)
            $dokter->update([
                'spesialisasi' => $request->spesialisasi,
                'no_telepon' => $request->no_telepon,
            ]);

            // 3. (Opsional) Update password
            if ($request->filled('password')) {
                $dokter->user->update([
                    'password' => Hash::make($request->password),
                ]);
            }
        });

        return redirect()->route('dokters.index')
                         ->with('success', 'Data dokter berhasil diperbarui.');
    }

    /**
     * Menghapus data dokter dari database.
     */
    public function destroy(Dokter $dokter)
    {
        // Hapus data User, data Dokter akan terhapus otomatis via cascade
        $dokter->user->delete();

        return redirect()->route('dokters.index')
                         ->with('success', 'Dokter berhasil dihapus.');
    }
}