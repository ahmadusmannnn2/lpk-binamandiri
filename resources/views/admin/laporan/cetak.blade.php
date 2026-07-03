<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Pendaftaran & Keuangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { background-color: white !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .no-print { display: none !important; }
        }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px 12px; font-size: 12px; text-align: left; }
        th { background-color: #f3f4f6; font-weight: bold; text-transform: uppercase; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body class="bg-white text-gray-900 font-sans p-8 max-w-5xl mx-auto">

    <!-- Tombol Print (Sembunyi saat dicetak) -->
    <div class="no-print flex justify-end mb-6">
        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-bold shadow transition">
            🖨️ Cetak Dokumen Ini
        </button>
    </div>

    <!-- Kop Surat -->
    @php
        $nama1 = \App\Models\Pengaturan::where('kunci', 'nama_lpk_1')->value('nilai') ?? 'LPK';
        $nama2 = \App\Models\Pengaturan::where('kunci', 'nama_lpk_2')->value('nilai') ?? 'BINA MANDIRI';
        $alamat_cetak = \App\Models\Pengaturan::where('kunci', 'kontak_alamat')->value('nilai') ?? 'Jl. Karya Tralis No. 58, Jlamprang, Wonosobo, Jawa Tengah';
        $telepon_cetak = \App\Models\Pengaturan::where('kunci', 'kontak_telepon')->value('nilai') ?? '-';
        $email_cetak   = \App\Models\Pengaturan::where('kunci', 'kontak_email')->value('nilai') ?? '-';
        $logoApp = \App\Models\Pengaturan::where('kunci', 'logo_navbar')->value('nilai');
    @endphp

    <div class="border-b-4 border-double border-[#201e1f] pb-4 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-20 h-20 shrink-0">
                @if($logoApp)
                    <img src="{{ asset('storage/' . $logoApp) }}" class="w-full h-full object-contain" alt="Logo">
                @else
                    <!-- SVG Logo Pengganti (Lebih Profesional) -->
                    <svg viewBox="0 0 100 100" class="w-full h-full" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="100" height="100" rx="20" fill="#201e1f"/>
                        <path d="M30 70V30L45 50L60 30V70" stroke="#de5e2e" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M70 30L70 70" stroke="#de5e2e" stroke-width="8" stroke-linecap="round"/>
                    </svg>
                @endif
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-widest uppercase text-[#201e1f]">{{ $nama1 }} <span class="text-[#de5e2e]">{{ $nama2 }}</span></h1>
                <p class="font-bold text-gray-700 text-sm">LEMBAGA PELATIHAN KERJA DAN SERTIFIKASI KOMPETENSI PENGELASAN</p>
                <p class="text-xs text-gray-500 mt-0.5">📍 {{ $alamat_cetak }} &nbsp;|&nbsp; 📞 {{ $telepon_cetak }} &nbsp;|&nbsp; ✉ {{ $email_cetak }}</p>
            </div>
        </div>
    </div>

    <!-- Judul Laporan -->
    <div class="mb-6">
        <h2 class="text-xl font-bold text-center underline mb-4">LAPORAN PENDAFTARAN & KEUANGAN</h2>
        
        <table style="width: auto; border: none; margin-top:0;">
            <tr>
                <td style="border:none; padding:2px; font-weight:bold; width: 120px;">Periode Tanggal</td>
                <td style="border:none; padding:2px;">: {{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->format('d M Y') : 'Awal' }} s.d {{ request('end_date') ? \Carbon\Carbon::parse(request('end_date'))->format('d M Y') : 'Akhir' }}</td>
            </tr>
            <tr>
                <td style="border:none; padding:2px; font-weight:bold;">Status Filter</td>
                <td style="border:none; padding:2px; text-transform:uppercase;">: {{ request('status') ?: 'Semua Status' }}</td>
            </tr>
        </table>
    </div>

    <!-- Tabel Data -->
    <table>
        <thead>
            <tr>
                <th style="width: 30px;" class="text-center">No</th>
                <th style="width: 80px;">Tgl Daftar</th>
                <th>Nama Peserta</th>
                <th>Program Pelatihan</th>
                <th class="text-center">Nomor WA</th>
                <th class="text-center">Status</th>
                <th class="text-right">Nominal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $key => $item)
            <tr>
                <td class="text-center">{{ $key + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_daftar)->format('d/m/Y') }}</td>
                <td>
                    <b>{{ $item->peserta->user->name ?? '-' }}</b><br>
                    <span style="font-size:10px; color:#555;">NIK: {{ $item->peserta->nik ?? '-' }}</span>
                </td>
                <td>
                    {{ $item->kelas->programPelatihan->nama_program ?? '-' }}<br>
                    <span style="font-size:10px; color:#555;">{{ $item->kelas->nama_kelas ?? '-' }}</span>
                </td>
                <td class="text-center">{{ $item->peserta->nomor_telepon ?? '-' }}</td>
                <td class="text-center uppercase" style="font-weight:bold; color: {{ $item->status_pembayaran == 'sukses' ? 'green' : ($item->status_pembayaran == 'pending' ? 'orange' : 'red') }}">
                    {{ $item->status_pembayaran }}
                </td>
                <td class="text-right">
                    {{ number_format($item->kelas->programPelatihan->harga_pelatihan ?? 0, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color: #f3f4f6;">
                <td colspan="6" class="text-right" style="font-weight: 900; font-size: 14px;">TOTAL PEMASUKAN DARI STATUS LUNAS</td>
                <td class="text-right" style="font-weight: 900; font-size: 14px; color: green;">
                    Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>

    <!-- Tanda Tangan -->
    <div style="margin-top: 50px; text-align: right;">
        <p style="margin-bottom: 70px;">Wonosobo, {{ \Carbon\Carbon::now()->format('d F Y') }}<br>Mengetahui,</p>
        <p style="font-weight: bold; text-decoration: underline;">Pimpinan / Bagian Keuangan</p>
    </div>

</body>
</html>