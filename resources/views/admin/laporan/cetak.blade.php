<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Peserta LPK Bina Mandiri</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @page { size: A4 portrait; margin: 20mm; }
        @media print {
            .no-print { display: none !important; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
        table { page-break-inside: auto; }
        tr { page-break-inside: avoid; page-break-after: auto; }
    </style>
</head>
<body class="bg-white text-gray-900 font-sans p-8 text-sm">

    <div class="fixed top-5 right-5 space-x-4 no-print z-50">
        <button onclick="window.close()" class="bg-gray-500 text-white px-4 py-2 rounded font-bold shadow hover:bg-gray-600">Tutup</button>
        <button onclick="window.print()" class="bg-[#de5e2e] text-white px-6 py-2 rounded font-bold shadow hover:bg-[#c24b22]">🖨️ Cetak Dokumen</button>
    </div>

    <div class="border-b-4 border-[#201e1f] pb-4 mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-black tracking-widest uppercase text-[#201e1f]">LPK <span class="text-[#de5e2e]">BINA MANDIRI</span></h1>
            <p class="font-bold text-gray-700">LEMBAGA PELATIHAN KERJA DAN SERTIFIKASI KOPETENSI PENGELASAN</p>
            <p class="text-xs text-gray-500 mt-1">Jl. KH. Hasyim Asy'ari Km. 03 Kalibeber, Mojotengah, Wonosobo, Jawa Tengah</p>
        </div>
    </div>

    <div class="text-center mb-8">
        <h2 class="text-xl font-bold uppercase underline">Laporan Hasil Pelatihan Peserta</h2>
        <p class="text-gray-600 mt-1">Filter Kelas: <strong>{{ $namaKelasFilter }}</strong></p>
        <p class="text-gray-600">Tanggal Dicetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y - H:i') }}</p>
    </div>

    <table class="w-full border-collapse border border-gray-800 text-left text-xs">
        <thead class="bg-gray-200">
            <tr>
                <th class="border border-gray-800 py-2 px-2 text-center w-8">No</th>
                <th class="border border-gray-800 py-2 px-2">Nama Peserta / NIK</th>
                <th class="border border-gray-800 py-2 px-2">Program Pelatihan</th>
                <th class="border border-gray-800 py-2 px-2">Instruktur</th>
                <th class="border border-gray-800 py-2 px-2 text-center">Hadir</th>
                <th class="border border-gray-800 py-2 px-2 text-center">Teori</th>
                <th class="border border-gray-800 py-2 px-2 text-center">Praktik</th>
                <th class="border border-gray-800 py-2 px-2 text-center">Status Lulus</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan as $key => $item)
            <tr>
                <td class="border border-gray-800 py-2 px-2 text-center">{{ $key + 1 }}</td>
                <td class="border border-gray-800 py-2 px-2 font-bold">
                    {{ $item->peserta->user->name }}
                    <div class="font-normal text-[10px] text-gray-500">{{ $item->peserta->nik }}</div>
                </td>
                <td class="border border-gray-800 py-2 px-2">
                    {{ $item->kelas->nama_kelas }}
                    <div class="text-[10px] text-gray-500">{{ $item->kelas->programPelatihan->nama_program }}</div>
                </td>
                <td class="border border-gray-800 py-2 px-2">{{ $item->kelas->instruktur->user->name ?? '-' }}</td>
                <td class="border border-gray-800 py-2 px-2 text-center">{{ $item->kehadiran }}%</td>
                <td class="border border-gray-800 py-2 px-2 text-center">{{ $item->nilai_teori }}</td>
                <td class="border border-gray-800 py-2 px-2 text-center">{{ $item->nilai_praktik }}</td>
                <td class="border border-gray-800 py-2 px-2 text-center font-bold uppercase">
                    @if($item->status_kelulusan == 'lulus')
                        <span class="text-green-700">Lulus</span>
                    @elseif($item->status_kelulusan == 'tidak_lulus')
                        <span class="text-red-700">Gagal</span>
                    @else
                        <span>Pending</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="border border-gray-800 py-4 px-2 text-center italic">Tidak ada data yang tersedia untuk dicetak.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-12 flex justify-end">
        <div class="text-center">
            <p>Wonosobo, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p class="font-bold">Admin LPK Bina Mandiri</p>
            <div class="h-24"></div>
            <p class="font-bold underline">{{ Auth::user()->name }}</p>
        </div>
    </div>

</body>
</html>