<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Rekapitulasi Nilai Peserta') }}</h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-hitam">
                <div class="p-6">
                    <h3 class="font-black text-lg text-hitam mb-4">Daftar Nilai Akhir Seluruh Kelas</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-hitam uppercase text-xs font-black tracking-wider border-b-2 border-gray-200">
                                    <th class="py-4 px-6">Identitas Peserta</th>
                                    <th class="py-4 px-6">Program & Kelas</th>
                                    <th class="py-4 px-6">Instruktur</th>
                                    <th class="py-4 px-6 text-center">Rata-rata</th>
                                    <th class="py-4 px-6 text-center">Keputusan</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm">
                                @forelse($pendaftaran as $item)
                                <tr class="border-b border-gray-100 hover:bg-orange-50/30 transition duration-200">
                                    <td class="py-4 px-6 font-bold text-hitam">{{ $item->peserta->user->name }}</td>
                                    <td class="py-4 px-6">
                                        <div class="font-bold text-oranye">{{ $item->kelas->programPelatihan->nama_program }}</div>
                                        <div class="text-xs text-gray-500">{{ $item->kelas->nama_kelas }}</div>
                                    </td>
                                    <td class="py-4 px-6 font-medium">{{ $item->kelas->instruktur->user->name ?? '-' }}</td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="font-black text-blue-700 text-lg">{{ $item->nilai_rata_rata }}</span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        @if($item->status_kelulusan == 'lulus')
                                            <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-[10px] font-bold shadow-sm uppercase tracking-wider">LULUS</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-[10px] font-bold shadow-sm uppercase tracking-wider">GAGAL</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-gray-400 italic">Belum ada peserta yang dinilai oleh instruktur.</td>
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