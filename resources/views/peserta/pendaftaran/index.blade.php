<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Pendaftaran Pelatihan') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm"><p class="font-bold">Berhasil</p><p>{{ session('success') }}</p></div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm"><p class="font-bold">Perhatian</p><p>{{ session('error') }}</p></div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-oranye">
                <div class="p-6">
                    <h3 class="font-bold text-lg mb-4 text-hitam border-b pb-2">Kelas yang Tersedia</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($kelasTersedia as $kelas)
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-5 shadow-sm hover:shadow-md transition">
                                <h4 class="font-bold text-lg text-oranye">{{ $kelas->nama_kelas }}</h4>
                                <p class="text-sm font-semibold text-hitam">{{ $kelas->programPelatihan->nama_program }}</p>
                                <div class="mt-4 text-sm text-gray-600 space-y-1">
                                    <p><strong>Instruktur:</strong> {{ $kelas->instruktur->user->name }}</p>
                                    <p><strong>Kuota:</strong> {{ $kelas->kuota_peserta }} Orang</p>
                                    <p><strong>Harga:</strong> Rp {{ number_format($kelas->programPelatihan->harga_pelatihan, 0, ',', '.') }}</p>
                                    <p><strong>Jadwal:</strong> {{ \Carbon\Carbon::parse($kelas->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($kelas->tanggal_selesai)->format('d M Y') }}</p>
                                </div>
                                <div class="mt-6">
                                    <a href="{{ route('peserta.pendaftaran.create', $kelas->id) }}" class="block text-center bg-hitam text-white px-4 py-2 rounded hover:bg-oranye transition w-full">Daftar Sekarang</a>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 text-center text-gray-500 py-4">Belum ada kelas baru yang dibuka.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-hitam">
                <div class="p-6">
                    <h3 class="font-bold text-lg mb-4 text-hitam border-b pb-2">Riwayat Pendaftaran Anda</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100 text-hitam uppercase text-sm">
                                    <th class="py-3 px-6">Tanggal Daftar</th>
                                    <th class="py-3 px-6">Kelas & Program</th>
                                    <th class="py-3 px-6 text-center">Status</th>
                                    <th class="py-3 px-6">Catatan Admin</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm">
                                @forelse($riwayatDaftar as $riwayat)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 px-6">{{ \Carbon\Carbon::parse($riwayat->tanggal_daftar)->format('d M Y') }}</td>
                                    <td class="py-3 px-6 font-bold">{{ $riwayat->kelas->nama_kelas }}<br><span class="text-xs font-normal text-oranye">{{ $riwayat->kelas->programPelatihan->nama_program }}</span></td>
                                    <td class="py-3 px-6 text-center">
                                        @if($riwayat->status_pendaftaran == 'menunggu_verifikasi')
                                            <span class="bg-yellow-200 text-yellow-800 py-1 px-3 rounded-full text-xs font-bold">Menunggu Verifikasi</span>
                                        @elseif($riwayat->status_pendaftaran == 'disetujui')
                                            <span class="bg-green-200 text-green-800 py-1 px-3 rounded-full text-xs font-bold">Disetujui</span>
                                        @else
                                            <span class="bg-red-200 text-red-800 py-1 px-3 rounded-full text-xs font-bold">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-6 text-xs text-red-500">{{ $riwayat->keterangan_admin ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="py-6 text-center text-gray-400">Anda belum mendaftar di kelas manapun.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>