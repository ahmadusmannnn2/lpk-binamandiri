<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-hitam leading-tight">
                {{ __('Kelola Program Pelatihan') }}
            </h2>
            <a href="{{ route('admin.program.create') }}" class="bg-oranye hover:bg-[#c24b22] text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 transform hover:-translate-y-1">
                + Tambah Program
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
                    <p class="font-bold">Berhasil</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-hitam">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100 text-hitam uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">No</th>
                                    <th class="py-3 px-6 text-left">Nama Program</th>
                                    <th class="py-3 px-6 text-left">Harga (Rp)</th>
                                    <th class="py-3 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @forelse($program as $key => $item)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150">
                                    <td class="py-3 px-6 whitespace-nowrap font-medium">{{ $key + 1 }}</td>
                                    <td class="py-3 px-6 font-bold text-hitam">{{ $item->nama_program }}</td>
                                    <td class="py-3 px-6 text-oranye font-semibold">{{ number_format($item->harga_pelatihan, 0, ',', '.') }}</td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center space-x-3">
                                            <a href="{{ route('admin.program.edit', $item->id) }}" class="text-blue-500 hover:text-blue-700 hover:scale-110 transition transform">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.program.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus program ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 hover:scale-110 transition transform">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-6 px-6 text-center text-gray-400 italic">Belum ada data program pelatihan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>