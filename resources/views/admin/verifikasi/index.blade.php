<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">
            {{ __('Verifikasi Pendaftaran & Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
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

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-hitam">
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-hitam uppercase text-xs font-black tracking-wider border-b-2 border-gray-200">
                                <th class="py-4 px-6 rounded-tl-lg">Tgl Daftar</th>
                                <th class="py-4 px-6">Identitas Peserta</th>
                                <th class="py-4 px-6">Program & Kelas</th>
                                <th class="py-4 px-6 text-center">Status</th>
                                <th class="py-4 px-6 text-center rounded-tr-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm">
                            @forelse($pendaftaran as $item)
                            <tr class="border-b border-gray-100 hover:bg-orange-50/30 transition duration-200">
                                <td class="py-4 px-6 font-medium">
                                    {{ \Carbon\Carbon::parse($item->tanggal_daftar)->format('d M Y') }}
                                    <div class="text-[10px] text-gray-400">{{ \Carbon\Carbon::parse($item->tanggal_daftar)->format('H:i') }} WIB</div>
                                </td>
                                
                                <td class="py-4 px-6">
                                    <div class="font-bold text-hitam text-base">{{ $item->peserta->user->name ?? 'Akun Terhapus' }}</div>
                                    <div class="font-medium text-xs text-gray-500 mt-1">
                                        NIK: <span class="font-bold text-gray-700">{{ $item->peserta->nik ?? 'Belum Diisi' }}</span>
                                    </div>
                                </td>
                                
                                <td class="py-4 px-6">
                                    <div class="font-bold text-oranye">{{ $item->kelas->nama_kelas ?? 'Kelas Telah Dihapus' }}</div>
                                    <div class="text-xs text-gray-500 font-bold mt-1 uppercase tracking-wider">
                                        {{ $item->kelas->programPelatihan->nama_program ?? 'Program Dihapus' }}
                                    </div>
                                </td>
                                
                                <td class="py-4 px-6 text-center">
                                    @if($item->status_pendaftaran == 'menunggu_verifikasi')
                                        <span class="inline-flex items-center gap-1 bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-[10px] font-bold shadow-sm uppercase tracking-wider border border-yellow-200">
                                            <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full animate-ping"></span>
                                            Menunggu
                                        </span>
                                    @elseif($item->status_pendaftaran == 'disetujui')
                                        <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-[10px] font-bold shadow-sm uppercase tracking-wider border border-green-200">Disetujui</span>
                                    @else
                                        <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-[10px] font-bold shadow-sm uppercase tracking-wider border border-red-200">Ditolak</span>
                                    @endif
                                </td>
                                
                                <td class="py-4 px-6 text-center">
                                    <a href="{{ route('admin.verifikasi.show', $item->id) }}" class="inline-flex items-center gap-1 bg-hitam text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-oranye transition shadow hover:shadow-md hover:-translate-y-0.5 transform">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                        Proses Berkas
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-gray-400">
                                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <span class="block italic font-medium">Belum ada data pendaftaran yang masuk.</span>
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