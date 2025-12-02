<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Obat extends Model
{
    use HasFactory;

    /**
     * Mass assignment protection.
     */
    protected $guarded = ['id'];

    /**
     * Relasi many-to-many ke RekamMedis.
     * Sebuah obat bisa ada di banyak rekam medis (resep).
     */
    public function rekamMedis(): BelongsToMany
    {
        return $this->belongsToMany(RekamMedis::class, 'obat_rekam_medis')
                    ->withPivot('jumlah', 'dosis'); // Penting!
    }
}