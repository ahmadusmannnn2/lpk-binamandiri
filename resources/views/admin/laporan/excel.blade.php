<table border="1">
    <thead>
        <tr>
            <th colspan="7" style="font-size: 16px; font-weight: bold; text-align: center;">LAPORAN PENDAFTARAN & KEUANGAN LPK</th>
        </tr>
        <tr>
            <th colspan="7" style="text-align: center;">Periode: {{ request('start_date') ?: 'Awal' }} s.d {{ request('end_date') ?: 'Akhir' }}</th>
        </tr>
        <tr></tr>
        <tr>
            <th style="font-weight: bold; background-color: #f2f2f2;">No</th>
            <th style="font-weight: bold; background-color: #f2f2f2;">Tanggal Daftar</th>
            <th style="font-weight: bold; background-color: #f2f2f2;">Nama Lengkap</th>
            <th style="font-weight: bold; background-color: #f2f2f2;">NIK</th>
            <th style="font-weight: bold; background-color: #f2f2f2;">Nomor WA</th>
            <th style="font-weight: bold; background-color: #f2f2f2;">Program Pelatihan</th>
            <th style="font-weight: bold; background-color: #f2f2f2;">Kelas</th>
            <th style="font-weight: bold; background-color: #f2f2f2;">Metode Pembayaran</th>
            <th style="font-weight: bold; background-color: #f2f2f2;">Status Pembayaran</th>
            <th style="font-weight: bold; background-color: #f2f2f2;">Biaya (Rp)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($laporan as $key => $item)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal_daftar)->format('Y-m-d') }}</td>
            <td>{{ $item->peserta->user->name ?? '-' }}</td>
            <td>'{{ $item->peserta->nik ?? '-' }}</td> <!-- Tanda petik agar NIK tidak jadi format rumus e+ di Excel -->
            <td>'{{ $item->peserta->nomor_telepon ?? '-' }}</td>
            <td>{{ $item->kelas->programPelatihan->nama_program ?? '-' }}</td>
            <td>{{ $item->kelas->nama_kelas ?? '-' }}</td>
            <td>{{ $item->metode_pembayaran ?? 'Manual' }}</td>
            <td>{{ strtoupper($item->status_pembayaran) }}</td>
            <td>{{ $item->kelas->programPelatihan->harga_pelatihan ?? 0 }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="9" style="text-align: right; font-weight: bold; background-color: #e6ffe6;">TOTAL PEMASUKAN LUNAS (Rp)</td>
            <td style="font-weight: bold; background-color: #e6ffe6;">{{ $totalPemasukan }}</td>
        </tr>
    </tfoot>
</table>