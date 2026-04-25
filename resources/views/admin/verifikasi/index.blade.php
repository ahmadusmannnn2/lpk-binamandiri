<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Verifikasi Pendaftaran & Pembayaran') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm"><p class="font-bold">Berhasil</p><p>{{ session('success') }}</p></div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-hitam">
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-hitam uppercase text-sm">
                                <th class="py-3 px-6">Tgl Daftar</th>
                                <th class="py-3 px-6">Peserta</th>
                                <th class="py-3 px-6">Kelas & Program</th>
                                <th class="py-3 px-6 text-center">Status</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm">
                            @forelse($pendaftaran as $item)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-6">{{ \Carbon\Carbon::parse($item->tanggal_daftar)->format('d M Y') }}</td>
                                <td class="py-3 px-6 font-bold text-hitam">
                                    {{ $item->peserta->user->name ?? 'Terhapus' }}
                                    <div class="font-normal text-xs text-gray-500">NIK: {{ $item->peserta->nik ?? '-' }}</div>
                                </td>
                                <td class="py-3 px-6">
                                    <span class="font-bold text-oranye">{{ $item->kelas->nama_kelas }}</span>
                                    <div class="text-xs">{{ $item->kelas->programPelatihan->nama_program }}</div>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    @if($item->status_pendaftaran == 'menunggu_verifikasi')
                                        <span class="bg-yellow-200 text-yellow-800 py-1 px-3 rounded-full text-xs font-bold animate-pulse">Menunggu</span>
                                    @elseif($item->status_pendaftaran == 'disetujui')
                                        <span class="bg-green-200 text-green-800 py-1 px-3 rounded-full text-xs font-bold">Disetujui</span>
                                    @else
                                        <span class="bg-red-200 text-red-800 py-1 px-3 rounded-full text-xs font-bold">Ditolak</span>
                                    @endif
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <a href="{{ route('admin.verifikasi.show', $item->id) }}" class="inline-block bg-hitam text-white px-4 py-1 rounded text-xs hover:bg-oranye transition shadow">
                                        Proses / Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="py-6 text-center text-gray-400">Belum ada data pendaftaran masuk.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>