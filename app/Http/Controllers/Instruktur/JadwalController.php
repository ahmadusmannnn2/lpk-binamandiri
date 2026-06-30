<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index()
    {
        $instruktur = Auth::user()->instruktur;
        if (!$instruktur) abort(403, 'Profil Instruktur tidak ditemukan.');

        $kelas = Kelas::with('programPelatihan')->where('instruktur_id', $instruktur->id)->latest()->get();
        return view('instruktur.jadwal.index', compact('kelas'));
    }

    public function show($id)
    {
        $instruktur = Auth::user()->instruktur;
        $kelas = Kelas::with(['programPelatihan', 'fase.pertemuan', 'fase.nilaiFase'])
            ->where('id', $id)->where('instruktur_id', $instruktur->id)->firstOrFail();

        $pesertaKelas = Pendaftaran::with('peserta.user')->where('kelas_id', $id)->where('status_pendaftaran', 'disetujui')->get();

        return view('instruktur.jadwal.show', compact('kelas', 'pesertaKelas'));
    }

    public function simpanNilai(Request $request, $id)
    {
        $request->validate([
            'nilai.*.detail' => 'nullable|array',
            'nilai.*.detail.*.skor' => 'nullable|numeric|min:0|max:100',
            'nilai.*.detail.*.catatan' => 'nullable|string|max:255',
            'nilai.*.catatan_akhir' => 'nullable|string|max:500',
        ]);

        if($request->has('nilai')) {
            foreach ($request->nilai as $pendaftaran_id => $data) {
                
                // AMBIL DATA PENDAFTARAN LAMA (Agar no sertifikat dari Admin tidak hilang tertimpa!)
                $pendaftaran_lama = Pendaftaran::find($pendaftaran_id);
                $detailNilai_lama = $pendaftaran_lama->detail_nilai ?? [];
                
                $detailNilai_baru = $data['detail'] ?? [];
                
                // Kalkulasi Total dan Rata-rata Otomatis dari 'skor' baru
                $nilai_total = 0;
                $jumlah_kriteria = count($detailNilai_baru);
                $skor_diinput = 0;
                
                foreach($detailNilai_baru as $kriteria => $info) {
                    if (isset($info['skor']) && $info['skor'] !== '') {
                        $nilai_total += (int) $info['skor'];
                        $skor_diinput++;
                    }
                }
                
                $nilai_rata_rata = $skor_diinput > 0 ? round(($nilai_total / $skor_diinput), 2) : 0;

                // Masukkan catatan akhir instruktur ke array baru
                $detailNilai_baru['catatan_instruktur_final'] = $data['catatan_akhir'] ?? null;
                
                // KEMBALIKAN DATA ADMIN (Nomor & Tanggal Sertifikat) ke array baru
                if(isset($detailNilai_lama['nomor_sertifikat'])) {
                    $detailNilai_baru['nomor_sertifikat'] = $detailNilai_lama['nomor_sertifikat'];
                }
                if(isset($detailNilai_lama['tanggal_terbit'])) {
                    $detailNilai_baru['tanggal_terbit'] = $detailNilai_lama['tanggal_terbit'];
                }

                // KEPUTUSAN OTOMATIS: Lulus jika Rata-rata >= 70
                if ($skor_diinput == 0) {
                    $status_kelulusan = 'belum_dinilai';
                } elseif ($nilai_rata_rata >= 70) {
                    $status_kelulusan = 'lulus';
                } else {
                    $status_kelulusan = 'tidak_lulus';
                }

                Pendaftaran::where('id', $pendaftaran_id)->update([
                    'detail_nilai' => $detailNilai_baru,
                    'nilai_total' => $nilai_total,
                    'nilai_rata_rata' => $nilai_rata_rata,
                    'status_kelulusan' => $status_kelulusan,
                ]);
            }
        }

        return redirect()->route('instruktur.jadwal.show', $id)->with('success', 'Nilai dan Kelulusan berhasil dihitung & disimpan secara otomatis!');
    }

    public function cetak($id)
    {
        $instruktur = Auth::user()->instruktur;
        $kelas = Kelas::with(['programPelatihan', 'instruktur.user'])->where('id', $id)->where('instruktur_id', $instruktur->id)->firstOrFail();
        $pesertaKelas = Pendaftaran::with('peserta.user')->where('kelas_id', $id)->where('status_pendaftaran', 'disetujui')->get();

        return view('instruktur.jadwal.cetak', compact('kelas', 'pesertaKelas'));
    }
}