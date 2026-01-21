<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RekamMedis extends Model
{
    use HasFactory;

    /**
     * Mass assignment protection.
     */
    protected $guarded = ['id'];

    /**
     * Relasi ke User (Pasien).
     * Satu rekam medis dimiliki oleh satu pasien.
     */
    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    /**
     * Relasi ke User (Dokter).
     * Satu rekam medis dibuat oleh satu dokter.
     */
    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    /**
     * Relasi ke Kunjungan.
     */
    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class);
    }

    /**
     * Relasi ke User yang menginput rekam medis.
     */
    public function inputBy()
    {
        return $this->belongsTo(User::class, 'input_by_user_id');
    }

    /**
     * Relasi ke Tindakan Medis (suntik, infus, dll).
     */
    public function tindakanMedis(): HasMany
    {
        return $this->hasMany(TindakanRekamMedis::class);
    }

    /**
     * Helper untuk menghitung total biaya.
     * Total = Biaya Pemeriksaan + Total Tindakan Medis
     */
    public function getTotalBiayaAttribute(): int
    {
        $biayaPemeriksaan = $this->biaya_pemeriksaan ?? 0;
        $biayaTindakan = $this->tindakanMedis->sum('biaya');
        return $biayaPemeriksaan + $biayaTindakan;
    }
}