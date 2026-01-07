<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah kolom harga di tabel obats
        Schema::table('obats', function (Blueprint $table) {
            $table->integer('harga')->default(0)->after('stok');
        });

        // 2. Tambah kolom biaya_jasa di tabel dokters (opsional, bisa hardcode jika mau)
        Schema::table('dokters', function (Blueprint $table) {
            $table->integer('biaya_jasa')->default(50000);
        });

        // 3. Buat tabel pembayarans
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kunjungan_id')->constrained()->onDelete('cascade');
            $table->string('order_id')->unique(); // ID Unik untuk Midtrans
            $table->integer('total_harga');
            $table->enum('status_pembayaran', ['pending', 'lunas', 'batal'])->default('pending');
            $table->enum('metode_pembayaran', ['online', 'offline'])->nullable(); // online (midtrans) atau offline (cash)
            $table->string('snap_token')->nullable(); // Token dari Midtrans
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
        Schema::table('obats', function (Blueprint $table) {
            $table->dropColumn('harga');
        });
        Schema::table('dokters', function (Blueprint $table) {
            $table->dropColumn('biaya_jasa');
        });
    }
};