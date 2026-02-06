<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ubah enum status untuk menambahkan 'pending_konfirmasi'
        DB::statement("ALTER TABLE kunjungans MODIFY COLUMN status ENUM('menunggu', 'disetujui', 'selesai', 'batal', 'pending_konfirmasi') DEFAULT 'menunggu'");
        
        // Tambah kolom untuk menyimpan waktu kunjungan lama (sebelum diubah dokter)
        Schema::table('kunjungans', function (Blueprint $table) {
            $table->dateTime('waktu_kunjungan_lama')->nullable()->after('waktu_kunjungan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan enum ke nilai awal
        DB::statement("ALTER TABLE kunjungans MODIFY COLUMN status ENUM('menunggu', 'disetujui', 'selesai', 'batal') DEFAULT 'menunggu'");
        
        // Hapus kolom waktu_kunjungan_lama
        Schema::table('kunjungans', function (Blueprint $table) {
            $table->dropColumn('waktu_kunjungan_lama');
        });
    }
};
