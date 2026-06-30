<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-hitam leading-tight">
                {{ __('Data Master Kelas') }}
            </h2>
            <a href="{{ route('admin.kelas.create') }}" class="bg-[#de5e2e] hover:bg-[#c24b22] text-white px-4 py-2 rounded-lg text-sm font-bold shadow-md transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Kelas
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
            <form action="{{ route('admin.kelas.index') }}" method="GET" class="mb-5 bg-white p-3 rounded-xl shadow-sm border border-gray-200 flex flex-col md:flex-row gap-3 items-center">
                
                <!-- Search -->
                <div class="w-full md:w-1/3 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama Kelas / Instruktur..." class="w-full pl-9 border-gray-300 rounded-lg focus:border-oranye focus:ring-oranye text-sm transition py-2">
                </div>
                
                <!-- Filter Status Otomatis -->
                <div class="w-full md:w-1/5">
                    <select name="status" class="w-full border-gray-300 rounded-lg focus:border-oranye focus:ring-oranye text-sm cursor-pointer transition py-2">
                        <option value="">Semua Status</option>
                        <option value="akan_datang" {{ request('status') == 'akan_datang' ? 'selected' : '' }}>🟡 Akan Datang</option>
                        <option value="berjalan" {{ request('status') == 'berjalan' ? 'selected' : '' }}>🟢 Sedang Berjalan</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>🔵 Selesai</option>
                    </select>
                </div>
                
                <!-- Filter Program -->
                <div class="w-full md:w-1/5">
                    <select name="program" class="w-full border-gray-300 rounded-lg focus:border-oranye focus:ring-oranye text-sm cursor-pointer transition py-2">
                        <option value="">Semua Program</option>
                        @foreach($programs as $prog)
                            <option value="{{ $prog->id }}" {{ request('program') == $prog->id ? 'selected' : '' }}>{{ \Illuminate\Support\Str::limit($prog->nama_program, 25) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Urutan -->
                <div class="w-full md:w-1/5">
                    <select name="urutan" class="w-full border-gray-300 rounded-lg focus:border-oranye focus:ring-oranye text-sm cursor-pointer transition py-2">
                        <option value="terbaru" {{ request('urutan', 'terbaru') == 'terbaru' ? 'selected' : '' }}>⬇ Terbaru Dibuat</option>
                        <option value="terlama" {{ request('urutan') == 'terlama' ? 'selected' : '' }}>⬆ Terlama Dibuat</option>
                        <option value="mulai_asc" {{ request('urutan') == 'mulai_asc' ? 'selected' : '' }}>📅 Tanggal Mulai (Awal)</option>
                        <option value="mulai_desc" {{ request('urutan') == 'mulai_desc' ? 'selected' : '' }}>📅 Tanggal Mulai (Akhir)</option>
                    </select>
                </div>
                
                <!-- Tombol -->
                <div class="w-full md:w-auto flex flex-1 gap-2 justify-end">
                    <button type="submit" class="w-full md:w-auto bg-hitam text-white px-5 py-2 rounded-lg text-sm font-bold hover:bg-gray-800 transition shadow">Filter</button>
                    @if(request()->hasAny(['search', 'status', 'program', 'urutan']) && (request('search') != '' || request('status') != '' || request('program') != '' || (request('urutan') && request('urutan') != 'terbaru')))
                        <a href="{{ route('admin.kelas.index') }}" title="Reset Filter" class="flex items-center justify-center px-3 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 border border-red-100 transition">
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
                                <th class="py-4 px-4 rounded-tl-lg">Nama Kelas / Angkatan</th>
                                <th class="py-4 px-4">Program Pelatihan</th>
                                <th class="py-4 px-4 text-center">Instruktur</th>
                                <th class="py-4 px-4 text-center">Peserta</th>
                                <th class="py-4 px-4 text-center">Status</th>
                                <th class="py-4 px-4 text-center rounded-tr-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm divide-y divide-gray-100">
                            @forelse($kelas as $item)
                            <tr class="hover:bg-orange-50/50 transition">
                                <td class="py-4 px-4">
                                    <div class="font-bold text-hitam text-base">{{ $item->nama_kelas }}</div>
                                    <div class="text-[11px] text-gray-500 mt-1">
                                        {{ $item->tanggal_mulai ? \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') : 'Belum Mulai' }} - 
                                        {{ $item->tanggal_selesai ? \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') : 'Selesai' }}
                                    </div>
                                </td>
                                
                                <td class="py-4 px-4">
                                    <div class="font-bold text-oranye">{{ $item->programPelatihan->nama_program ?? '-' }}</div>
                                </td>
                                
                                <td class="py-4 px-4 text-center font-medium text-gray-700">
                                    {{ $item->instruktur->user->name ?? '-' }}
                                </td>

                                <td class="py-4 px-4 text-center">
                                    <span class="inline-block bg-blue-50 text-blue-700 py-1 px-3 rounded-full text-[11px] font-bold border border-blue-200">
                                        {{ $item->pendaftaran_count }} / {{ $item->kuota_peserta }}
                                    </span>
                                </td>
                                
                                <td class="py-4 px-4 text-center">
                                    @php
                                        $today = now()->toDateString();
                                        $mulai = $item->tanggal_mulai;
                                        $selesai = $item->tanggal_selesai;
                                    @endphp
                                    @if($mulai && $mulai > $today)
                                        <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-[10px] font-bold shadow-sm uppercase">Akan Datang</span>
                                    @elseif($selesai && $selesai < $today)
                                        <span class="bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-[10px] font-bold shadow-sm uppercase">Selesai</span>
                                    @else
                                        <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-[10px] font-bold shadow-sm uppercase">Berjalan</span>
                                    @endif
                                </td>
                                
                                <td class="py-4 px-4 text-center space-x-2">
                                    <a href="{{ route('admin.kelas.edit', $item->id) }}" class="inline-flex items-center gap-1 bg-gray-100 text-gray-700 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-gray-200 transition">
                                        Edit
                                    </a>
                                    
                                    <form action="{{ route('admin.kelas.destroy', $item->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus kelas ini?');" class="inline-flex items-center gap-1 bg-red-50 text-red-600 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-red-100 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-16 text-center text-gray-400">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    <span class="block italic font-medium">Belum ada data kelas yang sesuai pencarian.</span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Link Pagination -->
                @if($kelas->hasPages())
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                        {{ $kelas->links() }}
                    </div>
                @endif
                
            </div>
            
        </div>
    </div>
</x-app-layout>