<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $table = 'pendaftaran';
    protected $guarded = ['id'];

    // Beritahu Laravel agar kolom ini diperlakukan sebagai Array
    protected $casts = [
        'detail_nilai' => 'array',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}