<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Controller;
use App\Models\FaseKelas;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaseKelasController extends Controller
{
    public function store(Request $request, $kelas_id)
    {
        $request->validate([
            'nama_fase' => 'required|string|max:255',
            'urutan' => 'required|integer',
            'target_pertemuan' => 'required|integer|min:1',
        ]);

        $kelas = Kelas::findOrFail($kelas_id);
        
        // Keamanan ekstra: Pastikan hanya instruktur kelas ini yang bisa
        if ($kelas->instruktur_id !== Auth::user()->instruktur->id) {
            abort(403, 'Anda tidak memiliki akses ke kelas ini.');
        }

        FaseKelas::create([
            'kelas_id' => $kelas->id,
            'nama_fase' => $request->nama_fase,
            'urutan' => $request->urutan,
            'target_pertemuan' => $request->target_pertemuan,
            'status' => 'belum_mulai',
        ]);

        return back()->with('success', 'Fase/Modul Pembelajaran berhasil ditambahkan! Anda bisa mulai mengelompokkan pertemuan di dalamnya.');
    }
    
    // Fitur untuk mengganti status Fase (misal dari berjalan menjadi selesai)
    public function updateStatus(Request $request, $id)
    {
        $fase = FaseKelas::findOrFail($id);
        if ($fase->kelas->instruktur_id !== Auth::user()->instruktur->id) {
            abort(403);
        }

        $fase->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status fase berhasil diperbarui!');
    }

    public function updateKriteria(Request $request, $id)
    {
        $fase = FaseKelas::findOrFail($id);
        if ($fase->kelas->instruktur_id !== Auth::user()->instruktur->id) {
            abort(403);
        }

        $request->validate([
            'kriteria' => 'required|array',
            'kriteria.*' => 'string|max:255',
        ]);

        $fase->update([
            'kriteria_penilaian' => array_values(array_filter($request->kriteria))
        ]);

        return back()->with('success', 'Kriteria penilaian berhasil diatur!');
    }
    
    public function simpanNilai(Request $request, $id)
    {
        $fase = FaseKelas::findOrFail($id);
        if ($fase->kelas->instruktur_id !== Auth::user()->instruktur->id) {
            abort(403, 'Akses Ditolak');
        }

        $request->validate([
            'nilai.*.detail' => 'nullable|array',
            'nilai.*.detail.*.skor' => 'nullable|numeric|min:0|max:100',
            'nilai.*.detail.*.catatan' => 'nullable|string|max:255',
            'nilai.*.catatan_akhir' => 'nullable|string|max:500',
        ]);

        if($request->has('nilai')) {
            foreach ($request->nilai as $pendaftaran_id => $data) {
                
                $detailNilai_baru = $data['detail'] ?? [];
                
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
                
                if ($skor_diinput == 0) {
                    $status_kelulusan = 'belum_dinilai';
                } elseif ($nilai_rata_rata >= 70) {
                    $status_kelulusan = 'lulus';
                } else {
                    $status_kelulusan = 'tidak_lulus';
                }

                \App\Models\NilaiFase::updateOrCreate(
                    ['pendaftaran_id' => $pendaftaran_id, 'fase_kelas_id' => $fase->id],
                    [
                        'detail_nilai' => $detailNilai_baru,
                        'nilai_rata_rata' => $nilai_rata_rata,
                        'catatan_instruktur' => $data['catatan_akhir'] ?? null,
                        'status_kelulusan' => $status_kelulusan
                    ]
                );
            }

            // HITUNG KELULUSAN GLOBAL (Semua Fase) UNTUK ADMIN
            $fase->kelas->pendaftaran()->where('status_pendaftaran', 'disetujui')->get()->each(function($p) use ($fase) {
                $semuaFase = $fase->kelas->fase;
                $totalNilaiFase = 0;
                $faseDinilai = 0;
                $semuaLulus = true;

                foreach($semuaFase as $f) {
                    $nilaiF = $f->nilaiFase()->where('pendaftaran_id', $p->id)->first();
                    if($nilaiF && $nilaiF->status_kelulusan != 'belum_dinilai') {
                        $totalNilaiFase += $nilaiF->nilai_rata_rata;
                        $faseDinilai++;
                        if($nilaiF->status_kelulusan == 'tidak_lulus') {
                            $semuaLulus = false;
                        }
                    } else {
                        $semuaLulus = false; // Ada fase yang belum dinilai
                    }
                }

                if ($semuaFase->count() > 0 && $faseDinilai == $semuaFase->count()) {
                    $rataGlobal = round($totalNilaiFase / $semuaFase->count(), 2);
                    $statusGlobal = $semuaLulus ? 'lulus' : 'tidak_lulus';

                    $p->update([
                        'nilai_rata_rata' => $rataGlobal,
                        'status_kelulusan' => $statusGlobal
                    ]);
                }
            });
        }

        return back()->with('success', 'Nilai untuk Fase '.$fase->nama_fase.' berhasil disimpan!');
    }
}
