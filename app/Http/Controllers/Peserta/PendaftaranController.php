<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    public function index()
    {
        $peserta = Auth::user()->peserta;
        
        // Cekapakah biodata krusial masih kosong?
        if (!$peserta->nik || !$peserta->pas_foto || !$peserta->nomor_telepon) {
            // Lempar ke halaman biodata dengan pesan error
            return redirect()->route('peserta.biodata.index')->with('error', 'PENTING: Anda wajib melengkapi Biodata Diri dan Pas Foto terlebih dahulu sebelum mendaftar kelas!');
        }

        // Ambil kelas yang statusnya 'menunggu' untuk bisa mendaftar
        $kelasTersedia = Kelas::with(['programPelatihan', 'instruktur.user'])
                            ->where('status_kelas', 'menunggu')
                            ->latest()->get();

        // Ambil riwayat pendaftaran peserta ini
        $riwayatDaftar = Pendaftaran::with('kelas.programPelatihan')
                            ->where('peserta_id', $peserta->id)
                            ->latest()->get();

        return view('peserta.pendaftaran.index', compact('kelasTersedia', 'riwayatDaftar'));
    }

    public function create($kelas_id)
    {
        $kelas = Kelas::with('programPelatihan')->findOrFail($kelas_id);
        $peserta = Auth::user()->peserta;

        // Cek apakah sudah pernah daftar di kelas ini
        $sudahDaftar = Pendaftaran::where('peserta_id', $peserta->id)
                                  ->where('kelas_id', $kelas_id)
                                  ->exists();
        
        if ($sudahDaftar) {
            return redirect()->route('peserta.pendaftaran.index')->with('error', 'Anda sudah mendaftar di kelas ini.');
        }

        return view('peserta.pendaftaran.create', compact('kelas'));
    }

    public function store(Request $request, $kelas_id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $peserta = Auth::user()->peserta;

        // Upload Bukti
        $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

        Pendaftaran::create([
            'peserta_id' => $peserta->id,
            'kelas_id' => $kelas_id,
            'tanggal_daftar' => now(),
            'bukti_pembayaran' => $buktiPath,
            'status_pendaftaran' => 'menunggu_verifikasi',
        ]);

        return redirect()->route('peserta.pendaftaran.index')->with('success', 'Pendaftaran berhasil! Menunggu verifikasi Admin.');
    }
}