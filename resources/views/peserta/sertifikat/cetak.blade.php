<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat - {{ $pendaftaran->peserta->user->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Pengaturan agar kertas Landscape saat di-print */
        @page { size: A4 landscape; margin: 0; }
        @media print {
            .no-print { display: none !important; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
        /* Motif border sertifikat */
        .cert-border {
            border: 15px solid #201e1f;
            outline: 5px solid #de5e2e;
            outline-offset: -25px;
        }
    </style>
</head>
<body class="bg-gray-200 flex justify-center items-center min-h-screen">

    <div class="fixed top-5 right-5 space-x-4 no-print z-50">
        <button onclick="window.close()" class="bg-gray-500 text-white px-4 py-2 rounded font-bold shadow hover:bg-gray-600">Tutup</button>
        <button onclick="window.print()" class="bg-[#de5e2e] text-white px-6 py-2 rounded font-bold shadow-lg hover:bg-[#c24b22] hover:-translate-y-1 transition transform">🖨️ Cetak / Simpan PDF</button>
    </div>

    <div class="bg-white w-[1123px] h-[794px] relative cert-border p-12 shadow-2xl overflow-hidden flex flex-col justify-between">
        
        <div class="absolute inset-0 flex justify-center items-center opacity-5 pointer-events-none">
            <h1 class="text-[15rem] font-black text-[#201e1f] rotate-12">LPKBINA</h1>
        </div>

        <div class="text-center relative z-10 pt-4">
            <h1 class="text-5xl font-black text-[#201e1f] tracking-widest uppercase">LPK <span class="text-[#de5e2e]">BINA MANDIRI</span></h1>
            <p class="text-sm font-semibold tracking-widest mt-2">LEMBAGA PELATIHAN KERJA DAN SERTIFIKASI KOMPETENSI PENGELASAN</p>
            <div class="w-24 h-1 bg-[#de5e2e] mx-auto mt-4"></div>
        </div>

        <div class="text-center relative z-10 flex-grow flex flex-col justify-center">
            <h2 class="text-4xl font-serif font-bold text-gray-800 tracking-widest mb-6">S E R T I F I K A T</h2>
            <p class="text-gray-600 mb-2 uppercase tracking-widest text-sm">Diberikan Kepada:</p>
            
            <h3 class="text-5xl font-bold text-[#de5e2e] italic mb-2">{{ strtoupper($pendaftaran->peserta->user->name) }}</h3>
            <p class="text-gray-500 font-semibold mb-8">NIK: {{ $pendaftaran->peserta->nik }}</p>

            <p class="text-lg text-gray-700 max-w-3xl mx-auto leading-relaxed">
                Telah menyelesaikan pelatihan dengan sangat baik dan dinyatakan <strong class="text-green-600 text-xl">LULUS</strong> pada program pelatihan:
            </p>
            <h4 class="text-3xl font-black text-[#201e1f] mt-4">{{ strtoupper($pendaftaran->kelas->programPelatihan->nama_program) }}</h4>
            <p class="text-sm text-gray-500 mt-2">Diselenggarakan pada {{ \Carbon\Carbon::parse($pendaftaran->kelas->tanggal_mulai)->translatedFormat('d F Y') }} sampai dengan {{ \Carbon\Carbon::parse($pendaftaran->kelas->tanggal_selesai)->translatedFormat('d F Y') }}.</p>
        </div>

        <div class="flex justify-between items-end relative z-10 pb-4 px-12">
            <div class="border-2 border-[#201e1f] p-4 rounded text-left bg-white">
                <p class="text-xs text-gray-500 font-bold uppercase border-b border-gray-300 pb-1 mb-2">Transkrip Nilai</p>
                <p class="text-sm"><strong>Teori:</strong> <span class="text-[#de5e2e] font-black">{{ $pendaftaran->nilai_teori }}</span>/100</p>
                <p class="text-sm mt-1"><strong>Praktik:</strong> <span class="text-[#de5e2e] font-black">{{ $pendaftaran->nilai_praktik }}</span>/100</p>
            </div>

            <div class="text-center">
                <p class="text-sm text-gray-600 mb-1">Wonosobo, {{ \Carbon\Carbon::parse($pendaftaran->updated_at)->translatedFormat('d F Y') }}</p>
                <p class="font-bold text-[#201e1f]">Pimpinan LPK Bina Mandiri</p>
                <div class="h-20 flex items-center justify-center">
                    <p class="text-4xl text-blue-900 font-signature italic opacity-50 transform -rotate-12">Disahkan</p>
                </div>
                <p class="font-bold underline text-[#201e1f]">Hidayatus Sibyan, M.Kom</p>
                <p class="text-xs text-gray-500">NIP. 1234567890</p>
            </div>
        </div>

    </div>

</body>
</html>