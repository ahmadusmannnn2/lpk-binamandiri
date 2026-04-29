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
        $kelas = Kelas::with('programPelatihan')->where('id', $id)->where('instruktur_id', $instruktur->id)->firstOrFail();

        $pesertaKelas = Pendaftaran::with('peserta.user')->where('kelas_id', $id)->where('status_pendaftaran', 'disetujui')->get();

        return view('instruktur.jadwal.show', compact('kelas', 'pesertaKelas'));
    }

    public function simpanNilai(Request $request, $id)
    {
        $request->validate([
            'nilai.*.detail' => 'nullable|array',
            'nilai.*.detail.*.skor' => 'nullable|numeric|min:0|max:100', // Validasi skor
            'nilai.*.detail.*.catatan' => 'nullable|string|max:255', // Validasi catatan per nilai
            'nilai.*.catatan_akhir' => 'nullable|string|max:500',
            'nilai.*.status_kelulusan' => 'required|in:belum_dinilai,lulus,tidak_lulus',
        ]);

        if($request->has('nilai')) {
            foreach ($request->nilai as $pendaftaran_id => $data) {
                
                $detailNilai = $data['detail'] ?? [];
                
                // Kalkulasi Total dan Rata-rata Otomatis dari 'skor'
                $nilai_total = 0;
                $jumlah_kriteria = count($detailNilai);
                
                foreach($detailNilai as $kriteria => $info) {
                    $nilai_total += (int) ($info['skor'] ?? 0);
                }
                
                $nilai_rata_rata = $jumlah_kriteria > 0 ? ($nilai_total / $jumlah_kriteria) : 0;

                // Masukkan catatan akhir keseluruhan ke dalam array JSON
                $detailNilai['catatan_instruktur_final'] = $data['catatan_akhir'] ?? null;

                Pendaftaran::where('id', $pendaftaran_id)->update([
                    'detail_nilai' => $detailNilai,
                    'nilai_total' => $nilai_total,
                    'nilai_rata_rata' => $nilai_rata_rata,
                    'status_kelulusan' => $data['status_kelulusan'],
                ]);
            }
        }

        return redirect()->route('instruktur.jadwal.show', $id)->with('success', 'Rapor Penilaian Detail, Catatan, dan Kelulusan berhasil disimpan!');
    }

    public function cetak($id)
    {
        $instruktur = Auth::user()->instruktur;
        $kelas = Kelas::with(['programPelatihan', 'instruktur.user'])->where('id', $id)->where('instruktur_id', $instruktur->id)->firstOrFail();
        $pesertaKelas = Pendaftaran::with('peserta.user')->where('kelas_id', $id)->where('status_pendaftaran', 'disetujui')->get();

        return view('instruktur.jadwal.cetak', compact('kelas', 'pesertaKelas'));
    }
}