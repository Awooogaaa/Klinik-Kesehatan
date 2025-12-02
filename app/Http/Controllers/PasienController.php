<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\User; // <-- Import User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <-- Import DB
use Illuminate\Support\Facades\Hash; // <-- Import Hash
use Illuminate\Validation\Rule; // <-- Import Rule
use Illuminate\Validation\Rules as ValidationRules; // <-- Import ValidationRules

class PasienController extends Controller
{
    /**
     * Menampilkan daftar semua pasien (Read).
     */
    public function index()
    {
        // Kita pakai `with('user')` untuk mengambil data relasi (nama, email)
        $pasiens = Pasien::with('user')->latest()->paginate(10);
        return view('pasiens.index', compact('pasiens'));
    }

    /**
     * Menampilkan form untuk membuat pasien baru (Create).
     */
    public function create()
    {
        return view('pasiens.create');
    }

    /**
     * Menyimpan data pasien baru ke database.
     */
   public function store(Request $request)
    {
        // 1. Validasi (pastikan 'no_rekam_medis' sudah dihapus dari sini)
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', ValidationRules\Password::defaults()],
            'no_telepon' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'string'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', Rule::in(['Laki-laki', 'Perempuan'])],
        ]);

        $pasien = null; // Inisialisasi variabel pasien

        DB::transaction(function () use ($request, &$pasien) {
            // 2. Buat data user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'pasien',
            ]);

            // 3. Buat data pasien
            $pasien = $user->pasien()->create([
                'no_telepon' => $request->no_telepon,
                'alamat' => $request->alamat,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                // 'no_rekam_medis' masih null di sini
            ]);

            // --- INI BAGIAN YANG BERUBAH ---
            // 4. Buat No. RM otomatis (langsung pakai ID-nya sendiri)
            $pasien->no_rekam_medis = $pasien->id;
            $pasien->save();
            // ---------------------------------
        });

        // Update juga pesan suksesnya
        return redirect()->route('pasiens.index')
                         ->with('success', 'Pasien berhasil ditambahkan. No. RM: ' . $pasien->no_rekam_medis);
    }
    /**
     * Menampilkan form untuk mengedit pasien (Update).
     */
    public function edit(Pasien $pasien)
    {
        // $pasien->load('user') akan mengambil data user yang terelasi
        // sehingga di view kita bisa panggil $pasien->user->name
        $pasien->load('user'); 
        return view('pasiens.edit', compact('pasien'));
    }

    /**
     * Mengupdate data pasien di database.
     */
   public function update(Request $request, Pasien $pasien)
    {
        // 1. Validasi (HAPUS 'no_rekam_medis' dari sini)
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($pasien->user_id)],
            'no_telepon' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'string'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', Rule::in(['Laki-laki', 'Perempuan'])],
            'password' => ['nullable', 'confirmed', ValidationRules\Password::defaults()],
        ]);

        DB::transaction(function () use ($request, $pasien) {
            // 2. Update data users
            $pasien->user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // 3. Update data pasiens (HAPUS 'no_rekam_medis' dari sini)
            $pasien->update([
                'no_telepon' => $request->no_telepon,
                'alamat' => $request->alamat,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
            ]);

            // ... (Update password jika ada)
            if ($request->filled('password')) {
                // ...
            }
        });

        return redirect()->route('pasiens.index')
                         ->with('success', 'Data pasien berhasil diperbarui.');
    }
    /**
     * Menghapus data pasien dari database (Delete).
     */
    public function destroy(Pasien $pasien)
    {
        // Kita hanya perlu hapus data User.
        // Data Pasien akan terhapus otomatis karena kita
        // sudah setting `onDelete('cascade')` di file migrasi.
        $pasien->user->delete();

        return redirect()->route('pasiens.index')
                         ->with('success', 'Pasien berhasil dihapus.');
    }
}