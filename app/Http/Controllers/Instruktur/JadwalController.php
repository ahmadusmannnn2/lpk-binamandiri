<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    // Menampilkan daftar kelas yang diajar
    public function index()
    {
        $instruktur = Auth::user()->instruktur;
        if (!$instruktur) abort(403, 'Profil Instruktur tidak ditemukan.');

        $kelas = Kelas::with('programPelatihan')
                      ->where('instruktur_id', $instruktur->id)
                      ->latest()
                      ->get();

        return view('instruktur.jadwal.index', compact('kelas'));
    }

    // Menampilkan detail peserta
    public function show($id)
    {
        $instruktur = Auth::user()->instruktur;
        $kelas = Kelas::with('programPelatihan')->where('id', $id)->where('instruktur_id', $instruktur->id)->firstOrFail();

        $pesertaKelas = Pendaftaran::with('peserta.user')
                                   ->where('kelas_id', $id)
                                   ->where('status_pendaftaran', 'disetujui')
                                   ->get();

        return view('instruktur.jadwal.show', compact('kelas', 'pesertaKelas'));
    }

    // Menyimpan inputan nilai massal
    public function simpanNilai(Request $request, $id)
    {
        $request->validate([
            'nilai.*.kehadiran' => 'required|numeric|min:0|max:100',
            'nilai.*.nilai_teori' => 'required|numeric|min:0|max:100',
            'nilai.*.nilai_praktik' => 'required|numeric|min:0|max:100',
            'nilai.*.status_kelulusan' => 'required|in:belum_dinilai,lulus,tidak_lulus',
        ]);

        if($request->has('nilai')) {
            foreach ($request->nilai as $pendaftaran_id => $data) {
                Pendaftaran::where('id', $pendaftaran_id)->update([
                    'kehadiran' => $data['kehadiran'],
                    'nilai_teori' => $data['nilai_teori'],
                    'nilai_praktik' => $data['nilai_praktik'],
                    'status_kelulusan' => $data['status_kelulusan'],
                ]);
            }
        }

        return redirect()->route('instruktur.jadwal.show', $id)->with('success', 'Data Kehadiran dan Nilai berhasil disimpan!');
    }

    // --- FITUR BARU: CETAK PDF ---
    public function cetak($id)
    {
        $instruktur = Auth::user()->instruktur;
        
        // Pastikan kelas ini milik instruktur yang sedang login
        $kelas = Kelas::with(['programPelatihan', 'instruktur.user'])
                        ->where('id', $id)
                        ->where('instruktur_id', $instruktur->id)
                        ->firstOrFail();

        $pesertaKelas = Pendaftaran::with('peserta.user')
                                   ->where('kelas_id', $id)
                                   ->where('status_pendaftaran', 'disetujui')
                                   ->get();

        return view('instruktur.jadwal.cetak', compact('kelas', 'pesertaKelas'));
    }
}