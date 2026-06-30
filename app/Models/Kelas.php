<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelas extends Model
{
    use SoftDeletes;

    // Paksa laravel membaca tabel yang benar
    protected $table = 'kelas';
    protected $guarded = ['id'];

    // Relasi: Kelas ini milik Program Pelatihan apa?
    public function programPelatihan()
    {
        return $this->belongsTo(ProgramPelatihan::class, 'program_pelatihan_id');
    }

    // Relasi: Kelas ini diajar oleh Instruktur siapa?
    public function instruktur()
    {
        return $this->belongsTo(Instruktur::class, 'instruktur_id');
    }



    // Relasi: Kelas ini punya banyak pertemuan
    public function pertemuan()
    {
        return $this->hasMany(Pertemuan::class, 'kelas_id');
    }

    // -- TAMBAHKAN INI --
    // Relasi: Kelas ini memiliki banyak pendaftar (peserta)
    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class, 'kelas_id');
    }

    public function fase()
    {
        return $this->hasMany(FaseKelas::class, 'kelas_id')->orderBy('urutan', 'asc');
    }
}