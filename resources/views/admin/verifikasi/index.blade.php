<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">
            {{ __('Verifikasi Biodata Pendaftar') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm">
                    <p class="text-sm font-bold text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            <!-- FILTER & SEARCH: COMPACT TOOLBAR -->
            <form action="{{ route('admin.verifikasi.index') }}" method="GET" class="mb-5 bg-white p-3 rounded-xl shadow-sm border border-gray-200 flex flex-col md:flex-row gap-3 items-center">
                
                <!-- Search Input dengan Icon -->
                <div class="w-full md:w-1/2 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama, Email, atau NIK..." class="w-full pl-9 border-gray-300 rounded-lg focus:border-oranye focus:ring-oranye text-sm transition py-2">
                </div>
                
                <!-- Filter Status -->
                <div class="w-full md:w-1/3">
                    <select name="status" class="w-full border-gray-300 rounded-lg focus:border-oranye focus:ring-oranye text-sm cursor-pointer transition py-2">
                        <option value="">Semua Status</option>
                        <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>🟡 Menunggu Verifikasi</option>
                        <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>🟢 Disetujui</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>🔴 Ditolak / Perlu Perbaikan</option>
                    </select>
                </div>
                
                <!-- Tombol Aksi (Terapkan & Reset) -->
                <div class="w-full md:w-auto flex flex-1 gap-2 justify-end">
                    <button type="submit" class="w-full md:w-auto bg-hitam text-white px-5 py-2 rounded-lg text-sm font-bold hover:bg-gray-800 transition shadow">
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'status']) && (request('search') != '' || request('status') != ''))
                        <a href="{{ route('admin.verifikasi.index') }}" title="Reset Filter" class="flex items-center justify-center px-3 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 border border-red-100 transition">
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
                                <th class="py-4 px-4 rounded-tl-lg">Tgl Pengajuan</th>
                                <th class="py-4 px-4">Identitas Pendaftar</th>
                                <th class="py-4 px-4 text-center">Status Berkas</th>
                                <th class="py-4 px-4 text-center rounded-tr-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm divide-y divide-gray-100">
                            @forelse($peserta as $item)
                            <tr class="hover:bg-orange-50/50 transition">
                                <td class="py-4 px-4">
                                    <div class="font-bold text-gray-700">{{ \Carbon\Carbon::parse($item->updated_at)->format('d M Y') }}</div>
                                    <div class="text-[11px] text-gray-400">{{ \Carbon\Carbon::parse($item->updated_at)->format('H:i') }} WIB</div>
                                </td>
                                
                                <td class="py-4 px-4">
                                    <div class="font-bold text-hitam">{{ $item->user->name ?? 'User Terhapus' }}</div>
                                    <div class="font-medium text-[11px] text-gray-500 mt-0.5">
                                        {{ $item->user->email ?? '-' }} | NIK: {{ $item->nik ?? '-' }}
                                    </div>
                                </td>
                                
                                <td class="py-4 px-4 text-center">
                                    @if($item->status_biodata == 'menunggu')
                                        <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-[10px] font-bold shadow-sm uppercase animate-pulse">Menunggu</span>
                                    @elseif($item->status_biodata == 'disetujui')
                                        <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-[10px] font-bold shadow-sm uppercase">Disetujui</span>
                                    @elseif($item->status_biodata == 'ditolak')
                                        <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-[10px] font-bold shadow-sm uppercase">Ditolak</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 py-1 px-3 rounded-full text-[10px] font-bold shadow-sm uppercase">Belum Lengkap</span>
                                    @endif
                                </td>
                                
                                <td class="py-4 px-4 text-center">
                                    <a href="{{ route('admin.verifikasi.show', $item->id) }}" class="inline-flex items-center gap-1 bg-hitam text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-oranye transition shadow hover:shadow-md">
                                        @if($item->status_biodata == 'menunggu')
                                            Tinjau Berkas
                                        @else
                                            Lihat Detail
                                        @endif
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-16 text-center text-gray-400">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <span class="block italic font-medium">Tidak ada data peserta yang sesuai dengan pencarian Anda.</span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Link Pagination -->
                @if($peserta->hasPages())
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                        {{ $peserta->links() }}
                    </div>
                @endif
                
            </div>
            
        </div>
    </div>
</x-app-layout>