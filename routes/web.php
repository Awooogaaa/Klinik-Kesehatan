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

// Group Auth Umum
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- GROUP SHARED: ADMIN & DOKTER (Resource yang bisa diakses keduanya) ---
Route::middleware(['auth', 'role:admin,dokter'])->group(function () {
    // Resource yang digunakan bersama
    Route::resource('obats', ObatController::class);
    Route::resource('rekam_medis', RekamMedisController::class);
    Route::resource('kunjungans', KunjunganController::class);
});

// --- GROUP KHUSUS ADMIN ---
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard Khusus Admin
    Route::get('/admin-dashboard', function () {
        return view('admin-dashboard');
    })->name('admin-dashboard');

    // Manajemen User (Hanya Admin)
    Route::resource('pasiens', PasienController::class); 
    Route::resource('dokters', DokterController::class);
});

// --- GROUP KHUSUS DOKTER ---
Route::middleware(['auth', 'role:dokter'])->group(function () {
    // Dashboard Khusus Dokter
    Route::get('/dokter-dashboard', function () {
        return view('dokter-dashboard');
    })->name('dokter-dashboard');
});

// --- GROUP KHUSUS PASIEN ---
Route::middleware(['auth', 'role:pasien'])->group(function () {
    Route::get('/landingpage-pasien', [PasienController::class, 'landingpage'])->name('pasiens.landingpage');
    Route::post('/landingpage-pasien/keluarga', [PasienController::class, 'storeKeluarga'])->name('pasiens.storeKeluarga');
    Route::post('/landingpage-pasien/kunjungan', [PasienController::class, 'storeKunjungan'])->name('pasiens.storeKunjungan');
    Route::delete('/landingpage-pasien/kunjungan/{kunjungan}', [PasienController::class, 'destroyKunjungan'])->name('pasiens.destroyKunjungan');
    Route::get('/landingpage-pasien/nota/{id}', [PasienController::class, 'nota'])->name('pasiens.nota');
});

require __DIR__.'/auth.php';