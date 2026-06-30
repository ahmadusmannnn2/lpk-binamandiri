<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi Pembayaran - {{ $pendaftaran->peserta->user->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { background-color: white !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .no-print { display: none !important; }
            .print-shadow-none { box-shadow: none !important; border: none !important; }
        }
        .watermark {
            position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 8rem; color: rgba(34, 197, 94, 0.1); font-weight: 900; z-index: 0; pointer-events: none; letter-spacing: 0.5rem;
        }
    </style>
</head>
<body class="bg-gray-100 py-10 flex justify-center text-gray-800 font-sans">

    <div class="bg-white w-full max-w-4xl p-12 shadow-2xl print-shadow-none relative border border-gray-200 overflow-hidden">
        
        <div class="watermark uppercase">LUNAS</div>

        <div class="no-print absolute top-6 right-6 flex gap-3 z-50">
            <button onclick="window.close()" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-bold text-sm transition">Tutup</button>
            <button onclick="window.print()" class="bg-[#de5e2e] hover:bg-[#c24b22] text-white px-4 py-2 rounded-lg font-bold text-sm shadow-md transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Kwitansi
            </button>
        </div>

        <div class="flex justify-between items-start border-b-4 border-[#de5e2e] pb-6 mb-8 relative z-10">
            <div class="flex items-center gap-4">
                @php
                    $nama1 = \App\Models\Pengaturan::where('kunci', 'nama_lpk_1')->value('nilai') ?? 'LPK';
                    $nama2 = \App\Models\Pengaturan::where('kunci', 'nama_lpk_2')->value('nilai') ?? 'BINA MANDIRI';
                    $alamat_cetak = \App\Models\Pengaturan::where('kunci', 'kontak_alamat')->value('nilai') ?? 'Jl. Karya Tralis No. 58, Jlamprang, Wonosobo, Jawa Tengah';
                    $telepon_cetak = \App\Models\Pengaturan::where('kunci', 'kontak_telepon')->value('nilai') ?? '-';
                    $email_cetak   = \App\Models\Pengaturan::where('kunci', 'kontak_email')->value('nilai') ?? '-';
                @endphp
                <div class="w-16 h-16 sm:w-20 sm:h-20 shrink-0">
                    <svg viewBox="0 0 100 100" class="w-full h-full" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="100" height="100" rx="20" fill="#201e1f"/>
                        <path d="M30 70V30L45 50L60 30V70" stroke="#de5e2e" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M70 30L70 70" stroke="#de5e2e" stroke-width="8" stroke-linecap="round"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-black tracking-widest uppercase text-[#201e1f]">{{ $nama1 }} <span class="text-[#de5e2e]">{{ $nama2 }}</span></h1>
                    <p class="font-bold text-gray-700 text-[10px] sm:text-xs">LEMBAGA PELATIHAN KERJA DAN SERTIFIKASI KOMPETENSI</p>
                    <p class="text-[9px] sm:text-[10px] text-gray-500 mt-0.5">📍 {{ $alamat_cetak }} &nbsp;|&nbsp; 📞 {{ $telepon_cetak }} &nbsp;|&nbsp; ✉ {{ $email_cetak }}</p>
                </div>
            </div>
            <div class="text-right">
                <h2 class="text-3xl font-black text-gray-300 uppercase tracking-widest mb-1">Kwitansi</h2>
                <p class="text-sm font-bold text-gray-600">No. Tagihan: <span class="text-[#de5e2e]">INV-LPK-{{ str_pad($pendaftaran->id, 5, '0', STR_PAD_LEFT) }}</span></p>
            </div>
        </div>

        <div class="relative z-10 mb-10">
            <table class="w-full text-left text-sm mb-6">
                <tbody>
                    <tr>
                        <td class="py-2 w-48 font-bold text-gray-600">Telah Terima Dari</td>
                        <td class="py-2 w-4 font-bold">:</td>
                        <td class="py-2 font-black text-lg text-gray-800">{{ $pendaftaran->peserta->user->name }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-bold text-gray-600">Nomor Induk / NIK</td>
                        <td class="py-2 font-bold">:</td>
                        <td class="py-2 font-medium text-gray-700">{{ $pendaftaran->peserta->nik }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-bold text-gray-600">Guna Pembayaran</td>
                        <td class="py-2 font-bold">:</td>
                        <td class="py-2 font-medium text-gray-700">Pendaftaran & Biaya Pelatihan Program <span class="font-bold text-[#de5e2e]">{{ $pendaftaran->kelas->programPelatihan->nama_program }}</span> - Kelas {{ $pendaftaran->kelas->nama_kelas }}</td>
                    </tr>
                    <!-- TAMBAHAN METODE & WAKTU -->
                    <tr>
                        <td class="py-2 font-bold text-gray-600">Metode Pembayaran</td>
                        <td class="py-2 font-bold">:</td>
                        <td class="py-2 font-black text-blue-700 uppercase tracking-wider">
                            {{ $pendaftaran->metode_pembayaran ?? 'Manual / Transfer Bukti' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="py-2 font-bold text-gray-600">Waktu Pembayaran</td>
                        <td class="py-2 font-bold">:</td>
                        <td class="py-2 font-medium text-gray-700">
                            {{ $pendaftaran->waktu_pembayaran ? \Carbon\Carbon::parse($pendaftaran->waktu_pembayaran)->timezone(config('app.timezone', 'Asia/Jakarta'))->translatedFormat('d F Y - H:i:s') . ' WIB' : \Carbon\Carbon::parse($pendaftaran->updated_at)->timezone(config('app.timezone', 'Asia/Jakarta'))->translatedFormat('d F Y - H:i:s') . ' WIB' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="relative z-10 mb-10 border border-gray-300 rounded-lg overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-100 border-b border-gray-300 text-gray-700">
                    <tr>
                        <th class="py-3 px-6 font-bold uppercase text-xs">Deskripsi Tagihan</th>
                        <th class="py-3 px-6 font-bold uppercase text-xs text-center w-32">Status</th>
                        <th class="py-3 px-6 font-bold uppercase text-xs text-right w-48">Jumlah (Rp)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr>
                        <td class="py-4 px-6">
                            <p class="font-bold text-gray-800 text-base">Biaya Pelatihan {{ $pendaftaran->kelas->programPelatihan->nama_program }}</p>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-md text-xs font-bold border border-green-300">LUNAS</span>
                        </td>
                        <td class="py-4 px-6 text-right font-bold text-gray-800 text-base">
                            {{ number_format($pendaftaran->kelas->programPelatihan->harga_pelatihan ?? 0, 0, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
                <tfoot class="bg-gray-50 border-t-2 border-gray-300">
                    <tr>
                        <td colspan="2" class="py-4 px-6 text-right font-black text-gray-700 uppercase tracking-widest text-sm">Total Pembayaran</td>
                        <td class="py-4 px-6 text-right font-black text-[#de5e2e] text-xl">
                            Rp {{ number_format($pendaftaran->kelas->programPelatihan->harga_pelatihan ?? 0, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="relative z-10 flex justify-between mt-16 pt-8">
            <div class="text-xs text-gray-400">
                <p>* Kwitansi ini sah dan diterbitkan secara otomatis oleh sistem.</p>
                <p>* Simpan kwitansi ini sebagai bukti pembayaran yang valid.</p>
            </div>
            
            <div class="text-center">
                <p class="text-sm text-gray-600 mb-16">Admin / Keuangan LPK</p>
                <div class="border-b border-gray-400 w-48 mx-auto mb-2"></div>
                <p class="font-bold text-gray-800 text-sm">{{ Auth::user()->name }}</p>
            </div>
        </div>

    </div>
</body>
</html>