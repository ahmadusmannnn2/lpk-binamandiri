<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Data Transaksi Pembayaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { background-color: white !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .no-print { display: none !important; }
        }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px 10px; font-size: 11px; text-align: left; }
        th { background-color: #f3f4f6; font-weight: bold; text-transform: uppercase; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
    </style>
</head>
<body class="bg-white text-gray-900 font-sans p-8 max-w-5xl mx-auto">

    <!-- Tombol Print -->
    <div class="no-print flex justify-end mb-6">
        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-bold shadow transition">
            🖨️ Cetak Dokumen Ini
        </button>
    </div>

    <!-- Kop Surat -->
    @php
        $nama1 = \App\Models\Pengaturan::where('kunci', 'nama_lpk_1')->value('nilai') ?? 'LPK';
        $nama2 = \App\Models\Pengaturan::where('kunci', 'nama_lpk_2')->value('nilai') ?? 'BINA';
        $alamat = \App\Models\Pengaturan::where('kunci', 'kontak_alamat')->value('nilai') ?? '-';
    @endphp
    <div class="border-b-4 border-gray-800 pb-4 mb-6 text-center">
        <h1 class="text-2xl font-black uppercase">{{ $nama1 }} {{ $nama2 }}</h1>
        <p class="text-xs mt-1">{{ $alamat }}</p>
    </div>

    <!-- Judul Dokumen -->
    <div class="mb-4 text-center">
        <h2 class="text-lg font-bold underline mb-2">DATA TRANSAKSI & TAGIHAN PESERTA</h2>
        <p class="text-xs text-gray-600">
            Filter Status: <span class="font-bold uppercase">{{ request('status') ?: 'SEMUA STATUS' }}</span> | 
            Kata Kunci: <span class="font-bold">{{ request('search') ?: '-' }}</span>
        </p>
        <p class="text-xs text-gray-600">Dicetak pada: {{ \Carbon\Carbon::now()->format('d M Y - H:i') }} WIB</p>
    </div>

    <!-- Tabel Data -->
    <table>
        <thead>
            <tr>
                <th style="width: 30px;" class="text-center">No</th>
                <th style="width: 100px;">No Order / Tgl</th>
                <th>Nama Peserta & NIK</th>
                <th>Program / Kelas</th>
                <th class="text-center">Status</th>
                <th class="text-right">Biaya (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php $totalSemua = 0; @endphp
            
            @forelse($pembayaran as $key => $item)
                @php $totalSemua += $item->kelas->programPelatihan->harga_pelatihan ?? 0; @endphp
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>
                        <b>LPK-{{ $item->id }}</b><br>
                        <span style="font-size:10px; color:#555;">{{ \Carbon\Carbon::parse($item->tanggal_daftar)->format('d/m/Y') }}</span>
                    </td>
                    <td>
                        <b>{{ $item->peserta->user->name ?? '-' }}</b><br>
                        <span style="font-size:10px; color:#555;">NIK: {{ $item->peserta->nik ?? '-' }}</span>
                    </td>
                    <td>
                        {{ $item->kelas->programPelatihan->nama_program ?? '-' }}<br>
                        <span style="font-size:10px; color:#555;">Kelas: {{ $item->kelas->nama_kelas ?? '-' }}</span>
                    </td>
                    <td class="text-center uppercase" style="font-weight:bold; color: {{ $item->status_pembayaran == 'sukses' ? 'green' : ($item->status_pembayaran == 'pending' ? 'orange' : 'red') }}">
                        {{ $item->status_pembayaran }}
                    </td>
                    <td class="text-right">
                        {{ number_format($item->kelas->programPelatihan->harga_pelatihan ?? 0, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4" style="font-style: italic; color:#777;">
                        Tidak ada data transaksi yang ditemukan sesuai filter.
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if(count($pembayaran) > 0)
        <tfoot>
            <tr style="background-color: #f3f4f6;">
                <td colspan="5" class="text-right" style="font-weight: bold; font-size: 12px;">ESTIMASI TOTAL TAGIHAN MUNCUL (Rp)</td>
                <td class="text-right" style="font-weight: bold; font-size: 12px; color: #111;">
                    {{ number_format($totalSemua, 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
        @endif
    </table>

</body>
</html>