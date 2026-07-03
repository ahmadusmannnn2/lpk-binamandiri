<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Hadir & Nilai - {{ $kelas?->nama_kelas ?? 'Kelas' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Kita ubah ke landscape agar muat jika parameter nilainya banyak */
        @page { size: A4 landscape; margin: 15mm; }
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

    <div class="text-center mb-8">
        <h2 class="text-xl font-bold uppercase underline mb-4">Daftar Hadir & Rekap Nilai Akhir Peserta</h2>
        <table class="w-full text-left max-w-lg mx-auto text-sm">
            <tr><td class="font-bold w-32">Program</td><td class="w-4">:</td><td>{{ $kelas?->programPelatihan?->nama_program ?? 'Program Terhapus' }}</td></tr>
            <tr><td class="font-bold">Kelas</td><td>:</td><td>{{ $kelas?->nama_kelas ?? 'Kelas Terhapus' }}</td></tr>
            <tr><td class="font-bold">Periode</td><td>:</td><td>{{ \Carbon\Carbon::parse($kelas?->tanggal_mulai ?? now())->translatedFormat('d M Y') }} - {{ \Carbon\Carbon::parse($kelas?->tanggal_selesai ?? now())->translatedFormat('d M Y') }}</td></tr>
            <tr><td class="font-bold">Instruktur</td><td>:</td><td>{{ $kelas?->instruktur?->user?->name ?? 'Belum Ditentukan' }}</td></tr>
        </table>
    </div>

    @php
        // Tarik parameter dinamis dari fase-fase di kelas ini
        $fases = $kelas->fase ?? collect();
    @endphp

    <table class="w-full border-collapse border border-gray-800 text-left text-xs mb-8">
        <thead class="bg-gray-200">
            <tr>
                <th class="border border-gray-800 py-2 px-2 text-center w-8">No</th>
                <th class="border border-gray-800 py-2 px-2">Nama Peserta</th>
                <th class="border border-gray-800 py-2 px-2 text-center">NIK</th>
                <th class="border border-gray-800 py-2 px-2 text-center">Hadir</th>
                
                @if($fases->isEmpty())
                    <th class="border border-gray-800 py-2 px-2 text-center text-red-500">Fase Belum Dibuat</th>
                @else
                    @foreach($fases as $fase)
                        <th class="border border-gray-800 py-2 px-2 text-center">Fase: {{ $fase->nama_fase }}</th>
                    @endforeach
                @endif
                
                <th class="border border-gray-800 py-2 px-2 text-center font-bold">Rata-rata Akhir</th>
                <th class="border border-gray-800 py-2 px-2 text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pesertaKelas as $key => $item)
            @php
                // Hitung ulang nilai (karena di view cetak controller belum melakukan perhitungan rapor akhir)
                $totalNilai = 0;
                $faseDinilai = 0;
                $detailFase = [];
                
                foreach ($fases as $f) {
                    $nf = \App\Models\NilaiFase::where('fase_kelas_id', $f->id)->where('pendaftaran_id', $item->id)->first();
                    if ($nf) {
                        $totalNilai += $nf->nilai_rata_rata;
                        $faseDinilai++;
                        $detailFase[$f->id] = $nf->nilai_rata_rata;
                    } else {
                        $detailFase[$f->id] = 0;
                    }
                }
                
                // Prioritaskan nilai_rata_rata yang sudah dikunci, jika belum, hitung on the fly
                $rataRata = $item->status_kelulusan != 'menunggu' && $item->status_kelulusan != 'belum_dinilai' 
                            ? $item->nilai_rata_rata 
                            : ($faseDinilai > 0 ? round($totalNilai / $faseDinilai, 2) : 0);
                            
                $statusKelulusan = $rataRata >= 70 ? 'lulus' : 'tidak_lulus';
            @endphp
            <tr>
                <td class="border border-gray-800 py-2 px-2 text-center">{{ $key + 1 }}</td>
                <td class="border border-gray-800 py-2 px-2 font-bold">{{ $item->peserta?->user?->name ?? 'Peserta Terhapus' }}</td>
                <td class="border border-gray-800 py-2 px-2 text-center">{{ $item->peserta?->nik ?? '-' }}</td>
                <td class="border border-gray-800 py-2 px-2 text-center">{{ $item->kehadiran ?? 0 }}%</td>
                
                @if($fases->isEmpty())
                    <td class="border border-gray-800 py-2 px-2 text-center">-</td>
                @else
                    @foreach($fases as $fase)
                        <td class="border border-gray-800 py-2 px-2 text-center">{{ $detailFase[$fase->id] > 0 ? $detailFase[$fase->id] : '-' }}</td>
                    @endforeach
                @endif
                
                <td class="border border-gray-800 py-2 px-2 text-center font-black">{{ $rataRata }}</td>
                
                <td class="border border-gray-800 py-2 px-2 text-center font-bold uppercase">
                    @if($statusKelulusan == 'lulus')
                        <span class="text-green-700">Lulus</span>
                    @else
                        <span class="text-red-700">Gagal</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="{{ count($fases) + 6 }}" class="border border-gray-800 py-4 px-2 text-center italic">Tidak ada peserta di kelas ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="flex justify-between mt-12 text-sm">
        <div class="text-center w-64">
            <p>Mengetahui,</p>
            <p class="font-bold">Pimpinan LPK Bina Mandiri</p>
            <div class="h-24"></div>
            <p class="font-bold underline text-[#201e1f]">( ................................................ )</p>
        </div>
        <div class="text-center w-64">
            <p>Wonosobo, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p class="font-bold">Instruktur Pengampu</p>
            <div class="h-24"></div>
            <p class="font-bold underline text-[#201e1f]">{{ $kelas?->instruktur?->user?->name ?? '( ................................................ )' }}</p>
            <p class="text-xs text-gray-500">Spesialisasi: {{ $kelas?->instruktur?->spesialisasi_las ?? '-' }}</p>
        </div>
    </div>

</body>
</html>