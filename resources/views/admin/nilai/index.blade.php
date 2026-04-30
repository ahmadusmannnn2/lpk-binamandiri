<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-hitam leading-tight">
                    {{ __('Rekapitulasi Nilai Peserta') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Pantau hasil evaluasi akhir dan status kelulusan peserta dari seluruh kelas.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-oranye">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center gap-2 mb-6 border-b border-gray-100 pb-4">
                        <svg class="w-6 h-6 text-oranye" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <h3 class="font-black text-lg text-hitam">Daftar Nilai Akhir Seluruh Kelas</h3>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-hitam uppercase text-xs font-black tracking-wider border-b-2 border-gray-200">
                                    <th class="py-4 px-6 rounded-tl-lg">Identitas Peserta</th>
                                    <th class="py-4 px-6">Program & Kelas</th>
                                    <th class="py-4 px-6">Instruktur Penguji</th>
                                    <th class="py-4 px-6 text-center">Nilai Rata-rata</th>
                                    <th class="py-4 px-6 text-center rounded-tr-lg">Keputusan Akhir</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-medium">
                                @forelse($pendaftaran as $item)
                                <tr class="border-b border-gray-100 hover:bg-orange-50/50 transition duration-150">
                                    <td class="py-4 px-6">
                                        <div class="font-black text-hitam text-base">{{ $item->peserta->user->name }}</div>
                                        <div class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mt-0.5">NIK: {{ $item->peserta->nik ?? '-' }}</div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="font-bold text-oranye">{{ $item->kelas->programPelatihan->nama_program }}</div>
                                        <div class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                            <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                            {{ $item->kelas->nama_kelas }}
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="bg-gray-100 text-gray-700 px-3 py-1.5 rounded-lg text-xs font-bold border border-gray-200">
                                            {{ $item->kelas->instruktur->user->name ?? 'Tidak ada data' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <div class="inline-flex items-center justify-center bg-blue-50 border border-blue-100 w-12 h-12 rounded-full shadow-sm">
                                            <span class="font-black text-blue-700 text-lg">{{ $item->nilai_rata_rata }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        @if($item->status_kelulusan == 'lulus')
                                            <span class="bg-green-100 text-green-800 py-1.5 px-4 rounded-full text-[10px] font-black shadow-sm uppercase tracking-widest border border-green-200">Lulus</span>
                                        @elseif($item->status_kelulusan == 'tidak_lulus')
                                            <span class="bg-red-100 text-red-800 py-1.5 px-4 rounded-full text-[10px] font-black shadow-sm uppercase tracking-widest border border-red-200">Gagal</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-500 py-1.5 px-4 rounded-full text-[10px] font-black shadow-sm uppercase tracking-widest border border-gray-200">Proses</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-12 px-6 text-center">
                                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4 border-2 border-dashed border-gray-300">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <p class="text-gray-500 font-bold text-lg">Belum ada peserta yang dinilai.</p>
                                        <p class="text-gray-400 text-sm mt-1">Data akan muncul otomatis setelah Instruktur menyimpan evaluasi akhir kelas.</p>
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