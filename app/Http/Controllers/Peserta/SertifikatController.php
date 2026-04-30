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

        // Hanya mengambil sertifikat yang Lulus DAN Nomor Sertifikatnya sudah ada (JSON)
        $sertifikat = Pendaftaran::with(['kelas.programPelatihan', 'kelas.instruktur.user'])
                        ->where('peserta_id', $peserta->id)
                        ->where('status_kelulusan', 'lulus')
                        ->whereNotNull('detail_nilai->nomor_sertifikat') // Filter JSON baru
                        ->latest()
                        ->get();

        return view('peserta.sertifikat.index', compact('sertifikat'));
    }

    public function cetak($id)
    {
        $peserta = Auth::user()->peserta;

        $pendaftaran = Pendaftaran::with(['peserta.user', 'kelas.programPelatihan', 'kelas.instruktur.user'])
                        ->where('id', $id)
                        ->where('peserta_id', $peserta->id)
                        ->where('status_kelulusan', 'lulus')
                        ->whereNotNull('detail_nilai->nomor_sertifikat') // Pastikan hanya yg sudah ada nomornya yg bisa dicetak
                        ->firstOrFail();

        $nomorSertifikat = $pendaftaran->detail_nilai['nomor_sertifikat'];

        // Alihkan ke file View cetak yang sama dengan milik Admin agar desainnya sinkron!
        return view('admin.sertifikat.cetak', compact('pendaftaran', 'nomorSertifikat'));
    }
}