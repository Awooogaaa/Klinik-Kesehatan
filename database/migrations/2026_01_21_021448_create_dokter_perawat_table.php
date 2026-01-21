<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dokter_perawat', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('dokter_id')
                  ->constrained('dokters')
                  ->onDelete('cascade');
            
            $table->foreignId('perawat_id')
                  ->constrained('perawats')
                  ->onDelete('cascade');
            
            // Unique constraint agar tidak ada duplikat assignment
            $table->unique(['dokter_id', 'perawat_id']);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokter_perawat');
    }
};
