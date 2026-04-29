<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Laporan Data Peserta Pelatihan') }}</h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white p-6 shadow-lg sm:rounded-2xl border-t-4 border-oranye relative overflow-hidden">
                <div class="absolute -right-10 -top-10 opacity-5 pointer-events-none">
                    <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                </div>
                
                <h3 class="font-black text-hitam mb-4">Filter Laporan</h3>
                <form action="{{ route('admin.laporan.index') }}" method="GET" class="flex flex-col md:flex-row items-end gap-4 relative z-10">
                    <div class="w-full md:w-1/3">
                        <x-input-label for="kelas_id" :value="__('Berdasarkan Kelas')" class="font-bold text-gray-700" />
                        <select name="kelas_id" id="kelas_id" class="mt-1 block w-full rounded-xl border-gray-300 focus:border-oranye focus:ring-oranye shadow-sm text-sm font-medium">
                            <option value="">Semua Kelas</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full md:w-1/3">
                        <x-input-label for="status_kelulusan" :value="__('Status Kelulusan')" class="font-bold text-gray-700" />
                        <select name="status_kelulusan" id="status_kelulusan" class="mt-1 block w-full rounded-xl border-gray-300 focus:border-oranye focus:ring-oranye shadow-sm text-sm font-medium">
                            <option value="">Semua Status</option>
                            <option value="belum_dinilai" {{ request('status_kelulusan') == 'belum_dinilai' ? 'selected' : '' }}>Belum Dinilai</option>
                            <option value="lulus" {{ request('status_kelulusan') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                            <option value="tidak_lulus" {{ request('status_kelulusan') == 'tidak_lulus' ? 'selected' : '' }}>Tidak Lulus</option>
                        </select>
                    </div>
                    <div class="w-full md:w-1/3 flex gap-2">
                        <button type="submit" class="bg-hitam text-white px-4 py-2 rounded-xl shadow-md hover:bg-oranye hover:shadow-lg transition transform hover:-translate-y-0.5 w-full font-bold flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                            Filter Data
                        </button>
                        <a href="{{ route('admin.laporan.index') }}" class="bg-gray-100 text-gray-600 border border-gray-300 px-4 py-2 rounded-xl shadow-sm hover:bg-gray-200 transition text-center w-1/3 font-bold">Reset</a>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t border-gray-100">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4 border-b border-gray-100 pb-4">
                        <h3 class="font-black text-hitam text-lg">Hasil Pencarian <span class="text-oranye">({{ $laporan->count() }} Data)</span></h3>
                        
                        <div class="flex gap-2 w-full md:w-auto">
                            <a href="{{ route('admin.laporan.excel', ['kelas_id' => request('kelas_id'), 'status_kelulusan' => request('status_kelulusan')]) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-bold shadow-md transition transform hover:-translate-y-1 flex items-center justify-center gap-2 text-sm flex-1 md:flex-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Export Excel
                            </a>

                            <a href="{{ route('admin.laporan.cetak', ['kelas_id' => request('kelas_id'), 'status_kelulusan' => request('status_kelulusan')]) }}" target="_blank" class="bg-hitam hover:bg-gray-800 text-white px-4 py-2 rounded-lg font-bold shadow-md transition transform hover:-translate-y-1 flex items-center justify-center gap-2 text-sm flex-1 md:flex-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                Cetak PDF
                            </a>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full w-full text-left border-collapse border border-gray-200 rounded-xl overflow-hidden">
                            <thead>
                                <tr class="bg-gray-50 text-hitam uppercase text-[10px] sm:text-xs font-black tracking-wider">
                                    <th class="py-4 px-4 border-b border-gray-200 text-center w-10">No</th>
                                    <th class="py-4 px-4 border-b border-gray-200">Identitas Peserta</th>
                                    <th class="py-4 px-4 border-b border-gray-200">Kelas / Program</th>
                                    <th class="py-4 px-4 border-b border-gray-200 text-center">Hadir</th>
                                    <th class="py-4 px-4 border-b border-gray-200 text-center">Teori</th>
                                    <th class="py-4 px-4 border-b border-gray-200 text-center">Praktik</th>
                                    <th class="py-4 px-4 border-b border-gray-200 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm">
                                @forelse($laporan as $key => $item)
                                <tr class="hover:bg-orange-50/50 transition duration-150">
                                    <td class="py-3 px-4 border-b border-gray-100 text-center font-bold">{{ $key + 1 }}</td>
                                    
                                    <td class="py-3 px-4 border-b border-gray-100">
                                        <div class="font-bold text-hitam">{{ $item->peserta?->user?->name ?? 'Data Terhapus' }}</div>
                                        <div class="text-xs text-gray-500 font-medium">NIK: {{ $item->peserta?->nik ?? '-' }}</div>
                                    </td>
                                    
                                    <td class="py-3 px-4 border-b border-gray-100">
                                        <div class="text-oranye font-bold">{{ $item->kelas?->nama_kelas ?? 'Kelas Terhapus' }}</div>
                                        <div class="text-[10px] uppercase font-bold tracking-wider text-gray-500">{{ $item->kelas?->programPelatihan?->nama_program ?? 'Program Terhapus' }}</div>
                                    </td>
                                    
                                    <td class="py-3 px-4 border-b border-gray-100 text-center font-bold text-gray-700">{{ $item->kehadiran ?? 0 }}%</td>
                                    <td class="py-3 px-4 border-b border-gray-100 text-center font-bold text-gray-700">{{ $item->nilai_teori ?? '-' }}</td>
                                    <td class="py-3 px-4 border-b border-gray-100 text-center font-bold text-gray-700">{{ $item->nilai_praktik ?? '-' }}</td>
                                    
                                    <td class="py-3 px-4 border-b border-gray-100 text-center">
                                        @if($item->status_kelulusan == 'lulus')
                                            <span class="bg-green-100 text-green-700 border border-green-200 px-2 py-1 rounded text-[10px] font-black uppercase tracking-wider">Lulus</span>
                                        @elseif($item->status_kelulusan == 'tidak_lulus')
                                            <span class="bg-red-100 text-red-700 border border-red-200 px-2 py-1 rounded text-[10px] font-black uppercase tracking-wider">Gagal</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-600 border border-gray-200 px-2 py-1 rounded text-[10px] font-black uppercase tracking-wider">Proses</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="py-12 px-4 text-center">
                                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                        <p class="text-gray-400 font-medium">Tidak ada data laporan yang cocok dengan filter pencarian.</p>
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