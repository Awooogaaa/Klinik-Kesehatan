<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TindakanRekamMedis extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Relasi ke Rekam Medis
     */
    public function rekamMedis()
    {
        return $this->belongsTo(RekamMedis::class);
    }
}
