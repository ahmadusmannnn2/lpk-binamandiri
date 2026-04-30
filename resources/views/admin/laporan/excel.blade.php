<table>
    <thead>
        <tr>
            <th style="font-weight: bold; text-align: center;">No</th>
            <th style="font-weight: bold; text-align: center;">Nama Peserta</th>
            <th style="font-weight: bold; text-align: center;">NIK</th>
            <th style="font-weight: bold; text-align: center;">Program Pelatihan</th>
            <th style="font-weight: bold; text-align: center;">Kelas / Angkatan</th>
            <th style="font-weight: bold; text-align: center;">Nama Instruktur</th>
            <th style="font-weight: bold; text-align: center;">Kehadiran (%)</th>
            <th style="font-weight: bold; text-align: center;">Nilai Rata-rata Akhir</th>
            <th style="font-weight: bold; text-align: center;">Status Kelulusan</th>
        </tr>
    </thead>
    <tbody>
        @forelse($laporan as $key => $item)
        <tr>
            <td style="text-align: center;">{{ $key + 1 }}</td>
            <td>{{ $item->peserta->user->name ?? '-' }}</td>
            <td>'{{ $item->peserta->nik ?? '-' }}</td> <!-- Tanda petik agar NIK tidak jadi format rumus di Excel -->
            <td>{{ $item->kelas->programPelatihan->nama_program ?? '-' }}</td>
            <td>{{ $item->kelas->nama_kelas ?? '-' }}</td>
            <td>{{ $item->kelas->instruktur->user->name ?? '-' }}</td>
            <td style="text-align: center;">{{ $item->kehadiran ?? 0 }}</td>
            <td style="text-align: center;">{{ $item->nilai_rata_rata ?? 0 }}</td>
            <td style="text-align: center;">
                @if($item->status_kelulusan == 'lulus')
                    Lulus
                @elseif($item->status_kelulusan == 'tidak_lulus')
                    Gagal
                @else
                    Proses
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="9" style="text-align: center;">Tidak ada data yang sesuai dengan filter.</td>
        </tr>
        @endforelse
    </tbody>
</table>