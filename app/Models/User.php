<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // <-- TAMBAHKAN 'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- (OPSIONAL TAPI DISARANKAN) FUNGSI HELPER ROLE ---

    /**
     * Cek apakah user adalah admin.
     */
    public function Admin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Cek apakah user adalah dokter.
     */
    public function dokter()
    {
        return $this->hasOne(Dokter::class, 'user_id');
    }

    /**
     * Cek apakah user adalah pasien.
     */
    public function pasien()
    {
        return $this->hasOne(Pasien::class, 'user_id');
    }
}