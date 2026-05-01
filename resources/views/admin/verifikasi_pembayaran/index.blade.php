<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">
            {{ __('Data Transaksi & Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm">
                    <p class="text-sm font-bold text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-hitam">
                <div class="p-6 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-xs font-black tracking-wider border-b-2 border-gray-200">
                                <th class="py-4 px-4 rounded-tl-lg">Order / Tgl</th>
                                <th class="py-4 px-4">Identitas Peserta</th>
                                <th class="py-4 px-4">Program / Kelas</th>
                                <th class="py-4 px-4 text-center">Status Pembayaran</th>
                                <th class="py-4 px-4 text-center rounded-tr-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm divide-y divide-gray-100">
                            @forelse($pembayaran as $item)
                            <tr class="hover:bg-orange-50/50 transition">
                                <td class="py-4 px-4 font-medium">
                                    <div class="text-hitam font-bold">LPK-{{ $item->id }}</div>
                                    <div class="text-[11px] text-gray-400">{{ \Carbon\Carbon::parse($item->tanggal_daftar)->format('d M Y, H:i') }}</div>
                                </td>
                                
                                <td class="py-4 px-4">
                                    <div class="font-bold text-hitam">{{ $item->peserta->user->name ?? 'Akun Terhapus' }}</div>
                                    <div class="font-medium text-[11px] text-gray-500 mt-0.5">
                                        NIK: {{ $item->peserta->nik ?? '-' }}
                                    </div>
                                </td>
                                
                                <td class="py-4 px-4">
                                    <div class="font-bold text-oranye">{{ $item->kelas->nama_kelas ?? '-' }}</div>
                                    <div class="text-[11px] text-gray-500 font-bold mt-0.5">
                                        Rp {{ number_format($item->kelas->programPelatihan->harga_pelatihan ?? 0, 0, ',', '.') }}
                                    </div>
                                </td>
                                
                                <td class="py-4 px-4 text-center">
                                    @if($item->status_pembayaran == 'sukses')
                                        <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-[10px] font-bold shadow-sm uppercase">Lunas</span>
                                    @elseif($item->status_pembayaran == 'pending')
                                        <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-[10px] font-bold shadow-sm uppercase animate-pulse">Menunggu</span>
                                    @else
                                        <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-[10px] font-bold shadow-sm uppercase">Batal</span>
                                    @endif
                                </td>
                                
                                <td class="py-4 px-4 text-center">
                                    <!-- SATU TOMBOL SAJA AGAR BERSIH -->
                                    <a href="{{ route('admin.verifikasi_pembayaran.show', $item->id) }}" class="inline-flex items-center gap-1 bg-hitam text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-oranye transition shadow hover:shadow-md">
                                        Kelola Transaksi
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-gray-400">
                                    <span class="block italic font-medium">Belum ada riwayat transaksi pembayaran.</span>
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