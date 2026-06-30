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

    public function rapor($id)
    {
        $instruktur = Auth::user()->instruktur;
        $kelas = Kelas::with(['programPelatihan', 'fase.nilaiFase'])
            ->where('id', $id)->where('instruktur_id', $instruktur->id)->firstOrFail();

        $pesertaKelas = Pendaftaran::with(['peserta.user'])->where('kelas_id', $id)->where('status_pendaftaran', 'disetujui')->get();

        // Hitung nilai akhir peserta berdasarkan semua fase yang ada
        foreach ($pesertaKelas as $peserta) {
            $totalNilai = 0;
            $faseDinilai = 0;
            
            $detailFase = [];
            foreach ($kelas->fase as $fase) {
                // Cari NilaiFase untuk peserta ini di fase ini
                $nilaiFase = $fase->nilaiFase->where('pendaftaran_id', $peserta->id)->first();
                if ($nilaiFase) {
                    $totalNilai += $nilaiFase->nilai_rata_rata;
                    $faseDinilai++;
                    $detailFase[$fase->id] = $nilaiFase->nilai_rata_rata;
                } else {
                    $detailFase[$fase->id] = 0;
                }
            }

            $peserta->rata_rata_akhir = $faseDinilai > 0 ? round($totalNilai / $faseDinilai, 2) : 0;
            $peserta->status_sementara = $peserta->rata_rata_akhir >= 70 ? 'Lulus' : 'Belum Lulus';
            $peserta->detail_fase = $detailFase;
        }

        return view('instruktur.jadwal.rapor', compact('kelas', 'pesertaKelas'));
    }

    public function kunciRapor(Request $request, $id)
    {
        $instruktur = Auth::user()->instruktur;
        $kelas = Kelas::where('id', $id)->where('instruktur_id', $instruktur->id)->firstOrFail();
        
        $pesertaKelas = Pendaftaran::where('kelas_id', $id)->where('status_pendaftaran', 'disetujui')->get();

        foreach ($pesertaKelas as $peserta) {
            $totalNilai = 0;
            $faseDinilai = 0;
            
            // Hitung manual dari DB agar akurat saat dikunci
            $nilaiFasePeserta = \App\Models\NilaiFase::where('pendaftaran_id', $peserta->id)->get();
            foreach ($nilaiFasePeserta as $nf) {
                $totalNilai += $nf->nilai_rata_rata;
                $faseDinilai++;
            }
            
            $rataRataAkhir = $faseDinilai > 0 ? round($totalNilai / $faseDinilai, 2) : 0;
            $statusKelulusan = $rataRataAkhir >= 70 ? 'lulus' : 'tidak_lulus';

            $peserta->update([
                'nilai_rata_rata' => $rataRataAkhir,
                'status_kelulusan' => $statusKelulusan
            ]);
        }

        return redirect()->back()->with('success', 'Rapor seluruh peserta di kelas ini berhasil dikunci dan direkap permanen!');
    }

    public function cetak($id)
    {
        $instruktur = Auth::user()->instruktur;
        $kelas = Kelas::with(['programPelatihan', 'instruktur.user'])->where('id', $id)->where('instruktur_id', $instruktur->id)->firstOrFail();
        $pesertaKelas = Pendaftaran::with('peserta.user')->where('kelas_id', $id)->where('status_pendaftaran', 'disetujui')->get();

        return view('instruktur.jadwal.cetak', compact('kelas', 'pesertaKelas'));
    }
}