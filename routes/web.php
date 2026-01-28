<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PerawatController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\PembayaranController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;




Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-midtrans', [\App\Http\Controllers\TestMidtransController::class, 'index']);


// Untuk Callback Midtrans (Harus diluar middleware auth & csrf)
Route::post('/midtrans/callback', [PembayaranController::class, 'callback']);
Route::get('/bayar', [PembayaranController::class, 'bayar']);


// Group Auth
Route::middleware('auth')->group(function () {
    
    // Route untuk Pasien (Lihat Nota)
    Route::get('/pembayaran/{id}', [PembayaranController::class, 'show'])->name('pembayarans.show');

    // Group Khusus Admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/pembayarans', [PembayaranController::class, 'index'])->name('pembayarans.index');
        Route::post('/admin/pembayarans/{id}/confirm', [PembayaranController::class, 'confirmOffline'])->name('pembayarans.confirmOffline');
    });

});

// Group Auth Umum
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- GROUP SHARED: ADMIN, DOKTER & PERAWAT ---
Route::middleware(['auth', 'role:admin,dokter,perawat'])->group(function () {
    // Rekam Medis (Perawat juga bisa akses)
    Route::resource('rekam_medis', RekamMedisController::class);
});

Route::middleware(['auth', 'role:admin,dokter'])->group(function () {
    Route::resource('kunjungans', KunjunganController::class);
});

// --- GROUP KHUSUS ADMIN ---
Route::middleware(['auth', 'role:admin'])->group(function () {
    
    // Dashboard Khusus Admin
    Route::get('/admin-dashboard', function () {

        // 2. DATA CHART KUNJUNGAN
        // Syarat: Ada Waktu Kunjungan, Tahun Ini, DAN SUDAH ADA REKAM MEDIS
        $kunjungans = \App\Models\Kunjungan::has('rekamMedis') // <--- FILTER UTAMA
            ->whereNotNull('waktu_kunjungan')
            ->whereYear('waktu_kunjungan', date('Y'))
            ->get();

        // Logic Pengelompokan Bulan (Sama seperti sebelumnya)
        $grouped = $kunjungans->groupBy(function($item) {
            // Kita pakai parse agar aman meskipun format databasenya string
            return Carbon::parse($item->waktu_kunjungan)->format('n');
        });

        $chartData = [];
        $maxKunjungan = 0;
        
        $namaBulan = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
            7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];

        for ($i = 1; $i <= 12; $i++) {
            $count = isset($grouped[$i]) ? $grouped[$i]->count() : 0;
            if ($count > $maxKunjungan) $maxKunjungan = $count;
            
            $chartData[] = [
                'label' => $namaBulan[$i],
                'count' => $count
            ];
        }

        if ($maxKunjungan == 0) $maxKunjungan = 1;

        return view('admin-dashboard', compact('chartData', 'maxKunjungan'));

    })->name('admin-dashboard');

    // Manajemen User (Hanya Admin)
    Route::resource('pasiens', PasienController::class); 
    
    // Track Record Dokter (harus sebelum resource untuk menghindari konflik dengan {dokter})
    Route::get('/dokters/trackrecord', [DokterController::class, 'trackRecord'])->name('dokters.trackrecord');
    Route::resource('dokters', DokterController::class);
    
    // Manajemen Perawat (Hanya Admin)
    Route::get('/perawats/{perawat}/assign', [PerawatController::class, 'assignForm'])->name('perawats.assign');
    Route::post('/perawats/{perawat}/assign', [PerawatController::class, 'assign'])->name('perawats.assign.store');
    Route::resource('perawats', PerawatController::class);
});



// --- GROUP KHUSUS DOKTER ---
Route::middleware(['auth', 'role:dokter'])->group(function () {
    // Dashboard Khusus Dokter
    Route::get('/dokter-dashboard', function () {
        return view('dokter-dashboard');
    })->name('dokter-dashboard');
});

// --- GROUP KHUSUS PERAWAT ---
Route::middleware(['auth', 'role:perawat'])->group(function () {
    // Dashboard Khusus Perawat
    Route::get('/perawat-dashboard', [PerawatController::class, 'dashboard'])->name('perawat-dashboard');
});

// --- GROUP KHUSUS PASIEN ---
Route::middleware(['auth', 'role:pasien'])->group(function () {
    Route::get('/landingpage-pasien', [PasienController::class, 'landingpage'])->name('pasiens.landingpage');
    Route::post('/landingpage-pasien/keluarga', [PasienController::class, 'storeKeluarga'])->name('pasiens.storeKeluarga');
    Route::post('/landingpage-pasien/kunjungan', [PasienController::class, 'storeKunjungan'])->name('pasiens.storeKunjungan');
    Route::delete('/landingpage-pasien/kunjungan/{kunjungan}', [PasienController::class, 'destroyKunjungan'])->name('pasiens.destroyKunjungan');
    Route::get('/landingpage-pasien/nota/{id}', [PasienController::class, 'nota'])->name('pasiens.nota');
});

// --- GROUP KHUSUS ADMIN ---
Route::middleware(['auth', 'role:admin'])->group(function () {
    
    // ... route admin lainnya ...

    // Route Manajemen Pembayaran
    Route::get('/admin/pembayarans', [PembayaranController::class, 'index'])->name('pembayarans.index');
    Route::post('/admin/pembayarans/{id}/confirm', [PembayaranController::class, 'confirmOffline'])->name('pembayarans.confirmOffline');
    Route::delete('/admin/pembayarans/{id}', [PembayaranController::class, 'destroy'])->name('pembayarans.destroy');
    
    // Route Nota untuk Admin (bisa akses nota semua pasien)
    Route::get('/admin/nota/{id}', [PasienController::class, 'nota'])->name('admin.nota');

});

require __DIR__.'/auth.php';