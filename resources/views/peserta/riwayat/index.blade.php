<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">
            {{ __('Riwayat Pendaftaran & Tagihan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(request('bayar') === 'sukses')
            <div id="bayar-sukses-alert" class="mb-6 bg-green-50 border border-green-200 rounded-2xl p-5 flex items-start gap-4 shadow-sm">
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="font-black text-green-800 text-base">🎉 Pembayaran Berhasil!</p>
                    <p class="text-sm text-green-700 mt-0.5">Pendaftaran Anda telah dikonfirmasi. Selamat bergabung dengan program pelatihan LPK Bina Mandiri!</p>
                </div>
                <button onclick="document.getElementById('bayar-sukses-alert').remove()" class="ml-auto text-green-400 hover:text-green-600 shrink-0">✕</button>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-oranye">
                <div class="p-6 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-xs font-black tracking-wider border-b-2 border-gray-200">
                                <th class="py-4 px-4 rounded-tl-lg">Nomor Order & Waktu</th>
                                <th class="py-4 px-4">Program & Kelas</th>
                                <th class="py-4 px-4 text-center">Status Berkas</th>
                                <th class="py-4 px-4 text-center">Status Pembayaran</th>
                                <th class="py-4 px-4 text-center rounded-tr-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm divide-y divide-gray-100">
                            @forelse($riwayat as $item)
                            <tr class="hover:bg-orange-50/50 transition">
                                <td class="py-4 px-4 font-medium">
                                    <div class="text-hitam font-bold text-base">LPK-{{ $item->id }}</div>
                                    <div class="text-xs text-gray-400 mt-1">{{ \Carbon\Carbon::parse($item->tanggal_daftar)->format('d M Y, H:i') }} WIB</div>
                                </td>
                                
                                <td class="py-4 px-4">
                                    <div class="font-bold text-oranye">{{ $item->kelas->programPelatihan->nama_program ?? '-' }}</div>
                                    <div class="font-bold text-xs text-gray-500 mt-1">
                                        {{ $item->kelas->nama_kelas ?? '-' }}
                                    </div>
                                </td>

                                <td class="py-4 px-4 text-center">
                                    @if($item->status_pendaftaran == 'disetujui')
                                        <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-[10px] font-bold shadow-sm uppercase">Disetujui</span>
                                    @elseif($item->status_pendaftaran == 'menunggu_verifikasi')
                                        <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-[10px] font-bold shadow-sm uppercase">Menunggu</span>
                                    @else
                                        <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-[10px] font-bold shadow-sm uppercase">Ditolak</span>
                                    @endif
                                </td>
                                
                                <td class="py-4 px-4 text-center">
                                    @if($item->status_pembayaran == 'sukses')
                                        <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-[10px] font-bold shadow-sm uppercase border border-green-200">
                                            LUNAS
                                        </span>
                                        <p class="text-[10px] text-gray-500 font-bold mt-1">{{ $item->metode_pembayaran ?? 'Otomatis' }}</p>
                                    @elseif($item->status_pembayaran == 'pending')
                                        <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-[10px] font-bold shadow-sm uppercase border border-yellow-200 animate-pulse">
                                            Belum Dibayar
                                        </span>
                                        <p class="text-[10px] font-bold text-red-500 mt-1">Rp {{ number_format($item->kelas->programPelatihan->harga_pelatihan ?? 0, 0, ',', '.') }}</p>
                                    @else
                                        <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-[10px] font-bold shadow-sm uppercase">Batal</span>
                                    @endif
                                </td>
                                
                                <!-- INI BAGIAN YANG DIUBAH MENJADI TOMBOL LIHAT DETAIL SAJA -->
                                <td class="py-4 px-4 text-center">
                                    <a href="{{ route('peserta.riwayat.show', $item->id) }}" class="inline-flex items-center gap-1 bg-hitam text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-oranye transition shadow hover:shadow-md">
                                        Lihat Detail
                                    </a>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-16 text-center text-gray-400">
                                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                    <span class="block italic font-medium text-base">Anda belum memiliki riwayat pendaftaran.</span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>