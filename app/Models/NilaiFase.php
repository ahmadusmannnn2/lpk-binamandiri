<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiFase extends Model
{
    use HasFactory;

    protected $table = 'nilai_fase';

    protected $fillable = [
        'pendaftaran_id',
        'fase_kelas_id',
        'detail_nilai',
        'nilai_rata_rata',
        'catatan_instruktur',
        'status_kelulusan',
    ];

    protected $casts = [
        'detail_nilai' => 'array',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function faseKelas()
    {
        return $this->belongsTo(FaseKelas::class);
    }
}
