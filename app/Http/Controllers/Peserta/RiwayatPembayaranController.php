<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Auth;

class RiwayatPembayaranController extends Controller
{
    public function index()
    {
        $peserta = Auth::user()->peserta;

        if (!$peserta) {
            return redirect()->route('peserta.biodata.index')->with('error', 'Silakan lengkapi biodata terlebih dahulu.');
        }

        // Ambil riwayat pembayaran (semua status)
        $riwayatPembayaran = Pendaftaran::with(['kelas.programPelatihan'])
            ->where('peserta_id', $peserta->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('peserta.pembayaran.riwayat', compact('riwayatPembayaran'));
    }
}
