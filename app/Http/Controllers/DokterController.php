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
        // 1. Validasi Input
        $request->validate([
            // Data Akun
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', ValidationRules\Password::defaults()],
            
            // Data Dokter
            'spesialisasi' => ['required', 'string', 'max:255'],
            'no_telepon' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'string'],
            'foto' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'], // Wajib ada foto
        ]);

        DB::transaction(function () use ($request) {
            // 2. Upload Foto
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('fotos-dokter', 'public');
            }

            // 3. Buat Akun User (Login)
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'dokter',
            ]);

            // 4. Simpan Data Profil Dokter
            $user->dokter()->create([
                'spesialisasi' => $request->spesialisasi,
                'no_telepon' => $request->no_telepon,
                'alamat' => $request->alamat,
                'foto' => $fotoPath,
            ]);
        });

        return redirect()->route('dokters.index')->with('success', 'Dokter dan akun berhasil ditambahkan.');
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
            'alamat' => ['required', 'string'],
            'password' => ['nullable', 'confirmed', ValidationRules\Password::defaults()],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        DB::transaction(function () use ($request, $dokter) {
            // Update User
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];
            
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            
            $dokter->user->update($userData);

            // Update Data Dokter
            $dokterData = [
                'spesialisasi' => $request->spesialisasi,
                'no_telepon' => $request->no_telepon,
                'alamat' => $request->alamat,
            ];

            // Handle Ganti Foto
            if ($request->hasFile('foto')) {
                // Hapus foto lama
                if ($dokter->foto && Storage::disk('public')->exists($dokter->foto)) {
                    Storage::disk('public')->delete($dokter->foto);
                }
                $dokterData['foto'] = $request->file('foto')->store('fotos-dokter', 'public');
            }

            $dokter->update($dokterData);
        });

        return redirect()->route('dokters.index')->with('success', 'Data dokter diperbarui.');
    }

    /**
     * Menghapus data dokter dari database.
     */
     public function destroy(Dokter $dokter)
    {
        if ($dokter->foto && Storage::disk('public')->exists($dokter->foto)) {
            Storage::disk('public')->delete($dokter->foto);
        }
        
        $dokter->user->delete(); // Hapus user, dokter ikut terhapus (cascade)

        return redirect()->route('dokters.index')->with('success', 'Dokter dihapus.');
    }
}