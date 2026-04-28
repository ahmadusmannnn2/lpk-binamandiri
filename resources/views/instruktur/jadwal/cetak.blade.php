<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Hadir & Nilai - {{ $kelas->nama_kelas }}</title>
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
            <p class="text-xs text-gray-500 mt-1">Jl. Karya Tralis No. 58, Jlamprang, Wonosobo, Jawa Tengah</p>
        </div>
    </div>

    <div class="text-center mb-8">
        <h2 class="text-xl font-bold uppercase underline mb-4">Daftar Hadir & Rekap Nilai Akhir Peserta</h2>
        <table class="w-full text-left max-w-lg mx-auto text-sm">
            <tr><td class="font-bold w-32">Program</td><td class="w-4">:</td><td>{{ $kelas->programPelatihan->nama_program }}</td></tr>
            <tr><td class="font-bold">Kelas</td><td>:</td><td>{{ $kelas->nama_kelas }}</td></tr>
            <tr><td class="font-bold">Periode</td><td>:</td><td>{{ \Carbon\Carbon::parse($kelas->tanggal_mulai)->translatedFormat('d M Y') }} - {{ \Carbon\Carbon::parse($kelas->tanggal_selesai)->translatedFormat('d M Y') }}</td></tr>
            <tr><td class="font-bold">Instruktur</td><td>:</td><td>{{ $kelas->instruktur->user->name }}</td></tr>
        </table>
    </div>

    <table class="w-full border-collapse border border-gray-800 text-left text-xs mb-8">
        <thead class="bg-gray-200">
            <tr>
                <th class="border border-gray-800 py-2 px-2 text-center w-8">No</th>
                <th class="border border-gray-800 py-2 px-2">Nama Peserta</th>
                <th class="border border-gray-800 py-2 px-2 text-center">NIK</th>
                <th class="border border-gray-800 py-2 px-2 text-center">Kehadiran</th>
                <th class="border border-gray-800 py-2 px-2 text-center">N. Teori</th>
                <th class="border border-gray-800 py-2 px-2 text-center">N. Praktik</th>
                <th class="border border-gray-800 py-2 px-2 text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pesertaKelas as $key => $item)
            <tr>
                <td class="border border-gray-800 py-2 px-2 text-center">{{ $key + 1 }}</td>
                <td class="border border-gray-800 py-2 px-2 font-bold">{{ $item->peserta->user->name }}</td>
                <td class="border border-gray-800 py-2 px-2 text-center">{{ $item->peserta->nik }}</td>
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
                <td colspan="7" class="border border-gray-800 py-4 px-2 text-center italic">Tidak ada peserta di kelas ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="flex justify-between mt-12 text-sm">
        <div class="text-center w-64">
            <p>Mengetahui,</p>
            <p class="font-bold">Pimpinan LPK Bina Mandiri</p>
            <div class="h-24"></div>
            <p class="font-bold underline text-[#201e1f]">Hidayatus Sibyan, M.Kom</p>
            <p class="text-xs text-gray-500">NIP. 1234567890</p>
        </div>
        <div class="text-center w-64">
            <p>Wonosobo, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p class="font-bold">Instruktur Pengampu</p>
            <div class="h-24"></div>
            <p class="font-bold underline text-[#201e1f]">{{ $kelas->instruktur->user->name }}</p>
            <p class="text-xs text-gray-500">Spesialisasi: {{ $kelas->instruktur->spesialisasi_las }}</p>
        </div>
    </div>

</body>
</html>