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
     * Relasi many-to-many ke Perawat yang membantu dokter ini.
     */
    public function perawats()
    {
        return $this->belongsToMany(Perawat::class, 'dokter_perawat')
                    ->withTimestamps();
    }
}