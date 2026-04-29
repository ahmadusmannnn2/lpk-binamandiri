<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MateriController extends Controller
{
    public function index()
    {
        $peserta = Auth::user()->peserta;

        if (!$peserta) {
            return redirect()->route('peserta.biodata.index')->with('error', 'Lengkapi biodata Anda terlebih dahulu.');
        }

        // PERBAIKAN: Ambil relasi "kelas.pertemuan" karena file materi sekarang menempel di pertemuan
        $pendaftaran = Pendaftaran::with(['kelas.programPelatihan', 'kelas.instruktur.user', 'kelas.pertemuan'])
                        ->where('peserta_id', $peserta->id)
                        ->where('status_pendaftaran', 'disetujui')
                        ->get();

        return view('peserta.materi.index', compact('pendaftaran'));
    }
}