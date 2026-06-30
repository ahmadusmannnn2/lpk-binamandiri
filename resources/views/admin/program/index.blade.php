<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-hitam leading-tight">
                    {{ __('Kelola Program Pelatihan') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Daftar semua program sertifikasi dan pelatihan yang tersedia di LPK.</p>
            </div>
            <a href="{{ route('admin.program.create') }}" class="bg-hitam hover:bg-oranye text-white font-bold py-2.5 px-5 rounded-xl shadow-lg transition duration-300 transform hover:-translate-y-1 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Program
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
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-hitam uppercase text-xs font-black tracking-wider border-b-2 border-gray-200">
                                    <th class="py-4 px-6 rounded-tl-lg text-center w-12">No</th>
                                    <th class="py-4 px-6">Informasi Program</th>
                                    <th class="py-4 px-6 text-center">Durasi</th>
                                    <th class="py-4 px-6 text-right">Harga (Rp)</th>
                                    <th class="py-4 px-6 text-center rounded-tr-lg w-32">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-medium">
                                @forelse($program as $key => $item)
                                <tr class="border-b border-gray-100 hover:bg-orange-50/50 transition duration-150">
                                    <td class="py-4 px-6 text-center text-gray-400 font-bold">{{ $key + 1 }}</td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-4">
                                            @if($item->gambar)
                                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama_program }}" class="w-16 h-12 object-cover rounded-lg shadow-sm border border-gray-100 shrink-0">
                                            @else
                                                <div class="w-16 h-12 bg-orange-50/50 rounded-lg flex items-center justify-center text-orange-200 border border-orange-100 shrink-0">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-black text-hitam text-base">{{ $item->nama_program }}</div>
                                                <div class="text-xs text-gray-500 mt-1 line-clamp-1 max-w-xs" title="{{ $item->deskripsi }}">{{ $item->deskripsi ?: 'Tidak ada deskripsi' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-xs font-bold border border-blue-100">{{ $item->durasi_hari }} Hari</span>
                                    </td>
                                    <td class="py-4 px-6 text-right font-black text-oranye text-base">
                                        {{ number_format($item->harga_pelatihan, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('admin.program.edit', $item->id) }}" class="bg-gray-100 hover:bg-blue-100 text-gray-600 hover:text-blue-600 p-2 rounded-lg transition duration-200" title="Edit Program">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <form action="{{ route('admin.program.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Peringatan: Menghapus program ini mungkin akan memengaruhi data kelas dan peserta yang terkait. Yakin ingin menghapus?');" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-gray-100 hover:bg-red-100 text-gray-600 hover:text-red-600 p-2 rounded-lg transition duration-200" title="Hapus Program">
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
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                        </div>
                                        <p class="text-gray-500 font-bold text-lg">Belum ada program pelatihan.</p>
                                        <p class="text-gray-400 text-sm mt-1">Silakan klik "Tambah Program" untuk mulai membuat katalog pelatihan.</p>
                                    </td>
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