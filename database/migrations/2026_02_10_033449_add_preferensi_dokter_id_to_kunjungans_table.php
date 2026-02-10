<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            $table->foreignId('preferensi_dokter_id')->nullable()->after('dokter_id')->constrained('dokters')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            $table->dropForeign(['preferensi_dokter_id']);
            $table->dropColumn('preferensi_dokter_id');
        });
    }
};
