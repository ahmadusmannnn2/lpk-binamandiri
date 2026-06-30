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
            set: function ($value) {
                if (empty($value)) return json_encode([]);
                
                $result = [];
                // Jika input string (dipisah koma)
                if (is_string($value)) {
                    $result = explode(',', $value);
                } 
                // Jika input array (gabungan checkbox & teks tambahan)
                elseif (is_array($value)) {
                    foreach ($value as $item) {
                        if (is_string($item)) {
                            // Pecah lagi jika ada koma di dalam array teks tambahan
                            $pieces = explode(',', $item);
                            $result = array_merge($result, $pieces);
                        }
                    }
                }
                
                return json_encode(array_values(array_filter(array_map('trim', $result))));
            }
        );
    }
}