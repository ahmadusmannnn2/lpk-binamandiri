<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-hitam leading-tight">
                    {{ __('Kelola Instruktur') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Daftar semua instruktur pengajar yang terdaftar di sistem LPK.</p>
            </div>
            <a href="{{ route('admin.instruktur.create') }}" class="bg-hitam hover:bg-oranye text-white font-bold py-2.5 px-5 rounded-xl shadow-lg transition duration-300 transform hover:-translate-y-1 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                Tambah Instruktur
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
                                    <th class="py-4 px-6">Identitas Instruktur</th>
                                    <th class="py-4 px-6">Informasi Kontak</th>
                                    <th class="py-4 px-6">Keahlian (Program)</th>
                                    <th class="py-4 px-6 text-center rounded-tr-lg w-32">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-medium">
                                @forelse($instruktur as $key => $item)
                                <tr class="border-b border-gray-100 hover:bg-orange-50/50 transition duration-150">
                                    <td class="py-4 px-6 text-center text-gray-400 font-bold">{{ $key + 1 }}</td>
                                    <td class="py-4 px-6">
                                        <div class="font-black text-hitam text-base">{{ $item->user->name ?? 'Akun Terhapus' }}</div>
                                        <div class="text-xs text-gray-500 mt-0.5">Bergabung: {{ $item->created_at->format('M Y') }}</div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="font-bold text-gray-700">{{ $item->user->email ?? '-' }}</div>
                                        <div class="text-xs text-gray-500 mt-0.5">{{ $item->nomor_telepon ?? 'No HP belum diisi' }}</div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="bg-orange-50 text-oranye px-3 py-1 rounded-full text-xs font-bold border border-orange-100">{{ $item->keahlian ?? 'Belum diisi' }}</span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('admin.instruktur.edit', $item->id) }}" class="bg-gray-100 hover:bg-blue-100 text-gray-600 hover:text-blue-600 p-2 rounded-lg transition duration-200" title="Edit Instruktur">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <form action="{{ route('admin.instruktur.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Peringatan: Menghapus instruktur ini juga akan menghapus AKUN LOGIN miliknya. Yakin ingin menghapus secara permanen?');" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-gray-100 hover:bg-red-100 text-gray-600 hover:text-red-600 p-2 rounded-lg transition duration-200" title="Hapus Instruktur">
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
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        </div>
                                        <p class="text-gray-500 font-bold text-lg">Belum ada data instruktur.</p>
                                        <p class="text-gray-400 text-sm mt-1">Silakan klik "Tambah Instruktur" untuk mendaftarkan pengajar baru.</p>
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