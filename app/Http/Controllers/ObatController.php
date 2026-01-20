<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // <-- Import ini

class ObatController extends Controller
{
    /**
     * Menampilkan daftar semua obat (Read).
     */
    public function index(Request $request)
    {
        $query = Obat::query();

        // Search by nama_obat or satuan
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_obat', 'like', "%{$search}%")
                  ->orWhere('satuan', 'like', "%{$search}%");
            });
        }

        // Price range filter
        if ($request->filled('harga_min')) {
            $query->where('harga', '>=', $request->harga_min);
        }
        if ($request->filled('harga_max')) {
            $query->where('harga', '<=', $request->harga_max);
        }

        $obats = $query->latest()->paginate(10)->withQueryString();
        return view('obats.index', compact('obats'));
    }

    /**
     * Menampilkan form untuk membuat obat baru (Create).
     */
    public function create()
    {
        return view('obats.create');
    }

    /**
     * Menyimpan data obat baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'nama_obat' => ['required', 'string', 'max:255', 'unique:obats'],
            'satuan' => ['required', 'string', 'max:100'],
            'stok' => ['required', 'integer', 'min:0'],
            'harga' => ['required', 'integer', 'min:0'],
        ]);

        // Buat data
        Obat::create($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('obats.index')
                         ->with('success', 'Obat berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satu obat (Opsional, kita ganti ke edit).
     */
    public function show(Obat $obat)
    {
        // Kita bisa langsung ke edit, jadi method ini bisa dikosongi
        return redirect()->route('obats.edit', $obat);
    }

    /**
     * Menampilkan form untuk mengedit obat (Update).
     */
    public function edit(Obat $obat)
    {
        return view('obats.edit', compact('obat'));
    }

    /**
     * Mengupdate data obat di database.
     */
    public function update(Request $request, Obat $obat)
    {
        // Validasi data
        $request->validate([
            'nama_obat' => ['required', 'string', 'max:255', Rule::unique('obats')->ignore($obat->id)],
            'satuan' => ['required', 'string', 'max:100'],
            'stok' => ['required', 'integer', 'min:0'],
            'harga' => ['required', 'integer', 'min:0'],
        ]);

        // Update data
        $obat->update($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('obats.index')
                         ->with('success', 'Data obat berhasil diperbarui.');
    }

    /**
     * Menghapus data obat dari database (Delete).
     */
    public function destroy(Obat $obat)
    {
        $obat->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('obats.index')
                         ->with('success', 'Obat berhasil dihapus.');
    }
}