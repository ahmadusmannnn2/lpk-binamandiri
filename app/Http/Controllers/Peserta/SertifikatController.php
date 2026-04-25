<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SertifikatController extends Controller
{
    public function index()
    {
        $peserta = Auth::user()->peserta;
        
        if (!$peserta) {
            return redirect()->route('peserta.biodata.index')->with('error', 'Lengkapi biodata Anda terlebih dahulu.');
        }

        // Hanya mengambil pendaftaran yang status kelulusannya "Lulus"
        $sertifikat = Pendaftaran::with(['kelas.programPelatihan', 'kelas.instruktur.user'])
                        ->where('peserta_id', $peserta->id)
                        ->where('status_kelulusan', 'lulus')
                        ->latest()
                        ->get();

        return view('peserta.sertifikat.index', compact('sertifikat'));
    }

    public function cetak($id)
    {
        $peserta = Auth::user()->peserta;

        // Ambil data kelulusan spesifik, pastikan itu milik user yang sedang login
        $pendaftaran = Pendaftaran::with(['peserta.user', 'kelas.programPelatihan'])
                        ->where('id', $id)
                        ->where('peserta_id', $peserta->id)
                        ->where('status_kelulusan', 'lulus')
                        ->firstOrFail();

        // Kita gunakan layout khusus cetak (tanpa navbar/sidebar)
        return view('peserta.sertifikat.cetak', compact('pendaftaran'));
    }
}