<?php

namespace App\Exports;

use App\Models\Pendaftaran;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanExport implements FromView, ShouldAutoSize
{
    protected $request;

    // Menangkap request filter dari Controller
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $query = Pendaftaran::with(['peserta.user', 'kelas.programPelatihan', 'kelas.instruktur.user'])
                            ->where('status_pendaftaran', 'disetujui');

        if ($this->request->filled('kelas_id')) {
            $query->where('kelas_id', $this->request->kelas_id);
        }
        
        if ($this->request->filled('program_id')) {
            $query->whereHas('kelas', function($q) {
                $q->where('program_pelatihan_id', $this->request->program_id);
            });
        }

        if ($this->request->filled('status_kelulusan')) {
            $query->where('status_kelulusan', $this->request->status_kelulusan);
        }

        $laporan = $query->orderBy('kelas_id', 'asc')->get();

        // Mengarahkan ke file view khusus Excel
        return view('admin.laporan.excel', compact('laporan'));
    }
}