<x-app-layout>
    <x-slot name="header">
        <!-- Flexbox untuk memisahkan Judul dan Tombol Cetak -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-bold text-xl text-hitam leading-tight">
                {{ __('Data Transaksi & Pembayaran') }}
            </h2>
            
            <!-- Tombol Cetak Membawa Parameter Filter (request()->query()) -->
            <a href="{{ route('admin.verifikasi_pembayaran.cetak_semua', request()->query()) }}" target="_blank" class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-100 px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak PDF Filter
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm">
                    <p class="text-sm font-bold text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            <!-- FILTER & SEARCH: COMPACT TOOLBAR -->
            <form action="{{ route('admin.verifikasi_pembayaran.index') }}" method="GET" class="mb-5 bg-white p-3 rounded-xl shadow-sm border border-gray-200 flex flex-col md:flex-row gap-3 items-center">
                
                <!-- Search Input dengan Icon (Lebih Ramping) -->
                <div class="w-full md:w-1/3 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama, NIK, atau LPK-xx..." class="w-full pl-9 border-gray-300 rounded-lg focus:border-oranye focus:ring-oranye text-sm transition py-2">
                </div>
                
                <!-- Filter Status -->
                <div class="w-full md:w-1/4">
                    <select name="status" class="w-full border-gray-300 rounded-lg focus:border-oranye focus:ring-oranye text-sm cursor-pointer transition py-2">
                        <option value="">Semua Status</option>
                        <option value="sukses" {{ request('status') == 'sukses' ? 'selected' : '' }}>🟢 Lunas</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>🟡 Pending</option>
                        <option value="batal" {{ request('status') == 'batal' ? 'selected' : '' }}>🔴 Batal</option>
                    </select>
                </div>
                
                <!-- Filter Program -->
                <div class="w-full md:w-1/4">
                    <select name="program" class="w-full border-gray-300 rounded-lg focus:border-oranye focus:ring-oranye text-sm cursor-pointer transition py-2">
                        <option value="">Semua Program</option>
                        @foreach($programs as $prog)
                            <option value="{{ $prog->id }}" {{ request('program') == $prog->id ? 'selected' : '' }}>{{ \Illuminate\Support\Str::limit($prog->nama_program, 25) }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Tombol Aksi (Terapkan & Reset) -->
                <div class="w-full md:w-auto flex flex-1 gap-2 justify-end">
                    <button type="submit" class="w-full md:w-auto bg-hitam text-white px-5 py-2 rounded-lg text-sm font-bold hover:bg-gray-800 transition shadow">
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'status', 'program']) && (request('search') != '' || request('status') != '' || request('program') != ''))
                        <a href="{{ route('admin.verifikasi_pembayaran.index') }}" title="Reset Filter" class="flex items-center justify-center px-3 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 border border-red-100 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </a>
                    @endif
                </div>

            </form>

            <!-- TABEL UTAMA -->
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
                                    <div class="text-[11px] text-gray-400">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y, H:i') }}</div>
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
                                    <a href="{{ route('admin.verifikasi_pembayaran.show', $item->id) }}" class="inline-flex items-center gap-1 bg-hitam text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-oranye transition shadow hover:shadow-md">
                                        Kelola Transaksi
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-16 text-center text-gray-400">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    <span class="block italic font-medium">Oops, tidak ada data transaksi yang sesuai pencarian Anda.</span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Link Pagination -->
                @if($pembayaran->hasPages())
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                        {{ $pembayaran->links() }}
                    </div>
                @endif
                
            </div>
            
        </div>
    </div>
</x-app-layout>