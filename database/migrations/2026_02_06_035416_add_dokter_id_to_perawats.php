<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Mengubah relasi many-to-many ke one-to-many
     * 1 perawat hanya bisa membantu 1 dokter
     */
    public function up(): void
    {
        // 1. Tambah kolom dokter_id di tabel perawats
        Schema::table('perawats', function (Blueprint $table) {
            $table->foreignId('dokter_id')
                  ->nullable()
                  ->after('user_id')
                  ->constrained('dokters')
                  ->onDelete('set null');
        });

        // 2. Migrasi data dari tabel pivot ke kolom baru
        // Ambil assignment pertama untuk setiap perawat (kalau ada multiple)
        $assignments = DB::table('dokter_perawat')
            ->select('perawat_id', DB::raw('MIN(dokter_id) as dokter_id'))
            ->groupBy('perawat_id')
            ->get();

        foreach ($assignments as $assignment) {
            DB::table('perawats')
                ->where('id', $assignment->perawat_id)
                ->update(['dokter_id' => $assignment->dokter_id]);
        }

        // 3. Hapus tabel pivot (opsional, bisa dikomen jika ingin backup dulu)
        Schema::dropIfExists('dokter_perawat');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Recreate tabel pivot
        Schema::create('dokter_perawat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dokter_id')->constrained('dokters')->onDelete('cascade');
            $table->foreignId('perawat_id')->constrained('perawats')->onDelete('cascade');
            $table->unique(['dokter_id', 'perawat_id']);
            $table->timestamps();
        });

        // 2. Migrasi data balik dari kolom ke tabel pivot
        $perawats = DB::table('perawats')
            ->whereNotNull('dokter_id')
            ->get();

        foreach ($perawats as $perawat) {
            DB::table('dokter_perawat')->insert([
                'dokter_id' => $perawat->dokter_id,
                'perawat_id' => $perawat->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. Hapus kolom dokter_id
        Schema::table('perawats', function (Blueprint $table) {
            $table->dropForeign(['dokter_id']);
            $table->dropColumn('dokter_id');
        });
    }
};
