<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // <-- TAMBAHKAN INI

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Hapus atau komentari factory user bawaan
        // User::factory(10)->create();
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // 1. Buat Akun Admin
        User::create([
            'name' => 'Admin Klinik',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'), // Ganti password ini
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // 2. Buat Akun Dokter
        User::create([
            'name' => 'Dr. Budi',
            'email' => 'dokter@gmail.com',
            'password' => Hash::make('12345678'), // Ganti password ini
            'role' => 'dokter',
            'email_verified_at' => now(),
        ]);

        // 3. Buat Akun Pasien
        User::create([
            'name' => 'Pasien A',
            'email' => 'pasien@gmail.com',
            'password' => Hash::make('12345678'), // Ganti password ini
            'role' => 'pasien',
            'email_verified_at' => now(),
        ]);
    }
}