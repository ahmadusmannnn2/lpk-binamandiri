<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peserta extends Model
{
    use SoftDeletes;

    protected $table = 'peserta';
    protected $guarded = ['id']; // Memperbolehkan isi semua kolom kecuali ID

    // Relasi balik ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}