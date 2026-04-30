<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute; 

class ProgramPelatihan extends Model
{
    use SoftDeletes;

    protected $table = 'program_pelatihan';
    
    // Mengizinkan semua kolom diisi (termasuk durasi_hari yang baru kita buat)
    protected $guarded = ['id'];

    // MESIN PINTAR: Mengubah input "1F, 2F, 3F" menjadi Array JSON secara otomatis saat disimpan
    protected function parameterPenilaian(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true) ?? [],
            set: fn ($value) => is_string($value) 
                ? json_encode(array_values(array_filter(array_map('trim', explode(',', $value))))) 
                : json_encode($value ?? []),
        );
    }
}