<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pertemuan extends Model
{
    protected $table = 'pertemuan';
    protected $guarded = ['id'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'pertemuan_id');
    }

    public function faseKelas()
    {
        return $this->belongsTo(FaseKelas::class, 'fase_kelas_id');
    }
}