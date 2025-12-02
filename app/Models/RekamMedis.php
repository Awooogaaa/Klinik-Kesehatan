<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
     * Relasi many-to-many ke Obat (Resep).
     * Satu rekam medis bisa memiliki banyak obat.
     */
    public function obats(): BelongsToMany
    {
        return $this->belongsToMany(Obat::class, 'obat_rekam_medis')
                    ->withPivot('jumlah', 'dosis'); // Penting!
    }

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class);
    }
}