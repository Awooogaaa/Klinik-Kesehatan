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
        // 1. Validasi Data Pasien
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'no_telepon' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'string'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', Rule::in(['Laki-laki', 'Perempuan'])],
            
            // Email tidak boleh unique, karena kita mau pakai ulang email yang sudah ada
            'email' => ['nullable', 'string', 'email', 'max:255'], 
            
            // Password wajib hanya jika email belum terdaftar di sistem
            'password' => ['nullable', 'confirmed', ValidationRules\Password::defaults()],
        ]);

        DB::transaction(function () use ($request) {
            $userId = null;

            if ($request->filled('email')) {
                // Cek apakah email sudah ada di database?
                $existingUser = User::where('email', $request->email)->first();

                if ($existingUser) {
                    // SKENARIO A: Akun Sudah Ada (Family Account)
                    // Langsung sambungkan pasien ini ke user tersebut
                    $userId = $existingUser->id;
                } else {
                    // SKENARIO B: Akun Belum Ada (New Account)
                    // Buatkan user baru
                    
                    // Pastikan password diisi karena ini akun baru
                    if (!$request->filled('password')) {
                        throw \Illuminate\Validation\ValidationException::withMessages([
                            'password' => 'Password wajib diisi untuk pembuatan akun baru.',
                        ]);
                    }

                    $newUser = User::create([
                        'name' => $request->nama, // Nama akun pakai nama pasien pertama
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'role' => 'pasien',
                    ]);
                    $userId = $newUser->id;
                }
            }

            // Buat Data Pasien
            $pasien = Pasien::create([
                'user_id' => $userId,
                'nama' => $request->nama,
                'no_telepon' => $request->no_telepon,
                'alamat' => $request->alamat,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
            ]);

            // Generate No. RM
            $pasien->no_rekam_medis = $pasien->id;
            $pasien->save();
        });

        return redirect()->route('pasiens.index')->with('success', 'Pasien berhasil ditambahkan.');
    }

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
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'no_telepon' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'string'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', Rule::in(['Laki-laki', 'Perempuan'])],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'password' => ['nullable', 'confirmed', ValidationRules\Password::defaults()],
        ]);

        DB::transaction(function () use ($request, $pasien) {
            // Update Data Pasien
            $pasien->update([
                'nama' => $request->nama,
                'no_telepon' => $request->no_telepon,
                'alamat' => $request->alamat,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
            ]);

            // Logika Akun
            if ($request->filled('email')) {
                // Cek email inputan milik siapa?
                $targetUser = User::where('email', $request->email)->first();

                if ($targetUser) {
                    // Jika email sudah ada, pindahkan pasien ini ke akun pemilik email tersebut (Gabung Keluarga)
                    $pasien->update(['user_id' => $targetUser->id]);
                    
                    // Opsional: Jika ingin update password akun induk (hati-hati, ini mengubah password 1 keluarga)
                    if ($request->filled('password')) {
                        $targetUser->update(['password' => Hash::make($request->password)]);
                    }
                } else {
                    // Jika email belum ada
                    if ($pasien->user) {
                        // Jika pasien punya akun lama, update email akun lamanya
                        $pasien->user->update(['email' => $request->email]);
                        if ($request->filled('password')) {
                            $pasien->user->update(['password' => Hash::make($request->password)]);
                        }
                    } else {
                        // Jika pasien belum punya akun sama sekali, buatkan baru
                        $newUser = User::create([
                            'name' => $request->nama,
                            'email' => $request->email,
                            'password' => Hash::make($request->password ?? 'password123'),
                            'role' => 'pasien',
                        ]);
                        $pasien->update(['user_id' => $newUser->id]);
                    }
                }
            }
        });

        return redirect()->route('pasiens.index')->with('success', 'Data pasien diperbarui.');
    }
    /**
     * Menghapus data pasien dari database (Delete).
     */
    public function destroy(Pasien $pasien)
    {
        // Hati-hati menghapus User, karena mungkin dipakai pasien lain (saudaranya)
        // Jadi kita cek dulu: Apakah user ini punya pasien lain selain yang mau dihapus?
        
        $user = $pasien->user;
        $pasien->delete(); // Hapus pasien target
        
        if ($user) {
            // Hitung sisa pasien yang dimiliki user ini
            $sisaPasien = Pasien::where('user_id', $user->id)->count();
            
            // Jika sudah tidak ada pasien lain yang nyantol, baru hapus akunnya
            if ($sisaPasien == 0) {
                $user->delete();
            }
        }

        return redirect()->route('pasiens.index')->with('success', 'Data pasien dihapus.');
    }
}