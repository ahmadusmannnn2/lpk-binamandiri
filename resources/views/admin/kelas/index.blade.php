<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Kelola Data Kelas') }}</h2>
            <a href="{{ route('admin.kelas.create') }}" class="bg-oranye hover:bg-[#c24b22] text-white font-bold py-2 px-4 rounded-lg shadow-md transition transform hover:-translate-y-1">
                + Buat Kelas Baru
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
                            <tr class="bg-gray-100 text-hitam uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Nama Kelas</th>
                                <th class="py-3 px-6 text-left">Program & Instruktur</th>
                                <th class="py-3 px-6 text-center">Tanggal</th>
                                <th class="py-3 px-6 text-center">Status</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @forelse($kelas as $item)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150">
                                <td class="py-3 px-6 font-bold text-hitam">
                                    {{ $item->nama_kelas }}
                                    <div class="text-xs font-normal text-gray-500">Kuota: {{ $item->kuota_peserta }} Peserta</div>
                                </td>
                                <td class="py-3 px-6">
                                    <div class="font-semibold text-oranye">{{ $item->programPelatihan->nama_program ?? 'Program Terhapus' }}</div>
                                    <div class="text-xs text-gray-500">Instruktur: {{ $item->instruktur->user->name ?? 'Instruktur Terhapus' }}</div>
                                </td>
                                <td class="py-3 px-6 text-center text-xs">
                                    <div>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}</div>
                                    <div>s/d</div>
                                    <div>{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</div>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    @if($item->status_kelas == 'menunggu')
                                        <span class="bg-yellow-200 text-yellow-700 py-1 px-3 rounded-full text-xs font-bold shadow-sm">Menunggu</span>
                                    @elseif($item->status_kelas == 'berjalan')
                                        <span class="bg-green-200 text-green-700 py-1 px-3 rounded-full text-xs font-bold shadow-sm">Berjalan</span>
                                    @else
                                        <span class="bg-gray-200 text-gray-700 py-1 px-3 rounded-full text-xs font-bold shadow-sm">Selesai</span>
                                    @endif
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center space-x-3">
                                        <a href="{{ route('admin.kelas.edit', $item->id) }}" class="text-blue-500 hover:text-blue-700 transition hover:scale-110 transform">Edit</a>
                                        <form action="{{ route('admin.kelas.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus kelas ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 transition hover:scale-110 transform">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-6 px-6 text-center text-gray-400 italic">Belum ada data kelas yang dibuat.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>