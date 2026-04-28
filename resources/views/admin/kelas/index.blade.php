<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Kelola Data Kelas & Angkatan') }}</h2>
            <a href="{{ route('admin.kelas.create') }}" class="bg-oranye hover:bg-[#c24b22] text-white font-bold py-2 px-5 rounded-lg shadow-md transition transform hover:-translate-y-1 flex items-center gap-2 text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Buat Kelas Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                    <p class="font-bold">Berhasil</p><p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-hitam">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="min-w-full w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-hitam uppercase text-xs font-black tracking-wider leading-normal border-b-2 border-gray-200">
                                <th class="py-3 px-6 text-left">Nama Angkatan / Kelas</th>
                                <th class="py-3 px-6 text-left">Program & Instruktur</th>
                                <th class="py-3 px-6 text-center">Periode Jadwal</th>
                                <th class="py-3 px-6 text-center">Status</th>
                                <th class="py-3 px-6 text-center">Manajemen Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm">
                            @forelse($kelas as $item)
                            <tr class="border-b border-gray-100 hover:bg-orange-50/30 transition duration-150">
                                <td class="py-4 px-6 font-bold text-hitam text-base">
                                    {{ $item->nama_kelas }}
                                    <div class="text-xs font-bold text-gray-500 mt-1">Kuota: <span class="text-oranye">{{ $item->kuota_peserta }} Peserta</span></div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="font-bold text-oranye">{{ $item->programPelatihan->nama_program ?? 'Program Terhapus' }}</div>
                                    <div class="text-xs text-gray-500 mt-1">Instruktur: <span class="font-bold text-hitam">{{ $item->instruktur->user->name ?? 'Instruktur Terhapus' }}</span></div>
                                </td>
                                <td class="py-4 px-6 text-center text-xs text-gray-500 font-medium">
                                    <div>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}</div>
                                    <div class="text-oranye font-bold my-0.5">s/d</div>
                                    <div>{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</div>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @if($item->status_kelas == 'menunggu')
                                        <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-[10px] font-bold shadow-sm uppercase tracking-wider border border-yellow-200">Menunggu</span>
                                    @elseif($item->status_kelas == 'berjalan')
                                        <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-[10px] font-bold shadow-sm uppercase tracking-wider border border-green-200">Berjalan</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 py-1 px-3 rounded-full text-[10px] font-bold shadow-sm uppercase tracking-wider border border-gray-200">Selesai</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <div class="flex item-center justify-center space-x-2">
                                        <a href="{{ route('admin.kelas.show', $item->id) }}" class="bg-indigo-50 text-indigo-600 hover:bg-indigo-500 hover:text-white border border-indigo-200 px-3 py-1.5 rounded-md text-xs font-bold transition duration-300 shadow-sm">Detail</a>
                                        
                                        <a href="{{ route('admin.kelas.edit', $item->id) }}" class="bg-blue-50 text-blue-600 hover:bg-blue-500 hover:text-white border border-blue-200 px-3 py-1.5 rounded-md text-xs font-bold transition duration-300 shadow-sm">Edit</a>
                                        
                                        <form action="{{ route('admin.kelas.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus kelas ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-50 text-red-600 hover:bg-red-500 hover:text-white border border-red-200 px-3 py-1.5 rounded-md text-xs font-bold transition duration-300 shadow-sm">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-10 px-6 text-center text-gray-400 italic">Belum ada data kelas yang dibuat.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>