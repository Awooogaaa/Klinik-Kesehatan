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
     * Relasi ke Dokter yang dibantu (one-to-many: 1 perawat hanya bisa bantu 1 dokter).
     */
    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }

    /**
     * Cek apakah perawat ini membantu dokter tertentu.
     */
    public function membantuDokter($dokterId): bool
    {
        return $this->dokter_id === (int) $dokterId;
    }

    /**
     * Cek apakah perawat bisa mengakses kunjungan tertentu.
     * Perawat hanya bisa akses kunjungan yang dokternya dia bantu.
     */
    public function bisaAksesKunjungan($kunjungan): bool
    {
        return $this->dokter_id === $kunjungan->dokter_id;
    }

    /**
     * Ambil semua kunjungan yang bisa diakses perawat ini.
     */
    public function kunjungansDapatDiakses()
    {
        if (!$this->dokter_id) {
            return \App\Models\Kunjungan::whereRaw('1 = 0'); // Tidak ada akses
        }
        return \App\Models\Kunjungan::where('dokter_id', $this->dokter_id);
    }
}
