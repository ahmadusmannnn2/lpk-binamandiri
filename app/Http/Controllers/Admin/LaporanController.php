<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\ProgramPelatihan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    // --- FUNGSI PINTAR UNTUK MENGAMBIL DATA FILTER ---
    private function filterData(Request $request)
    {
        $query = Pendaftaran::with(['peserta.user', 'kelas.programPelatihan'])
            ->orderBy('tanggal_daftar', 'desc');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_daftar', [$request->start_date, $request->end_date]);
        } elseif ($request->filled('start_date')) {
            $query->whereDate('tanggal_daftar', '>=', $request->start_date);
        } elseif ($request->filled('end_date')) {
            $query->whereDate('tanggal_daftar', '<=', $request->end_date);
        }

        $query->when($request->program, function ($q, $program) {
            $q->whereHas('kelas', function ($kelasQ) use ($program) {
                $kelasQ->where('program_pelatihan_id', $program);
            });
        });

        $query->when($request->status, function ($q, $status) {
            $q->where('status_pembayaran', $status);
        });

        return $query;
    }

    // 1. HALAMAN UTAMA LAPORAN
    public function index(Request $request)
    {
        $programs = ProgramPelatihan::all();
        $query = $this->filterData($request);

        $laporan = $query->paginate(15)->withQueryString();
        
        $totalPemasukan = (clone $query)->where('status_pembayaran', 'sukses')
            ->get()->sum(function($item) {
                return $item->kelas->programPelatihan->harga_pelatihan ?? 0;
            });

        return view('admin.laporan.index', compact('laporan', 'programs', 'totalPemasukan'));
    }

    // 2. FITUR CETAK PDF / HTML
    public function cetak(Request $request)
    {
        $query = $this->filterData($request);
        
        // Ambil SEMUA data yang sesuai filter (tanpa pagination)
        $laporan = $query->get(); 
        
        $totalPemasukan = (clone $query)->where('status_pembayaran', 'sukses')
            ->get()->sum(function($item) {
                return $item->kelas->programPelatihan->harga_pelatihan ?? 0;
            });

        return view('admin.laporan.cetak', compact('laporan', 'totalPemasukan'));
    }

    // 3. FITUR EXPORT EXCEL (Tanpa Plugin Tambahan)
    public function excel(Request $request)
    {
        $query = $this->filterData($request);
        $laporan = $query->get(); 
        $totalPemasukan = (clone $query)->where('status_pembayaran', 'sukses')
            ->get()->sum(function($item) {
                return $item->kelas->programPelatihan->harga_pelatihan ?? 0;
            });

        return response(view('admin.laporan.excel', compact('laporan', 'totalPemasukan')))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="Laporan_Pendaftaran_LPK.xls"');
    }
}