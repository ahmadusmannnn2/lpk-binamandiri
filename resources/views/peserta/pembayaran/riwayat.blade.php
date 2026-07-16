<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">
            {{ __('Riwayat Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-oranye">
                <div class="p-6 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-xs font-black tracking-wider border-b-2 border-gray-200">
                                <th class="py-4 px-4 rounded-tl-lg">Nomor Order</th>
                                <th class="py-4 px-4">Program & Kelas</th>
                                <th class="py-4 px-4 text-center">Nominal (Rp)</th>
                                <th class="py-4 px-4 text-center">Metode Bank / Pembayaran</th>
                                <th class="py-4 px-4 text-center">Waktu Transaksi</th>
                                <th class="py-4 px-4 text-center rounded-tr-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm divide-y divide-gray-100">
                            @forelse($riwayatPembayaran as $item)
                            <tr class="hover:bg-orange-50/50 transition">
                                <td class="py-4 px-4 font-medium">
                                    <div class="text-hitam font-bold text-base">LPK-{{ $item->id }}</div>
                                    <div class="text-xs text-gray-500 mt-1">Ref: {{ $item->midtrans_order_id ?? '-' }}</div>
                                </td>
                                
                                <td class="py-4 px-4">
                                    <div class="font-bold text-oranye">{{ $item->kelas->programPelatihan->nama_program ?? '-' }}</div>
                                    <div class="font-bold text-xs text-gray-500 mt-1">
                                        {{ $item->kelas->nama_kelas ?? '-' }}
                                    </div>
                                </td>

                                <td class="py-4 px-4 text-center">
                                    <div class="font-black text-hitam">
                                        {{ number_format($item->kelas->programPelatihan->harga_pelatihan ?? 0, 0, ',', '.') }}
                                    </div>
                                </td>
                                
                                <td class="py-4 px-4 text-center">
                                    @if($item->status_pembayaran == 'sukses')
                                        <span class="bg-green-50 text-green-800 py-1 px-3 rounded-full text-[10px] font-bold shadow-sm uppercase border border-green-200">
                                            {{ $item->metode_pembayaran ?? 'Manual / Tidak Diketahui' }}
                                        </span>
                                    @elseif($item->status_pembayaran == 'pending')
                                        <span class="bg-yellow-50 text-yellow-800 py-1 px-3 rounded-full text-[10px] font-bold shadow-sm uppercase border border-yellow-200 animate-pulse">
                                            Menunggu Pembayaran
                                        </span>
                                    @else
                                        <span class="bg-red-50 text-red-800 py-1 px-3 rounded-full text-[10px] font-bold shadow-sm uppercase border border-red-200">
                                            Batal / Kadaluarsa
                                        </span>
                                    @endif
                                </td>

                                <td class="py-4 px-4 text-center">
                                    @if($item->status_pembayaran == 'sukses')
                                        <div class="text-hitam font-bold">
                                            {{ $item->waktu_pembayaran ? \Carbon\Carbon::parse($item->waktu_pembayaran)->format('d M Y') : '-' }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            {{ $item->waktu_pembayaran ? \Carbon\Carbon::parse($item->waktu_pembayaran)->format('H:i:s') . ' WIB' : '-' }}
                                        </div>
                                    @else
                                        <div class="text-gray-400 font-medium">-</div>
                                    @endif
                                </td>
                                
                                <td class="py-4 px-4 text-center">
                                    @if($item->status_pembayaran == 'sukses')
                                        <a href="{{ route('peserta.riwayat.cetak', $item->id) }}" target="_blank" class="inline-flex items-center gap-1 bg-green-600 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-green-700 transition shadow hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                            Kwitansi
                                        </a>
                                    @elseif($item->status_pembayaran == 'pending')
                                        <a href="{{ route('peserta.pembayaran.bayar', $item->id) }}" class="inline-flex items-center gap-1 bg-oranye text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-hitam transition shadow hover:shadow-md">
                                            Bayar
                                        </a>
                                    @else
                                        <span class="text-gray-400 font-medium text-xs">-</span>
                                    @endif
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-16 text-center text-gray-400">
                                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    <span class="block italic font-medium text-base">Belum ada riwayat pembayaran yang berhasil.</span>
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
