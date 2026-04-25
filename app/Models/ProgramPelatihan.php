<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Tambahkan ini untuk fitur Hapus Aman

class ProgramPelatihan extends Model
{
    use SoftDeletes; // Aktifkan fitur Hapus Aman

    // 1. Beritahu Laravel nama tabel yang benar secara spesifik
    protected $table = 'program_pelatihan';

    // 2. Izinkan pengisian data massal (kecuali ID)
    protected $guarded = ['id'];
}