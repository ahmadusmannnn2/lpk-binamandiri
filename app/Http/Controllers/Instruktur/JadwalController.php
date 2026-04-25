<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    // Menampilkan daftar kelas yang diajar oleh instruktur ini
    public function index()
    {
        $instruktur = Auth::user()->instruktur;
        
        // Cek jika akun ini belum punya profil instruktur (untuk keamanan)
        if (!$instruktur) {
            abort(403, 'Profil Instruktur tidak ditemukan.');
        }

        // Ambil kelas yang instruktur_id nya adalah instruktur yang sedang login
        $kelas = Kelas::with('programPelatihan')
                      ->where('instruktur_id', $instruktur->id)
                      ->latest()
                      ->get();

        return view('instruktur.jadwal.index', compact('kelas'));
    }

    // Menampilkan daftar peserta dalam satu kelas untuk dinilai
    public function show($id)
    {
        $instruktur = Auth::user()->instruktur;
        
        // Pastikan kelas ini benar-benar milik instruktur yang sedang login
        $kelas = Kelas::with('programPelatihan')->where('id', $id)->where('instruktur_id', $instruktur->id)->firstOrFail();

        // Ambil peserta yang pendaftarannya sudah DISETUJUI oleh admin
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

        // Loop data nilai yang dikirim dari form dan update ke database
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
}