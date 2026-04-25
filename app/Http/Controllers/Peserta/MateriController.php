<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Auth;

class MateriController extends Controller
{
    public function index()
    {
        $peserta = Auth::user()->peserta;

        // Ambil kelas yang pendaftarannya "Disetujui" beserta relasi materi di dalamnya
        $pendaftaran = Pendaftaran::with(['kelas.programPelatihan', 'kelas.materi', 'kelas.instruktur.user'])
                        ->where('peserta_id', $peserta->id)
                        ->where('status_pendaftaran', 'disetujui')
                        ->latest()
                        ->get();

        return view('peserta.materi.index', compact('pendaftaran'));
    }
}