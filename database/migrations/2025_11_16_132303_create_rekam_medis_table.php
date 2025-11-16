<?php

use Illuminate\Database\Migrations\Migration; // <-- INI YANG HILANG
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id();

            // Relasi ke Pasien (dari tabel users)
            $table->foreignId('pasien_id')->constrained('users')->onDelete('cascade');
            
            // Relasi ke Dokter (dari tabel users)
            $table->foreignId('dokter_id')->constrained('users')->onDelete('cascade');

            $table->dateTime('tanggal_kunjungan');
            $table->text('keluhan');
            $table->text('diagnosa');
            $table->text('tindakan')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_medis');
    }
};