<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Laporan Data Peserta Pelatihan') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white p-6 shadow-xl sm:rounded-lg border-t-4 border-oranye">
                <form action="{{ route('admin.laporan.index') }}" method="GET" class="flex flex-col md:flex-row items-end gap-4">
                    <div class="w-full md:w-1/3">
                        <x-input-label for="kelas_id" :value="__('Filter Berdasarkan Kelas')" class="font-bold text-hitam" />
                        <select name="kelas_id" id="kelas_id" class="mt-1 block w-full rounded-md border-gray-300 focus:border-oranye focus:ring-oranye shadow-sm">
                            <option value="">Semua Kelas</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full md:w-1/3">
                        <x-input-label for="status_kelulusan" :value="__('Status Kelulusan')" class="font-bold text-hitam" />
                        <select name="status_kelulusan" id="status_kelulusan" class="mt-1 block w-full rounded-md border-gray-300 focus:border-oranye focus:ring-oranye shadow-sm">
                            <option value="">Semua Status</option>
                            <option value="belum_dinilai" {{ request('status_kelulusan') == 'belum_dinilai' ? 'selected' : '' }}>Belum Dinilai</option>
                            <option value="lulus" {{ request('status_kelulusan') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                            <option value="tidak_lulus" {{ request('status_kelulusan') == 'tidak_lulus' ? 'selected' : '' }}>Tidak Lulus</option>
                        </select>
                    </div>
                    <div class="w-full md:w-1/3 flex gap-2">
                        <button type="submit" class="bg-hitam text-white px-4 py-2 rounded shadow hover:bg-gray-800 transition w-full font-bold">Filter Data</button>
                        <a href="{{ route('admin.laporan.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded shadow hover:bg-gray-300 transition text-center w-full font-bold">Reset</a>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-hitam">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-lg">Hasil Pencarian ({{ $laporan->count() }} Data)</h3>
                        <a href="{{ route('admin.laporan.cetak', ['kelas_id' => request('kelas_id'), 'status_kelulusan' => request('status_kelulusan')]) }}" target="_blank" class="bg-oranye hover:bg-[#c24b22] text-white px-6 py-2 rounded font-bold shadow transition transform hover:-translate-y-1 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Cetak Laporan PDF
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full w-full text-left border-collapse border border-gray-200">
                            <thead>
                                <tr class="bg-gray-100 text-hitam uppercase text-xs">
                                    <th class="py-3 px-4 border border-gray-200">No</th>
                                    <th class="py-3 px-4 border border-gray-200">Nama Peserta</th>
                                    <th class="py-3 px-4 border border-gray-200">NIK</th>
                                    <th class="py-3 px-4 border border-gray-200">Kelas / Program</th>
                                    <th class="py-3 px-4 border border-gray-200 text-center">Teori</th>
                                    <th class="py-3 px-4 border border-gray-200 text-center">Praktik</th>
                                    <th class="py-3 px-4 border border-gray-200 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 text-sm">
                                @forelse($laporan as $key => $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-2 px-4 border border-gray-200 text-center">{{ $key + 1 }}</td>
                                    <td class="py-2 px-4 border border-gray-200 font-bold">{{ $item->peserta->user->name }}</td>
                                    <td class="py-2 px-4 border border-gray-200">{{ $item->peserta->nik }}</td>
                                    <td class="py-2 px-4 border border-gray-200">
                                        <div class="text-oranye font-bold">{{ $item->kelas->nama_kelas }}</div>
                                        <div class="text-xs text-gray-500">{{ $item->kelas->programPelatihan->nama_program }}</div>
                                    </td>
                                    <td class="py-2 px-4 border border-gray-200 text-center">{{ $item->nilai_teori }}</td>
                                    <td class="py-2 px-4 border border-gray-200 text-center">{{ $item->nilai_praktik }}</td>
                                    <td class="py-2 px-4 border border-gray-200 text-center font-bold">
                                        @if($item->status_kelulusan == 'lulus')
                                            <span class="text-green-600 uppercase">Lulus</span>
                                        @elseif($item->status_kelulusan == 'tidak_lulus')
                                            <span class="text-red-600 uppercase">Tidak Lulus</span>
                                        @else
                                            <span class="text-yellow-600 uppercase">Belum Dinilai</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="py-6 px-4 text-center text-gray-400 italic border border-gray-200">Tidak ada data peserta yang cocok dengan filter pencarian.</td>
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