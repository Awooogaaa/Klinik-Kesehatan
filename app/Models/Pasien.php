<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    // Lindungi $fillable jika diperlukan
    protected $guarded = ['id'];

    /**
     * Mendapatkan data user (untuk login) yang memiliki profil pasien ini.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}