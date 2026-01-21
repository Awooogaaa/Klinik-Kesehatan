<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tindakan_rekam_medis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rekam_medis_id')
                  ->constrained('rekam_medis')
                  ->onDelete('cascade');
            
            $table->string('nama_tindakan'); // Contoh: Suntik, Infus Nutrisi
            $table->text('keterangan')->nullable();
            $table->integer('biaya')->default(0);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tindakan_rekam_medis');
    }
};
