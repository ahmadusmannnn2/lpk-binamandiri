<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('instruktur.jadwal.show', $kelas->id) }}" class="text-gray-500 hover:text-oranye transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h2 class="font-black text-2xl text-hitam leading-tight">
                        Rekap Rapor Kelulusan
                    </h2>
                    <p class="text-sm text-gray-500 font-medium">Kelas: {{ $kelas->programPelatihan->nama_program }}</p>
                </div>
            </div>
            
            <form action="{{ route('instruktur.jadwal.kunci_rapor', $kelas->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengunci rapor? Nilai kelulusan akan disimpan permanen untuk sertifikat.');">
                @csrf
                <button type="submit" class="bg-hitam text-white px-5 py-2.5 rounded-xl hover:bg-oranye transition shadow-lg font-bold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Kunci Rapor Kelas
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- INFORMASI KELAS -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-8 flex flex-col md:flex-row gap-6 justify-between items-start md:items-center">
                <div>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-1">Informasi Kelas</span>
                    <h3 class="text-xl font-black text-hitam">{{ $kelas->programPelatihan->nama_program }}</h3>
                    <div class="flex items-center gap-4 mt-2">
                        <span class="text-sm text-gray-600 bg-gray-100 px-3 py-1 rounded-lg font-bold">{{ count($kelas->fase) }} Fase Belajar</span>
                        <span class="text-sm text-gray-600 bg-gray-100 px-3 py-1 rounded-lg font-bold">{{ count($pesertaKelas) }} Peserta</span>
                    </div>
                </div>
                <div class="bg-orange-50 border border-orange-100 p-4 rounded-xl max-w-sm">
                    <h4 class="font-bold text-oranye text-sm mb-1">Syarat Lulus Kelas</h4>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Peserta dinyatakan <strong>LULUS</strong> apabila nilai Rata-Rata Akhir dari seluruh fase yang diikutinya bernilai <strong>≥ 70</strong>. Pastikan semua fase telah dinilai sebelum mengunci rapor.
                    </p>
                </div>
            </div>

            <!-- TABEL REKAP RAPOR -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-hitam uppercase text-[10px] font-black tracking-wider border-b-2 border-gray-200">
                                <th class="py-4 px-6 whitespace-nowrap sticky left-0 bg-gray-50 z-20 shadow-[1px_0_0_0_#e5e7eb]">Identitas Peserta</th>
                                
                                @foreach($kelas->fase as $fase)
                                <th class="py-4 px-4 text-center min-w-[100px] border-l border-gray-200" title="{{ $fase->nama_fase }}">
                                    <div class="truncate w-24 mx-auto text-gray-600">{{ $fase->nama_fase }}</div>
                                </th>
                                @endforeach
                                
                                <th class="py-4 px-6 text-center bg-orange-50 text-oranye border-l border-gray-200 shadow-inner">Rata-Rata Akhir</th>
                                <th class="py-4 px-6 text-center bg-gray-800 text-white border-l border-gray-700 shadow-inner">Status Final</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($pesertaKelas as $peserta)
                            <tr class="hover:bg-orange-50/30 transition group {{ $peserta->status_sementara == 'Lulus' ? '' : 'bg-red-50/30' }}">
                                <td class="py-4 px-6 sticky left-0 bg-white group-hover:bg-orange-50/30 shadow-[1px_0_0_0_#f3f4f6] z-10">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-orange-100 text-oranye flex items-center justify-center font-black text-sm shrink-0 border-2 border-white shadow-sm">
                                            {{ substr($peserta->peserta->user->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-hitam">{{ $peserta->peserta->user->name }}</p>
                                            <p class="text-[11px] text-gray-500 font-bold font-mono mt-0.5">ID: {{ $peserta->peserta->id }}</p>
                                        </div>
                                    </div>
                                </td>
                                
                                @foreach($kelas->fase as $fase)
                                <td class="py-4 px-4 text-center border-l border-gray-100">
                                    @php
                                        $skorFase = $peserta->detail_fase[$fase->id] ?? 0;
                                    @endphp
                                    <span class="font-bold text-sm {{ $skorFase >= 70 ? 'text-green-600' : ($skorFase > 0 ? 'text-red-500' : 'text-gray-300') }}">
                                        {{ $skorFase > 0 ? $skorFase : '-' }}
                                    </span>
                                </td>
                                @endforeach
                                
                                <td class="py-4 px-6 text-center border-l border-gray-100 bg-orange-50/50">
                                    <span class="text-lg font-black {{ $peserta->rata_rata_akhir >= 70 ? 'text-oranye' : 'text-red-500' }}">
                                        {{ $peserta->rata_rata_akhir }}
                                    </span>
                                </td>
                                
                                <td class="py-4 px-6 text-center border-l border-gray-100">
                                    @if($peserta->rata_rata_akhir >= 70)
                                        <span class="bg-green-100 text-green-700 px-3 py-1.5 rounded-lg text-xs font-black tracking-wide border border-green-200">
                                            LULUS
                                        </span>
                                    @else
                                        <span class="bg-red-100 text-red-600 px-3 py-1.5 rounded-lg text-xs font-black tracking-wide border border-red-200">
                                            TIDAK LULUS
                                        </span>
                                    @endif
                                    
                                    @if($peserta->status_kelulusan != 'menunggu' && $peserta->status_kelulusan != 'belum_dinilai')
                                        <p class="text-[9px] text-gray-400 mt-2 font-bold flex items-center justify-center gap-1">
                                            <svg class="w-3 h-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            SUDAH DIKUNCI
                                        </p>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ count($kelas->fase) + 3 }}" class="py-12 text-center text-gray-400 font-bold">
                                    Belum ada peserta di kelas ini.
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
