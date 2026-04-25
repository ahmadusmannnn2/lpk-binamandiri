<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instruktur extends Model
{
    use SoftDeletes;

    protected $table = 'instruktur';
    protected $guarded = ['id'];

    // Relasi balik ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}