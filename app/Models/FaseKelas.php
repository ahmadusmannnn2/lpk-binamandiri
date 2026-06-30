<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaseKelas extends Model
{
    use HasFactory;

    protected $table = 'fase_kelas';

    protected $fillable = [
        'kelas_id',
        'nama_fase',
        'urutan',
        'target_pertemuan',
        'status',
        'kriteria_penilaian',
    ];

    protected $casts = [
        'kriteria_penilaian' => 'array',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function pertemuan()
    {
        return $this->hasMany(Pertemuan::class);
    }

    public function nilaiFase()
    {
        return $this->hasMany(NilaiFase::class);
    }
}
