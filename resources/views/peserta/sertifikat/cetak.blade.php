<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Kompetensi - {{ $pendaftaran->peserta?->user?->name ?? 'Peserta' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Pengaturan agar kertas Landscape saat di-print */
        @page { size: A4 landscape; margin: 0; }
        @media print {
            .no-print { display: none !important; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; background-color: white !important; }
            .cert-container { box-shadow: none !important; margin: 0 !important; width: 100% !important; height: 100vh !important; }
        }
        /* Motif border sertifikat yang elegan */
        .cert-border {
            border: 12px solid #201e1f;
            outline: 4px solid #de5e2e;
            outline-offset: -20px;
        }
    </style>
</head>
<body class="bg-gray-200 flex justify-center items-center min-h-screen font-sans print:bg-white print:items-start">

    <div class="fixed top-5 right-5 space-x-4 no-print z-50">
        <button onclick="window.close()" class="bg-gray-500 text-white px-5 py-2.5 rounded-lg font-bold shadow hover:bg-gray-600 transition">Tutup Tab</button>
        <button onclick="window.print()" class="bg-[#de5e2e] text-white px-6 py-2.5 rounded-lg font-bold shadow-lg hover:bg-[#c24b22] hover:-translate-y-1 transition transform flex items-center gap-2 inline-flex">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak / Simpan PDF
        </button>
    </div>

    <div class="cert-container bg-white w-[1123px] h-[794px] relative cert-border p-12 shadow-2xl overflow-hidden flex flex-col justify-between my-8">
        
        <div class="absolute inset-0 flex justify-center items-center opacity-[0.03] pointer-events-none">
            <h1 class="text-[14rem] font-black text-[#201e1f] rotate-12 select-none tracking-tighter">LPKBINA</h1>
        </div>

        <div class="text-center relative z-10 pt-6">
            <h1 class="text-5xl font-black text-[#201e1f] tracking-widest uppercase">LPK <span class="text-[#de5e2e]">BINA MANDIRI</span></h1>
            <p class="text-sm font-bold tracking-widest mt-2 text-gray-700">LEMBAGA PELATIHAN KERJA DAN SERTIFIKASI KOMPETENSI PENGELASAN</p>
            <div class="w-32 h-1.5 bg-[#de5e2e] mx-auto mt-5 rounded-full"></div>
        </div>

        <div class="text-center relative z-10 flex-grow flex flex-col justify-center mt-4">
            <h2 class="text-4xl font-serif font-black text-[#201e1f] tracking-[0.3em] mb-8">S E R T I F I K A T</h2>
            <p class="text-gray-600 mb-3 uppercase tracking-widest text-sm font-bold">Diberikan Kepada:</p>
            
            <h3 class="text-5xl font-bold text-[#de5e2e] italic mb-2 capitalize">{{ $pendaftaran->peserta?->user?->name ?? 'Peserta Terhapus' }}</h3>
            <p class="text-gray-500 font-bold mb-10 tracking-wider">NIK: {{ $pendaftaran->peserta?->nik ?? '-' }}</p>

            <p class="text-lg text-gray-700 max-w-4xl mx-auto leading-relaxed font-medium">
                Telah menyelesaikan pelatihan dengan sangat baik dan dinyatakan <strong class="text-green-600 text-2xl font-black uppercase tracking-widest mx-2">LULUS</strong> pada program pelatihan kompetensi:
            </p>
            
            <h4 class="text-3xl font-black text-[#201e1f] mt-6 leading-snug">{{ strtoupper($pendaftaran->kelas?->programPelatihan?->nama_program ?? 'Program Terhapus') }}</h4>
            <p class="text-sm text-gray-500 mt-3 font-medium">
                Diselenggarakan pada tanggal <span class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($pendaftaran->kelas?->tanggal_mulai ?? now())->translatedFormat('d F Y') }}</span> 
                sampai dengan <span class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($pendaftaran->kelas?->tanggal_selesai ?? now())->translatedFormat('d F Y') }}</span>.
            </p>
        </div>

        <div class="flex justify-between items-end relative z-10 pb-6 px-12 mt-4">
            <div class="border-2 border-[#201e1f] p-5 rounded-lg text-left bg-white shadow-sm min-w-[200px]">
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest border-b-2 border-gray-200 pb-2 mb-3">Transkrip Nilai Akhir</p>
                <div class="flex justify-between items-center mb-1">
                    <span class="text-sm font-bold text-gray-700">Teori:</span>
                    <span class="text-lg text-[#de5e2e] font-black">{{ $pendaftaran->nilai_teori ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm font-bold text-gray-700">Praktik:</span>
                    <span class="text-lg text-[#de5e2e] font-black">{{ $pendaftaran->nilai_praktik ?? 0 }}</span>
                </div>
            </div>

            <div class="text-center w-72">
                <p class="text-sm text-gray-700 mb-1 font-medium">Wonosobo, {{ \Carbon\Carbon::parse($pendaftaran->updated_at)->translatedFormat('d F Y') }}</p>
                <p class="font-bold text-[#201e1f] text-sm uppercase tracking-wider">Pimpinan LPK Bina Mandiri</p>
                <div class="h-28 flex items-center justify-center relative">
                    <div class="absolute w-24 h-24 border-4 border-blue-800/20 rounded-full flex items-center justify-center rotate-12 -left-4">
                        <div class="w-20 h-20 border border-blue-800/20 rounded-full flex items-center justify-center text-[8px] text-blue-800/40 font-bold uppercase text-center">LPK BINA<br>MANDIRI</div>
                    </div>
                    <p class="text-5xl text-blue-900 font-serif italic opacity-70 transform -rotate-6 select-none relative z-10">Disahkan</p>
                </div>
                <p class="font-black underline text-[#201e1f] text-lg">Pimpinan LPK Bina Mandiri</p>
            </div>
        </div>

    </div>

</body>
</html>