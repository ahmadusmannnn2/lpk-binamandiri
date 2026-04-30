<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Jangan lupa tambahkan role di sini
        'avatar', // <-- Tambahkan ini
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ke tabel Peserta (1 User = 1 Peserta)
    public function peserta()
    {
        return $this->hasOne(Peserta::class);
    }

    // Relasi ke tabel Instruktur (1 User = 1 Instruktur)
    public function instruktur()
    {
        return $this->hasOne(Instruktur::class);
    }
}