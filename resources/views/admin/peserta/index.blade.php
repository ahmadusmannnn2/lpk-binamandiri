<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-hitam leading-tight">
                {{ __('Kelola Data Peserta') }}
            </h2>
            <a href="{{ route('admin.peserta.create') }}"
                class="bg-oranye hover:bg-[#c24b22] text-white font-bold py-2 px-5 rounded-lg shadow-lg transition duration-300 transform hover:-translate-y-1 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Peserta
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-bold text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border-t-4 border-hitam">
                <div class="p-0 sm:p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-hitam uppercase text-xs font-black tracking-wider border-b-2 border-gray-200">
                                    <th class="py-4 px-6 text-center rounded-tl-lg">Foto</th>
                                    <th class="py-4 px-6 text-left">Info Peserta</th>
                                    <th class="py-4 px-6 text-left">NIK</th>
                                    <th class="py-4 px-6 text-left">Kontak / Email</th>
                                    <th class="py-4 px-6 text-center rounded-tr-lg">Manajemen Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm">
                                @forelse($peserta as $item)
                                    <tr class="border-b border-gray-100 hover:bg-orange-50/30 transition duration-200">
                                        <td class="py-3 px-6 text-center">
                                            @if($item->pas_foto)
                                                <img src="{{ asset('storage/' . $item->pas_foto) }}" alt="Foto"
                                                    class="w-12 h-12 rounded-full object-cover border-2 border-oranye mx-auto shadow-sm">
                                            @else
                                                <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mx-auto border-2 border-dashed border-gray-300 text-[10px] font-bold text-gray-400">
                                                    No Pic
                                                </div>
                                            @endif
                                        </td>
                                        <td class="py-3 px-6">
                                            <div class="font-bold text-hitam text-base">{{ $item->user->name ?? 'User Terhapus' }}</div>
                                            <div class="text-xs text-oranye font-semibold mt-0.5">Terdaftar: {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</div>
                                        </td>
                                        <td class="py-3 px-6 font-medium text-gray-700">{{ $item->nik ?? '-' }}</td>
                                        <td class="py-3 px-6">
                                            <div class="font-bold text-gray-700 flex items-center gap-1">
                                                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                                {{ $item->nomor_telepon ?? '-' }}
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                                {{ $item->user->email ?? '-' }}
                                            </div>
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('admin.peserta.edit', $item->id) }}"
                                                    class="bg-blue-50 text-blue-600 hover:bg-blue-500 hover:text-white border border-blue-200 px-3 py-1.5 rounded-md text-xs font-bold transition duration-300 flex items-center gap-1.5 shadow-sm">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                    Edit
                                                </a>
                                                
                                                <form action="{{ route('admin.peserta.reset_password', $item->id) }}" method="POST"
                                                    onsubmit="return confirm('Yakin ingin mereset password peserta ini menjadi 11111111?');"
                                                    class="inline-block">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit"
                                                        class="bg-yellow-50 text-yellow-600 hover:bg-yellow-500 hover:text-white border border-yellow-200 px-3 py-1.5 rounded-md text-xs font-bold transition duration-300 flex items-center gap-1.5 shadow-sm">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                                                        Reset
                                                    </button>
                                                </form>

                                                <form action="{{ route('admin.peserta.destroy', $item->id) }}" method="POST"
                                                    onsubmit="return confirm('Hapus peserta dan akunnya secara permanen?');" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="bg-red-50 text-red-600 hover:bg-red-500 hover:text-white border border-red-200 px-3 py-1.5 rounded-md text-xs font-bold transition duration-300 flex items-center gap-1.5 shadow-sm">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-12 px-6 text-center text-gray-400">
                                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                            <span class="block italic">Belum ada data peserta terdaftar.</span>
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