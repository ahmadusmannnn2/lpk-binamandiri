<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat - {{ $pendaftaran->peserta->user->name }}</title>
    
    <!-- Import Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Diplomata&family=Great+Vibes&family=Lora:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        /* Pengaturan Kertas A4 Landscape */
        @page { 
            size: A4 landscape; 
            margin: 0; 
        }
        
        body { 
            margin: 0; 
            padding: 0;
            font-family: 'Lora', serif; 
            color: #2b2b2b;
            /* WAJIB agar warna CSS ikut ter-print */
            -webkit-print-color-adjust: exact !important; 
            print-color-adjust: exact !important; 
            background-color: #e5e7eb; /* Warna layar luar saat preview */
        }

        /* Halaman Depan (Sertifikat) */
        .page-front {
            width: 297mm; 
            height: 209mm; /* A4 Landscape */
            position: relative;
            
            /* WARNA KERTAS SERTIFIKAT KREM/IVORY ELEGAN */
            background-color: #FDF8E7; 
            
            /* MEMANGGIL BINGKAI PNG TRANSPARAN */
            background-image: url("{{ asset('images/bg-sertifikat.png') }}"); 
            background-size: 100% 100%;
            background-position: center;
            background-repeat: no-repeat;
            page-break-after: always; /* Memisahkan halaman depan & belakang */
            margin: 0 auto;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        /* Halaman Belakang (Nilai Kompetensi) */
        .page-back {
            width: 297mm; 
            height: 209mm; 
            /* WARNA KERTAS SAMA DENGAN HALAMAN DEPAN */
            background-color: #FDF8E7; 
            margin: 0 auto;
            padding: 25mm;
            box-sizing: border-box;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        /* Area Aman (Menghindari Border Template PNG agar teks tidak tergencet) */
        .safe-zone {
            position: absolute;
            /* Ubah angka 28mm ini jika bingkai template PNG Anda lebih tebal/tipis */
            top: 28mm; bottom: 28mm; left: 28mm; right: 28mm;
            display: flex;
            flex-direction: column;
        }

        .font-diplomata { font-family: 'Diplomata', serif; }
        .font-script { font-family: 'Great Vibes', cursive; }

        @media print {
            .no-print { display: none !important; }
            body { background-color: #fff; }
            .page-front, .page-back { box-shadow: none; margin: 0; }
        }
    </style>
</head>
<body>

    <!-- Tombol Cetak (Tidak ikut terprint) -->
    <div class="fixed top-5 right-5 space-x-4 no-print z-50">
        <button onclick="window.print()" class="bg-[#de5e2e] text-white px-6 py-3 rounded-lg font-black shadow-xl hover:bg-[#c24b22] transition transform hover:scale-105 flex items-center gap-2 border border-white/20">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak Sertifikat
        </button>
    </div>

    <!-- ================= HALAMAN 1: DEPAN ================= -->
    <div class="page-front">
        <div class="safe-zone">
            
            <!-- Header Kiri (Logo & Nama LPK) -->
            <div class="w-full text-left mb-2">
                @php $logo = \App\Models\Pengaturan::where('kunci', 'logo_navbar')->value('nilai'); @endphp
                @if($logo)
                    <img src="{{ asset('storage/' . $logo) }}" alt="Logo" class="h-[18mm] object-contain" style="mix-blend-mode: multiply;">
                @else
                    <div class="text-[#de5e2e] font-black text-xl leading-tight">LPK BINA<br>MANDIRI</div>
                @endif
            </div>

            <!-- Konten Utama (Tengah) -->
            <div class="text-center flex-grow flex flex-col justify-center mt-[-10mm]">
                <h1 class="font-diplomata text-[65px] text-[#5c4a30] tracking-wider mb-2" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">Sertifikat</h1>
                <p class="text-sm font-bold tracking-widest text-gray-800">Dengan ini menerangkan bahwa :</p>
                
                <h2 class="font-script text-[80px] mt-2 mb-2 text-black leading-none">
                    {{ $pendaftaran->peserta->user->name }}
                </h2>
                
                <p class="text-[13px] font-bold text-gray-900">
                    Tempat, Tgl Lahir : 
                    {{ $pendaftaran->peserta->tempat_lahir ?? 'Wonosobo' }}, 
                    {{ \Carbon\Carbon::parse($pendaftaran->peserta->tanggal_lahir ?? '2000-01-01')->translatedFormat('d F Y') }}
                </p>

                <!-- Teks Paragraf -->
                <div class="mt-6 px-[20mm] text-[13.5px] leading-loose text-center text-gray-900 font-medium">
                    Telah berhasil dengan baik mengikuti Pelatihan <strong class="uppercase text-black">{{ $pendaftaran->kelas->programPelatihan->nama_program }}</strong> 
                    dengan kompetensi yang tercantum di balik sertifikat ini. Dilaksanakan di Lembaga Pelatihan Kerja Swasta (LPKS) 
                    <strong class="text-black">BINA MANDIRI</strong> pada tanggal 
                    {{ \Carbon\Carbon::parse($pendaftaran->kelas->tanggal_mulai)->translatedFormat('d F Y') }} s/d 
                    {{ \Carbon\Carbon::parse($pendaftaran->kelas->tanggal_selesai)->translatedFormat('d F Y') }}.
                </div>
            </div>

            <!-- Bagian Bawah (Berjejer Rapi Menggunakan Grid) -->
            <div class="grid grid-cols-4 gap-4 items-end mt-auto pt-4 w-full">
                
                <!-- 1. Nomor Registrasi -->
                <div class="text-center pb-2">
                    <p class="font-bold text-hitam text-sm tracking-widest">{{ $nomorSertifikat }}</p>
                </div>

                <!-- 2. Pas Foto -->
                <div class="flex justify-center pb-1">
                    @if($pendaftaran->peserta->pas_foto)
                        <img src="{{ asset('storage/' . $pendaftaran->peserta->pas_foto) }}" class="w-[30mm] h-[40mm] object-cover shadow-sm border border-gray-200 p-1 bg-white" alt="Foto">
                    @else
                        <div class="w-[30mm] h-[40mm] bg-blue-900 flex items-center justify-center text-white text-xs border-[2px] border-white shadow-md font-bold">3x4</div>
                    @endif
                </div>

                <!-- 3. Stempel Emas -->
                <div class="flex justify-center pb-1">
                    <img src="{{ asset('images/stempel.png') }}" class="w-[45mm] h-[45mm] object-contain opacity-95 mix-blend-multiply" alt="Stempel">
                </div>

                <!-- 4. Tanda Tangan -->
                @php
                    $tglTerbit = $pendaftaran->detail_nilai['tanggal_terbit'] ?? \Carbon\Carbon::now()->format('Y-m-d');
                @endphp
                <div class="text-center pb-2">
                    <p class="text-[12px] mb-1 text-gray-900">Wonosobo, {{ \Carbon\Carbon::parse($tglTerbit)->translatedFormat('d F Y') }}</p>
                    <img src="{{ asset('images/ttd-direktur.png') }}" class="h-[18mm] mx-auto my-1 object-contain mix-blend-multiply" alt="Tanda Tangan">
                    <p class="font-bold underline text-[14px] mt-1 text-black">Ir. Sunoto Mudiantoro, M.T.</p> 
                    <p class="text-[11px] mt-0.5 text-gray-800">Direktur</p>
                </div>

            </div>

        </div>
    </div>


    <!-- ================= HALAMAN 2: BELAKANG ================= -->
    <div class="page-back">
        <h2 class="text-center font-black text-2xl uppercase tracking-widest border-b-2 border-[#5c4a30] text-[#5c4a30] pb-4 mb-8">Daftar Unit Kompetensi</h2>
        
        <div class="flex justify-between text-sm mb-6 font-bold text-gray-900">
            <div>
                <p>Nama : <span class="text-black">{{ $pendaftaran->peserta->user->name }}</span></p>
                <p>Program : <span class="uppercase text-black">{{ $pendaftaran->kelas->programPelatihan->nama_program }}</span></p>
            </div>
            <div class="text-right">
                <p>Nomor : <span class="text-black">{{ $nomorSertifikat }}</span></p>
            </div>
        </div>

        <table class="w-full text-sm border-collapse border border-[#5c4a30]">
            <thead class="bg-[#f5ebd7] text-[#5c4a30]">
                <tr>
                    <th class="border border-[#5c4a30] p-3 text-center w-12">No</th>
                    <th class="border border-[#5c4a30] p-3">Kriteria Kompetensi / Posisi Las</th>
                    <th class="border border-[#5c4a30] p-3 text-center w-32">Skor Akhir</th>
                </tr>
            </thead>
            <tbody class="bg-white/50 text-gray-900">
                @php
                    $fases = $pendaftaran->kelas->fase ?? collect();
                    $no = 1;
                @endphp
                @forelse($fases as $fase)
                    @php
                        // Ambil nilai dari relasi NilaiFase
                        $nf = \App\Models\NilaiFase::where('fase_kelas_id', $fase->id)->where('pendaftaran_id', $pendaftaran->id)->first();
                        $skor = $nf ? $nf->nilai_rata_rata : '-';
                    @endphp
                    <tr>
                        <td class="border border-[#5c4a30] p-3 text-center">{{ $no++ }}</td>
                        <td class="border border-[#5c4a30] p-3 font-medium">Fase Kompetensi: {{ $fase->nama_fase }}</td>
                        <td class="border border-[#5c4a30] p-3 text-center font-bold text-black">{{ $skor }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="border border-[#5c4a30] p-3 text-center italic text-gray-500">Belum ada data fase.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot class="bg-[#f5ebd7] text-[#5c4a30]">
                <tr>
                    <td colspan="2" class="border border-[#5c4a30] p-3 text-right font-black tracking-widest uppercase">Rata-Rata Akhir Kompetensi</td>
                    <td class="border border-[#5c4a30] p-3 text-center font-black text-lg text-black">{{ $pendaftaran->nilai_rata_rata }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- Info Keterangan Kelulusan -->
        <div class="mt-8 text-gray-900">
            <p class="text-sm font-bold">Catatan Instruktur: <em class="font-normal text-gray-700">"{{ $pendaftaran->detail_nilai['catatan_instruktur_final'] ?? '-' }}"</em></p>
        </div>
    </div>

</body>
</html>