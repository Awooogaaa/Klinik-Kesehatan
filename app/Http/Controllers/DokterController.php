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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', ValidationRules\Password::defaults()],
            'spesialisasi' => ['required', 'string', 'max:255'],
            'no_telepon' => ['required', 'string', 'max:20'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'], // Validasi Foto (Max 2MB)
        ]);

        DB::transaction(function () use ($request) {
            // 1. Upload Foto jika ada
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                // Simpan di folder 'public/fotos-dokter'
                $fotoPath = $request->file('foto')->store('fotos-dokter', 'public');
            }

            // 2. Buat data user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'dokter',
            ]);

            // 3. Buat data dokter
            $user->dokter()->create([
                'spesialisasi' => $request->spesialisasi,
                'no_telepon' => $request->no_telepon,
                'foto' => $fotoPath, // Simpan path foto
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
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($dokter->user_id)],
                'spesialisasi' => ['required', 'string', 'max:255'],
                'no_telepon' => ['required', 'string', 'max:20'],
                'password' => ['nullable', 'confirmed', ValidationRules\Password::defaults()],
                'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'], // Validasi Foto
            ]);

            DB::transaction(function () use ($request, $dokter) {
                // 1. Update data User
                $dokter->user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                ]);

                // 2. Cek apakah password diupdate
                if ($request->filled('password')) {
                    $dokter->user->update([
                        'password' => Hash::make($request->password),
                    ]);
                }

                // 3. Handle Update Foto
                $dataDokter = [
                    'spesialisasi' => $request->spesialisasi,
                    'no_telepon' => $request->no_telepon,
                ];

                if ($request->hasFile('foto')) {
                    // Hapus foto lama jika ada
                    if ($dokter->foto && Storage::disk('public')->exists($dokter->foto)) {
                        Storage::disk('public')->delete($dokter->foto);
                    }

                    // Upload foto baru
                    $dataDokter['foto'] = $request->file('foto')->store('fotos-dokter', 'public');
                }

                // 4. Update tabel dokter
                $dokter->update($dataDokter);
            });

            return redirect()->route('dokters.index')
                            ->with('success', 'Data dokter berhasil diperbarui.');
        }

    /**
     * Menghapus data dokter dari database.
     */
     public function destroy(Dokter $dokter)
    {
        // Hapus file foto dari storage jika ada
        if ($dokter->foto && Storage::disk('public')->exists($dokter->foto)) {
            Storage::disk('public')->delete($dokter->foto);
        }

        // Hapus data User (Dokter ikut terhapus karena cascade)
        $dokter->user->delete();

        return redirect()->route('dokters.index')
                         ->with('success', 'Dokter berhasil dihapus.');
    }
}