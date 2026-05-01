<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">
            {{ __('Verifikasi Biodata & Berkas Peserta') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm">
                    <p class="text-sm text-green-700 font-bold">{{ session('success') }}</p>
                </div>
            @endif

            <!-- TABEL MENUNGGU VERIFIKASI BIODATA -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-oranye mb-10">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-black text-hitam mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-oranye" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Antrean Cek Berkas ({{ $pesertaMenunggu->count() ?? 0 }})
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100 text-gray-600 text-sm uppercase tracking-wider">
                                    <th class="p-4 font-bold rounded-tl-lg">Nama Peserta</th>
                                    <th class="p-4 font-bold">NIK</th>
                                    <th class="p-4 font-bold">Tgl Submit</th>
                                    <th class="p-4 font-bold">Status</th>
                                    <th class="p-4 font-bold text-center rounded-tr-lg">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($pesertaMenunggu as $p)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="p-4">
                                            <p class="font-bold text-hitam">{{ $p->user->name ?? '-' }}</p>
                                            <p class="text-xs text-gray-500">{{ $p->user->email ?? '-' }}</p>
                                        </td>
                                        <td class="p-4 font-medium text-gray-700">{{ $p->nik ?? '-' }}</td>
                                        <td class="p-4 text-sm text-gray-600">{{ $p->updated_at->format('d M Y, H:i') }}</td>
                                        <td class="p-4">
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-3 py-1 rounded-full">Menunggu</span>
                                        </td>
                                        <td class="p-4 text-center">
                                            <a href="{{ route('admin.verifikasi.show', $p->id) }}" class="inline-flex items-center gap-1 bg-hitam text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-oranye transition">
                                                Cek Berkas
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="p-8 text-center text-gray-400 font-medium">Tidak ada antrean verifikasi biodata saat ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TABEL RIWAYAT KEPUTUSAN ADMIN -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-700 mb-4">Riwayat Keputusan Berkas</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-sm">
                            <thead>
                                <tr class="bg-gray-50 text-gray-500 uppercase tracking-wider">
                                    <th class="p-3 font-bold">Nama Peserta</th>
                                    <th class="p-3 font-bold">NIK</th>
                                    <th class="p-3 font-bold">Status</th>
                                    <th class="p-3 font-bold text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($pesertaRiwayat as $p)
                                    <tr>
                                        <td class="p-3 font-medium text-hitam">{{ $p->user->name ?? '-' }}</td>
                                        <td class="p-3 text-gray-600">{{ $p->nik ?? '-' }}</td>
                                        <td class="p-3">
                                            @if($p->status_biodata == 'disetujui')
                                                <span class="text-green-600 font-bold">Disetujui</span>
                                            @else
                                                <span class="text-red-600 font-bold">Ditolak</span>
                                            @endif
                                        </td>
                                        <td class="p-3 text-center">
                                            <a href="{{ route('admin.verifikasi.show', $p->id) }}" class="text-oranye hover:underline font-bold">Lihat Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-6 text-center text-gray-400">Belum ada riwayat verifikasi.</td>
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