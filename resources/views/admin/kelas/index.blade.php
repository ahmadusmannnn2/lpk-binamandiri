<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-hitam leading-tight">
                    {{ __('Kelola Data Kelas & Angkatan') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Daftar semua kelas pelatihan beserta jadwal dan instruktur pengajarnya.</p>
            </div>
            <a href="{{ route('admin.kelas.create') }}" class="bg-hitam hover:bg-oranye text-white font-bold py-2.5 px-5 rounded-xl shadow-lg transition duration-300 transform hover:-translate-y-1 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Buat Kelas Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl shadow-sm flex items-center">
                    <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <p class="font-bold text-green-800">Berhasil</p>
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-oranye">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="min-w-full w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-hitam uppercase text-xs font-black tracking-wider leading-normal border-b-2 border-gray-200">
                                <th class="py-4 px-6 text-left rounded-tl-lg">Nama Angkatan / Kelas</th>
                                <th class="py-4 px-6 text-left">Program & Instruktur</th>
                                <th class="py-4 px-6 text-center">Periode Jadwal</th>
                                <th class="py-4 px-6 text-center">Status</th>
                                <th class="py-4 px-6 text-center rounded-tr-lg w-40">Manajemen Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm">
                            @forelse($kelas as $item)
                            <tr class="border-b border-gray-100 hover:bg-orange-50/50 transition duration-150">
                                <td class="py-4 px-6 font-bold text-hitam text-base">
                                    {{ $item->nama_kelas }}
                                    <div class="text-xs font-bold text-gray-500 mt-1 flex items-center gap-1">
                                        <svg class="w-3 h-3 text-oranye" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        Kuota: <span class="text-oranye">{{ $item->kuota_peserta }} Peserta</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="font-black text-oranye text-sm">{{ $item->programPelatihan->nama_program ?? 'Program Terhapus' }}</div>
                                    <div class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        <span class="font-bold text-hitam">{{ $item->instruktur->user->name ?? 'Instruktur Terhapus' }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-center text-xs text-gray-500 font-medium">
                                    <div class="bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg inline-block border border-blue-100">
                                        <div>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}</div>
                                        <div class="text-blue-400 font-black my-0.5 text-[10px] uppercase">Sampai</div>
                                        <div>{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @if($item->status_kelas == 'menunggu')
                                        <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-[10px] font-black shadow-sm uppercase tracking-wider border border-yellow-200">Menunggu</span>
                                    @elseif($item->status_kelas == 'berjalan')
                                        <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-[10px] font-black shadow-sm uppercase tracking-wider border border-green-200 animate-pulse">Berjalan</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 py-1 px-3 rounded-full text-[10px] font-black shadow-sm uppercase tracking-wider border border-gray-200">Selesai</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <!-- Tombol Show/Detail -->
                                        <a href="{{ route('admin.kelas.show', $item->id) }}" class="bg-gray-100 hover:bg-oranye text-gray-600 hover:text-white p-2 rounded-lg transition duration-200" title="Detail Kelas">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('admin.kelas.edit', $item->id) }}" class="bg-gray-100 hover:bg-blue-500 text-gray-600 hover:text-white p-2 rounded-lg transition duration-200" title="Edit Kelas">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('admin.kelas.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus kelas ini? Ini akan memengaruhi data peserta yang terdaftar.');" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-gray-100 hover:bg-red-500 text-gray-600 hover:text-white p-2 rounded-lg transition duration-200" title="Hapus Kelas">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-12 px-6 text-center">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    </div>
                                    <p class="text-gray-500 font-bold text-lg">Belum ada kelas yang dibuat.</p>
                                    <p class="text-gray-400 text-sm mt-1">Silakan klik "Buat Kelas Baru" untuk menyusun jadwal pelatihan.</p>
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