<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class AkademikController extends Controller
{
    // 1. MENU REKAP NILAI KESELURUHAN
    // 1. Tampilkan Daftar Peserta untuk Input Nilai (Dengan Search & Filter)
    public function nilaiIndex(Request $request)
    {
        // Ambil daftar kelas untuk dropdown filter (Fokus ke kelas berjalan & selesai)
        $kelasOptions = \App\Models\Kelas::with('programPelatihan')
            ->whereIn('status_kelas', ['berjalan', 'selesai'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Mulai Query Dasar: Hanya tampilkan peserta yang pendaftarannya sudah Disetujui
        $query = Pendaftaran::with(['peserta.user', 'kelas.programPelatihan'])
            ->where('status_pendaftaran', 'disetujui')
            ->orderBy('updated_at', 'desc');

        // --- LOGIKA PENCARIAN (SEARCH) ---
        $query->when($request->search, function ($q, $search) {
            $q->where(function ($subQ) use ($search) {
                $subQ->whereHas('peserta.user', function ($uQ) use ($search) {
                    $uQ->where('name', 'like', '%' . $search . '%');
                })->orWhereHas('peserta', function ($pQ) use ($search) {
                    $pQ->where('nik', 'like', '%' . $search . '%');
                });
            });
        });

        // --- LOGIKA FILTER KELAS / ANGKATAN ---
        $query->when($request->kelas, function ($q, $kelas) {
            $q->where('kelas_id', $kelas);
        });

        // --- LOGIKA FILTER STATUS KELULUSAN ---
        $query->when($request->status, function ($q, $status) {
            $q->where('status_kelulusan', $status);
        });

        // Eksekusi Query dengan Pagination (15 data per halaman)
        $pendaftaran = $query->paginate(15)->withQueryString();

        // Catatan: Sesuaikan nama view-nya jika folder Anda bernama 'akademik' (misal: 'admin.akademik.nilai')
        return view('admin.nilai.index', compact('pendaftaran', 'kelasOptions'));
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