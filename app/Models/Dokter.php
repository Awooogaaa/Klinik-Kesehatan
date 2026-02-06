<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    // Lindungi $fillable jika diperlukan
    protected $guarded = ['id'];

    /**
     * Mendapatkan data user (untuk login) yang memiliki profil dokter ini.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class);
    }
    
    public function kunjungans()
    {
        return $this->hasMany(Kunjungan::class);
    }

    /**
     * Relasi one-to-many ke Perawat yang membantu dokter ini.
     * 1 dokter bisa dibantu oleh banyak perawat.
     */
    public function perawats()
    {
        return $this->hasMany(Perawat::class, 'dokter_id');
    }
}