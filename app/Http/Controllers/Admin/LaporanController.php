<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    // Menampilkan halaman filter laporan
    public function index(Request $request)
    {
        $kelas = Kelas::latest()->get();
        
        // Membangun Query Dasar (Hanya ambil yang pendaftarannya disetujui)
        $query = Pendaftaran::with(['peserta.user', 'kelas.programPelatihan'])
                            ->where('status_pendaftaran', 'disetujui');

        // Jika Admin memilih filter Kelas
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        // Jika Admin memilih filter Status Kelulusan
        if ($request->filled('status_kelulusan')) {
            $query->where('status_kelulusan', $request->status_kelulusan);
        }

        $laporan = $query->latest()->get();

        return view('admin.laporan.index', compact('kelas', 'laporan'));
    }

    // Menampilkan halaman khusus cetak (PDF)
    public function cetak(Request $request)
    {
        $query = Pendaftaran::with(['peserta.user', 'kelas.programPelatihan', 'kelas.instruktur.user'])
                            ->where('status_pendaftaran', 'disetujui');

        // Menangkap filter yang sama untuk dikirim ke halaman cetak
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }
        if ($request->filled('status_kelulusan')) {
            $query->where('status_kelulusan', $request->status_kelulusan);
        }

        $laporan = $query->latest()->get();
        $namaKelasFilter = $request->filled('kelas_id') ? Kelas::find($request->kelas_id)->nama_kelas : 'Semua Kelas';

        return view('admin.laporan.cetak', compact('laporan', 'namaKelasFilter'));
    }
}