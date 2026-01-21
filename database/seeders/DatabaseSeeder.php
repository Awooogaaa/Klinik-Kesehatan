<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Dokter;
use App\Models\Perawat;
use App\Models\Pasien;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // =====================================================
        // 1. ADMIN (1 akun)
        // =====================================================
        User::create([
            'name' => 'Admin Klinik',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // =====================================================
        // 2. DOKTER (5 akun)
        // =====================================================
        $dokterData = [
            ['name' => 'Dr. Budi Santoso', 'email' => 'dokter1@gmail.com', 'spesialisasi' => 'Umum', 'no_telepon' => '081234567001'],
            ['name' => 'Dr. Siti Rahayu', 'email' => 'dokter2@gmail.com', 'spesialisasi' => 'Anak', 'no_telepon' => '081234567002'],
            ['name' => 'Dr. Ahmad Hidayat', 'email' => 'dokter3@gmail.com', 'spesialisasi' => 'Gigi', 'no_telepon' => '081234567003'],
            ['name' => 'Dr. Dewi Lestari', 'email' => 'dokter4@gmail.com', 'spesialisasi' => 'Kulit', 'no_telepon' => '081234567004'],
            ['name' => 'Dr. Rudi Hartono', 'email' => 'dokter5@gmail.com', 'spesialisasi' => 'Mata', 'no_telepon' => '081234567005'],
        ];

        foreach ($dokterData as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('12345678'),
                'role' => 'dokter',
                'email_verified_at' => now(),
            ]);

            Dokter::create([
                'user_id' => $user->id,
                'spesialisasi' => $data['spesialisasi'],
                'no_telepon' => $data['no_telepon'],
                'alamat' => 'Jl. Kesehatan No. ' . $user->id,
            ]);
        }

        // =====================================================
        // 3. PERAWAT (5 akun - belum di-assign ke dokter)
        // =====================================================
        $perawatData = [
            ['name' => 'Perawat Ani', 'email' => 'perawat1@gmail.com', 'no_telepon' => '081234568001'],
            ['name' => 'Perawat Budi', 'email' => 'perawat2@gmail.com', 'no_telepon' => '081234568002'],
            ['name' => 'Perawat Citra', 'email' => 'perawat3@gmail.com', 'no_telepon' => '081234568003'],
            ['name' => 'Perawat Dini', 'email' => 'perawat4@gmail.com', 'no_telepon' => '081234568004'],
            ['name' => 'Perawat Eko', 'email' => 'perawat5@gmail.com', 'no_telepon' => '081234568005'],
        ];

        foreach ($perawatData as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('12345678'),
                'role' => 'perawat',
                'email_verified_at' => now(),
            ]);

            Perawat::create([
                'user_id' => $user->id,
                'no_telepon' => $data['no_telepon'],
                'alamat' => 'Jl. Perawatan No. ' . $user->id,
            ]);
        }

        // =====================================================
        // 4. PASIEN (5 akun, masing-masing dengan 2 orang)
        // =====================================================
        $pasienAkunData = [
            [
                'name' => 'Keluarga Joko',
                'email' => 'pasien1@gmail.com',
                'anggota' => [
                    ['nama' => 'Joko Widodo', 'hubungan' => 'Diri Sendiri', 'jenis_kelamin' => 'Laki-laki', 'tanggal_lahir' => '1985-06-21'],
                    ['nama' => 'Sri Mulyani', 'hubungan' => 'Suami/Istri', 'jenis_kelamin' => 'Perempuan', 'tanggal_lahir' => '1988-03-15'],
                ],
            ],
            [
                'name' => 'Keluarga Agus',
                'email' => 'pasien2@gmail.com',
                'anggota' => [
                    ['nama' => 'Agus Salim', 'hubungan' => 'Diri Sendiri', 'jenis_kelamin' => 'Laki-laki', 'tanggal_lahir' => '1990-01-10'],
                    ['nama' => 'Rina Agustina', 'hubungan' => 'Suami/Istri', 'jenis_kelamin' => 'Perempuan', 'tanggal_lahir' => '1992-08-22'],
                ],
            ],
            [
                'name' => 'Keluarga Bambang',
                'email' => 'pasien3@gmail.com',
                'anggota' => [
                    ['nama' => 'Bambang Susilo', 'hubungan' => 'Diri Sendiri', 'jenis_kelamin' => 'Laki-laki', 'tanggal_lahir' => '1978-12-05'],
                    ['nama' => 'Putri Bambang', 'hubungan' => 'Anak', 'jenis_kelamin' => 'Perempuan', 'tanggal_lahir' => '2010-04-18'],
                ],
            ],
            [
                'name' => 'Keluarga Dewi',
                'email' => 'pasien4@gmail.com',
                'anggota' => [
                    ['nama' => 'Dewi Sartika', 'hubungan' => 'Diri Sendiri', 'jenis_kelamin' => 'Perempuan', 'tanggal_lahir' => '1995-07-30'],
                    ['nama' => 'Budi Sartika', 'hubungan' => 'Saudara', 'jenis_kelamin' => 'Laki-laki', 'tanggal_lahir' => '1998-11-12'],
                ],
            ],
            [
                'name' => 'Keluarga Eka',
                'email' => 'pasien5@gmail.com',
                'anggota' => [
                    ['nama' => 'Eka Pratama', 'hubungan' => 'Diri Sendiri', 'jenis_kelamin' => 'Laki-laki', 'tanggal_lahir' => '1982-09-25'],
                    ['nama' => 'Nenek Eka', 'hubungan' => 'Orang Tua', 'jenis_kelamin' => 'Perempuan', 'tanggal_lahir' => '1955-02-14'],
                ],
            ],
        ];

        foreach ($pasienAkunData as $akun) {
            // Buat user pasien (pemilik akun)
            $user = User::create([
                'name' => $akun['name'],
                'email' => $akun['email'],
                'password' => Hash::make('12345678'),
                'role' => 'pasien',
                'email_verified_at' => now(),
            ]);

            // Buat data pasien untuk setiap anggota keluarga
            foreach ($akun['anggota'] as $index => $anggota) {
                $pasien = Pasien::create([
                    'user_id' => $user->id,
                    'nama' => $anggota['nama'],
                    'nik' => '32' . str_pad($user->id, 2, '0', STR_PAD_LEFT) . str_pad($index + 1, 2, '0', STR_PAD_LEFT) . '0101900001',
                    'no_telepon' => '0812' . rand(10000000, 99999999),
                    'alamat' => 'Jl. Pasien No. ' . $user->id . '-' . ($index + 1),
                    'tanggal_lahir' => $anggota['tanggal_lahir'],
                    'jenis_kelamin' => $anggota['jenis_kelamin'],
                    'hubungan' => $anggota['hubungan'],
                ]);

                // Generate No. Rekam Medis
                $pasien->no_rekam_medis = $pasien->id;
                $pasien->save();
            }
        }

        // =====================================================
        // SUMMARY
        // =====================================================
        $this->command->info('');
        $this->command->info('========================================');
        $this->command->info('  DATABASE SEEDING COMPLETE!');
        $this->command->info('========================================');
        $this->command->info('');
        $this->command->info('AKUN YANG DIBUAT:');
        $this->command->info('----------------------------------------');
        $this->command->info('1 Admin    : admin@gmail.com');
        $this->command->info('5 Dokter   : dokter1@gmail.com s/d dokter5@gmail.com');
        $this->command->info('5 Perawat  : perawat1@gmail.com s/d perawat5@gmail.com');
        $this->command->info('5 Pasien   : pasien1@gmail.com s/d pasien5@gmail.com');
        $this->command->info('           (masing-masing dengan 2 anggota keluarga)');
        $this->command->info('----------------------------------------');
        $this->command->info('PASSWORD SEMUA AKUN: 12345678');
        $this->command->info('========================================');
        $this->command->info('');
    }
}