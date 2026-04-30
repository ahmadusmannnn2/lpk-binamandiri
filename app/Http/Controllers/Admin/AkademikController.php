<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class AkademikController extends Controller
{
    // 1. MENU REKAP NILAI KESELURUHAN
    public function nilaiIndex()
    {
        // Ambil data peserta yang status kelulusannya sudah dinilai (Lulus/Gagal)
        $pendaftaran = Pendaftaran::with(['peserta.user', 'kelas.programPelatihan', 'kelas.instruktur.user'])
            ->whereIn('status_kelulusan', ['lulus', 'tidak_lulus'])
            ->latest()
            ->get();

        return view('admin.nilai.index', compact('pendaftaran'));
    }

    // 2. MENU KELOLA SERTIFIKAT
    public function sertifikatIndex()
    {
        // HANYA ambil data peserta yang statusnya LULUS
        $pendaftaran = Pendaftaran::with(['peserta.user', 'kelas.programPelatihan'])
            ->where('status_kelulusan', 'lulus')
            ->latest()
            ->get();

        return view('admin.sertifikat.index', compact('pendaftaran'));
    }

    // 3. SIMPAN NOMOR SERTIFIKAT (KE DALAM JSON)
    public function sertifikatUpdate(Request $request, $id)
    {
        $request->validate([
            'nomor_sertifikat' => 'required|string|max:100',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);
        
        // Ambil array JSON lama, sisipkan nomor sertifikat, lalu simpan lagi
        $detailNilai = $pendaftaran->detail_nilai ?? [];
        $detailNilai['nomor_sertifikat'] = $request->nomor_sertifikat;

        $pendaftaran->update([
            'detail_nilai' => $detailNilai
        ]);

        return redirect()->back()->with('success', 'Nomor Sertifikat berhasil disimpan!');
    }

    // 4. HALAMAN CETAK PDF SERTIFIKAT
    public function sertifikatCetak($id)
    {
        $pendaftaran = Pendaftaran::with(['peserta.user', 'kelas.programPelatihan', 'kelas.instruktur.user'])->findOrFail($id);
        
        // Cek keamanan: Jangan izinkan cetak jika belum ada nomornya
        $nomorSertifikat = $pendaftaran->detail_nilai['nomor_sertifikat'] ?? null;
        if(!$nomorSertifikat) {
            return redirect()->back()->with('error', 'Silakan input Nomor Sertifikat terlebih dahulu sebelum mencetak!');
        }

        return view('admin.sertifikat.cetak', compact('pendaftaran', 'nomorSertifikat'));
    }
}