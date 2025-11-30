<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kunjungans', function (Blueprint $table) {
            $table->id();
            // Relasi ke Pasien & Dokter
            $table->foreignId('pasien_id')->constrained('pasiens')->onDelete('cascade');
            $table->foreignId('dokter_id')->nullable()->constrained('dokters')->onDelete('set null');
            
            $table->text('keluhan_awal'); // Contoh: Sakit Perut
            $table->dateTime('waktu_kunjungan')->nullable(); // Tanggal & Jam dijadwalkan
            
            // Status alur: 
            // 1. Menunggu (Pasien baru daftar)
            // 2. Disetujui (Admin sudah tentukan jam)
            // 3. Selesai (Sudah diperiksa dokter)
            // 4. Batal
            $table->enum('status', ['menunggu', 'disetujui', 'selesai', 'batal'])->default('menunggu');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kunjungans');
    }
};