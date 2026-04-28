<?php

namespace App\Exports;

use App\Models\Pendaftaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $kelas_id;
    protected $status_kelulusan;

    public function __construct($kelas_id, $status_kelulusan)
    {
        $this->kelas_id = $kelas_id;
        $this->status_kelulusan = $status_kelulusan;
    }

    public function collection()
    {
        $query = Pendaftaran::with(['peserta.user', 'kelas.programPelatihan', 'kelas.instruktur.user'])
                            ->where('status_pendaftaran', 'disetujui');

        if ($this->kelas_id) {
            $query->where('kelas_id', $this->kelas_id);
        }
        if ($this->status_kelulusan) {
            $query->where('status_kelulusan', $this->status_kelulusan);
        }

        return $query->latest()->get();
    }

    // Mengurutkan data ke dalam kolom Excel
    public function map($pendaftaran): array
    {
        return [
            $pendaftaran->peserta->user->name,
            $pendaftaran->peserta->nik,
            $pendaftaran->kelas->nama_kelas,
            $pendaftaran->kelas->programPelatihan->nama_program,
            $pendaftaran->kelas->instruktur->user->name ?? '-',
            $pendaftaran->kehadiran . '%',
            $pendaftaran->nilai_teori,
            $pendaftaran->nilai_praktik,
            strtoupper(str_replace('_', ' ', $pendaftaran->status_kelulusan))
        ];
    }

    // Membuat Judul Header Kolom
    public function headings(): array
    {
        return [
            'NAMA PESERTA',
            'NIK',
            'KELAS',
            'PROGRAM PELATIHAN',
            'INSTRUKTUR',
            'KEHADIRAN',
            'NILAI TEORI',
            'NILAI PRAKTIK',
            'STATUS KELULUSAN'
        ];
    }

    // Memberi Style pada baris Header (Baris 1)
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']], 
                'fill' => ['fillType' => 'solid', 'color' => ['argb' => 'FFDE5E2E']] // Warna Oranye Kita
            ],
        ];
    }
}