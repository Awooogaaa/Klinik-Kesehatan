<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perawat extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Relasi ke User (akun login).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi many-to-many ke Dokter yang dibantu.
     */
    public function dokters()
    {
        return $this->belongsToMany(Dokter::class, 'dokter_perawat')
                    ->withTimestamps();
    }

    /**
     * Cek apakah perawat ini membantu dokter tertentu.
     */
    public function membantudokter($dokterId): bool
    {
        return $this->dokters()->where('dokter_id', $dokterId)->exists();
    }

    /**
     * Cek apakah perawat bisa mengakses kunjungan tertentu.
     * Perawat hanya bisa akses kunjungan yang dokternya dia bantu.
     */
    public function bisaAksesKunjungan($kunjungan): bool
    {
        return $this->dokters()->where('dokter_id', $kunjungan->dokter_id)->exists();
    }

    /**
     * Ambil semua kunjungan yang bisa diakses perawat ini.
     */
    public function kunjungansDapatDiakses()
    {
        $dokterIds = $this->dokters()->pluck('dokters.id');
        return \App\Models\Kunjungan::whereIn('dokter_id', $dokterIds);
    }
}
