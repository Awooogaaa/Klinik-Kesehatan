<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\User;
use App\Models\Kunjungan;
use App\Models\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules as ValidationRules;
use Illuminate\Support\Facades\Auth;

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

    public function storeKunjungan(Request $request)
    {
        // 1. Validasi HANYA pasien_id dan keluhan (Dokter & Waktu dihapus)
        $request->validate([
            'pasien_id' => ['required', 'exists:pasiens,id'],
            'keluhan_awal' => ['required', 'string'],
        ]);

        // 2. Security Check
        $pasien = Pasien::where('id', $request->pasien_id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        // 3. Simpan Kunjungan (dokter_id & waktu_kunjungan null dulu)
        Kunjungan::create([
            'pasien_id' => $pasien->id,
            'dokter_id' => null,          // Biarkan null, nanti Admin yang atur
            'waktu_kunjungan' => null,    // Biarkan null, nanti Admin yang atur jadwal
            'keluhan_awal' => $request->keluhan_awal,
            'status' => 'menunggu',       // Status awal menunggu konfirmasi admin
        ]);

        return redirect()->route('pasiens.landingpage')->with('success', 'Pengajuan kunjungan berhasil dikirim. Admin akan segera menentukan jadwal dan dokter untuk Anda.');
    }

    public function storeKeluarga(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'no_telepon' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'string'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', \Illuminate\Validation\Rule::in(['Laki-laki', 'Perempuan'])],
        ]);

        DB::transaction(function () use ($request) {
            $pasien = Pasien::create([
                'user_id' => Auth::id(), // Link otomatis ke akun yang sedang login
                'nama' => $request->nama,
                'no_telepon' => $request->no_telepon,
                'alamat' => $request->alamat,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
            ]);

            // Generate No. RM (Sederhana: pakai ID)
            $pasien->no_rekam_medis = $pasien->id;
            $pasien->save();
        });

        return redirect()->route('pasiens.landingpage')->with('success', 'Anggota keluarga berhasil ditambahkan.');
    }

   public function landingpage() 
{
    $user = Auth::user();
    $keluarga = Pasien::where('user_id', $user->id)->get();
    $keluargaIds = $keluarga->pluck('id');

    // Eager Load diperbaiki: 'dokter.user' agar bisa ambil nama dari tabel users jika perlu
    $riwayat = Kunjungan::with(['dokter.user', 'pasien', 'rekamMedis.obats']) 
                ->whereIn('pasien_id', $keluargaIds)
                ->latest()
                ->get();

    return view('pasiens.landingpage', compact('keluarga', 'riwayat'));
}

    public function nota($id)
    {
        // Ambil data kunjungan berdasarkan ID
        $kunjungan = Kunjungan::with(['pasien', 'dokter.user', 'rekamMedis.obats'])->findOrFail($id);

        // Security: Pastikan yang melihat nota adalah pemilik pasien
        if ($kunjungan->pasien->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak melihat nota ini.');
        }

        // Cek apakah rekam medis sudah ada
        if (!$kunjungan->rekamMedis) {
            return back()->with('error', 'Rekam medis belum tersedia.');
        }

        return view('pasiens.nota', compact('kunjungan'));
    }

    public function destroyKunjungan(Kunjungan $kunjungan)
    {
        // 1. Cek apakah yang menghapus adalah pemilik pasien tersebut (Security)
        if ($kunjungan->pasien->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // 2. Cek apakah jadwal sudah diatur (status bukan menunggu)
        if ($kunjungan->status !== 'menunggu') {
            return back()->with('error', 'Kunjungan tidak bisa dihapus karena jadwal sudah diatur oleh admin.');
        }

        // 3. Hapus
        $kunjungan->delete();

        return back()->with('success', 'Pengajuan kunjungan berhasil dibatalkan.');
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