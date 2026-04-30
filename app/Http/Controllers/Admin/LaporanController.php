<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\ProgramPelatihan;
use App\Models\Kelas;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $program = ProgramPelatihan::all();
        $kelas = Kelas::latest()->get();
        
        // Query dasar: Hanya ambil peserta yang sudah disetujui (valid)
        $query = Pendaftaran::with(['peserta.user', 'kelas.programPelatihan', 'kelas.instruktur.user'])
                            ->where('status_pendaftaran', 'disetujui');

        // Filter by Kelas
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        // Filter by Program
        if ($request->filled('program_id')) {
            $query->whereHas('kelas', function($q) use ($request) {
                $q->where('program_pelatihan_id', $request->program_id);
            });
        }

        // Filter by Status Kelulusan
        if ($request->filled('status_kelulusan')) {
            $query->where('status_kelulusan', $request->status_kelulusan);
        }

        $laporan = $query->latest()->get();

        return view('admin.laporan.index', compact('laporan', 'program', 'kelas'));
    }

    public function cetak(Request $request)
    {
        $query = Pendaftaran::with(['peserta.user', 'kelas.programPelatihan', 'kelas.instruktur.user'])
                            ->where('status_pendaftaran', 'disetujui');

        if ($request->filled('kelas_id')) $query->where('kelas_id', $request->kelas_id);
        
        if ($request->filled('program_id')) {
            $query->whereHas('kelas', function($q) use ($request) {
                $q->where('program_pelatihan_id', $request->program_id);
            });
        }

        if ($request->filled('status_kelulusan')) $query->where('status_kelulusan', $request->status_kelulusan);

        $laporan = $query->orderBy('kelas_id', 'asc')->get();
        
        // Parameter untuk Header Cetak PDF
        $namaKelasFilter = $request->filled('kelas_id') ? Kelas::find($request->kelas_id)->nama_kelas : 'Semua Kelas';
        $namaProgramFilter = $request->filled('program_id') ? ProgramPelatihan::find($request->program_id)->nama_program : 'Semua Program';

        return view('admin.laporan.cetak', compact('laporan', 'namaKelasFilter', 'namaProgramFilter'));
    }
    public function excel(Request $request)
    {
        // Pastikan Anda sudah mengimport facade Excel di atas (use Maatwebsite\Excel\Facades\Excel;)
        // Atau panggil langsung seperti di bawah ini:
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\LaporanExport($request), 'Laporan_Peserta_LPK_Bina_Mandiri.xlsx');
    }
}