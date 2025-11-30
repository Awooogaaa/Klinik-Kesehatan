<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke Kunjungan (PENTING)
            $table->foreignId('kunjungan_id')
                  ->constrained('kunjungans')
                  ->onDelete('cascade');

            // Data Pasien & Dokter diambil otomatis dari Kunjungan, tapi tetap disimpan di sini untuk arsip
            $table->foreignId('pasien_id')->constrained('pasiens')->onDelete('cascade');
            $table->foreignId('dokter_id')->constrained('dokters')->onDelete('cascade');
            
            $table->text('keluhan'); // Bisa diambil dari keluhan_awal atau diedit dokter
            $table->text('diagnosa');
            $table->text('tindakan')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekam_medis');
    }
};