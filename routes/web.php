<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\KunjunganController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Group Auth Umum (Login, Logout, Profile bisa diakses semua user yang login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- GROUP 1: ADMIN & DOKTER (Akses Dashboard & Medis) ---
Route::middleware(['auth', 'role:admin,dokter'])->group(function () {
    
    // Dashboard untuk Admin & Dokter
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Menu yang bisa diakses Admin DAN Dokter
    Route::resource('obats', ObatController::class);
    Route::resource('rekam_medis', RekamMedisController::class);
    Route::resource('kunjungans', KunjunganController::class);
});

// --- GROUP 2: KHUSUS ADMIN (Akses Manajemen User) ---
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Admin bisa mengelola data Master Pasien dan Dokter
    Route::resource('pasiens', PasienController::class); 
    Route::resource('dokters', DokterController::class);
});

// --- GROUP 3: KHUSUS PASIEN (Portal Pasien) ---
Route::middleware(['auth', 'role:pasien'])->group(function () {
    
    Route::get('/landingpage-pasien', [PasienController::class, 'landingpage'])->name('pasiens.landingpage');
    Route::post('/landingpage-pasien/keluarga', [PasienController::class, 'storeKeluarga'])->name('pasiens.storeKeluarga');
    Route::post('/landingpage-pasien/kunjungan', [PasienController::class, 'storeKunjungan'])->name('pasiens.storeKunjungan');
    Route::delete('/landingpage-pasien/kunjungan/{kunjungan}', [PasienController::class, 'destroyKunjungan'])->name('pasiens.destroyKunjungan');
    Route::get('/landingpage-pasien/nota/{id}', [PasienController::class, 'nota'])->name('pasiens.nota');

});

require __DIR__.'/auth.php';