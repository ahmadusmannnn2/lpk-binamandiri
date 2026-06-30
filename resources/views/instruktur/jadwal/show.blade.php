<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Kelola Kelas & Evaluasi Akhir') }}</h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <p class="font-bold text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-hitam text-white rounded-t-xl p-8 flex flex-col md:flex-row justify-between items-start md:items-center border-b-4 border-oranye shadow-xl relative overflow-hidden">
                <div class="absolute -right-10 -top-10 opacity-10">
                    <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zm0 7l-10 5 10 5 10-5-10-5zm0 7l-10 5 10 5 10-5-10-5z"></path></svg>
                </div>
                <div class="relative z-10">
                    <h3 class="text-3xl font-black mb-1">{{ $kelas->nama_kelas }}</h3>
                    <p class="text-oranye font-bold tracking-widest uppercase text-sm mb-4">{{ $kelas->programPelatihan->nama_program }}</p>
                    <div class="flex items-center gap-4 text-xs text-gray-300 font-medium">
                        <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> {{ \Carbon\Carbon::parse($kelas->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($kelas->tanggal_selesai)->format('d M Y') }}</span>
                        <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg> {{ $pesertaKelas->count() }} Peserta</span>
                    </div>
                </div>
                <div class="relative z-10 mt-6 md:mt-0 flex flex-col items-start md:items-end gap-3 w-full md:w-auto">
                    @if($kelas->status_kelas == 'berjalan')
                        <span class="bg-green-500/20 text-green-400 border border-green-500/30 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider animate-pulse">Sedang Berjalan</span>
                    @else
                        <span class="bg-gray-500/20 text-gray-400 border border-gray-500/30 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">{{ $kelas->status_kelas }}</span>
                    @endif
                    <a href="{{ route('instruktur.jadwal.cetak', $kelas->id) }}" target="_blank" class="bg-oranye hover:bg-[#c24b22] text-white px-5 py-2.5 rounded-lg shadow-lg transition transform hover:-translate-y-1 flex items-center justify-center gap-2 font-bold text-sm w-full md:w-auto">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Cetak Laporan Kelas
                    </a>
                </div>
            </div>

            <div id="penilaian" class="bg-white overflow-hidden shadow-xl rounded-b-xl border border-gray-100 scroll-mt-24">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-4 gap-4">
                        <h3 class="text-lg font-black text-hitam border-b-2 border-oranye pb-1 inline-block">Buku Penilaian & Evaluasi</h3>
                        <p class="text-xs text-gray-500 bg-blue-50 text-blue-800 px-3 py-1.5 rounded-lg border border-blue-200">
                            ℹ️ Keputusan Lulus/Gagal akan ditentukan otomatis oleh sistem jika Rata-rata <strong>≥ 70</strong>.
                        </p>
                    </div>

                    @php
                        $parameters = $kelas->programPelatihan->parameter_penilaian ?? [];
                    @endphp

                    <form action="{{ route('instruktur.jadwal.simpan_nilai', $kelas->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="overflow-x-auto rounded-xl border border-gray-200 pb-16">
                            <table class="min-w-full w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 text-hitam uppercase text-[10px] sm:text-xs font-black tracking-wider border-b-2 border-gray-200">
                                        <th class="py-3 px-6 whitespace-nowrap sticky left-0 bg-gray-50 z-20 shadow-[1px_0_0_0_#e5e7eb]">Identitas Peserta</th>
                                        <th class="py-3 px-4 text-center">Hadir (%)</th>
                                        
                                        @if(empty($parameters))
                                            <th class="py-3 px-4 text-center text-red-500">Kriteria Belum Diatur</th>
                                        @else
                                            @foreach($parameters as $param)
                                                <th class="py-3 px-4 text-center text-oranye">{{ $param }}</th>
                                            @endforeach
                                        @endif
                                        
                                        <th class="py-3 px-4 text-center bg-blue-50 text-blue-800">Rata-rata</th>
                                        <th class="py-3 px-4 text-center text-hitam">Catatan Akhir</th>
                                        <th class="py-3 px-4 text-center bg-gray-50 text-gray-600">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm">
                                    @forelse($pesertaKelas as $pendaftaran)
                                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition duration-150">
                                        <td class="py-3 px-6 sticky left-0 bg-white group-hover:bg-gray-50 z-10 shadow-[1px_0_0_0_#f3f4f6]">
                                            <div class="font-bold text-hitam text-sm md:text-base whitespace-nowrap">{{ $pendaftaran->peserta->user->name }}</div>
                                        </td>
                                        
                                        <td class="py-3 px-4 text-center align-top pt-5">
                                            <span class="inline-block w-12 text-center rounded text-sm font-bold {{ $pendaftaran->kehadiran >= 80 ? 'text-green-600' : 'text-red-500' }}">{{ $pendaftaran->kehadiran }}%</span>
                                        </td>
                                        
                                        @if(empty($parameters))
                                            <td class="py-3 px-4 text-center text-xs text-gray-400 italic">Harap hubungi Admin</td>
                                        @else
                                            @foreach($parameters as $param)
                                                @php
                                                    $oldData = $pendaftaran->detail_nilai[$param] ?? null;
                                                    $skor = is_array($oldData) ? ($oldData['skor'] ?? '') : (is_numeric($oldData) ? $oldData : '');
                                                    $catatan = is_array($oldData) ? ($oldData['catatan'] ?? '') : '';
                                                    $hasCatatan = !empty($catatan) ? 'true' : 'false';
                                                @endphp
                                                <td class="py-3 px-4 text-center align-top pt-4" x-data="{ openNote: {{ $hasCatatan }} }">
                                                    <div class="flex flex-col items-center gap-1 w-24 mx-auto">
                                                        <div class="flex items-center gap-1 w-full justify-center">
                                                            <input type="number" name="nilai[{{ $pendaftaran->id }}][detail][{{ $param }}][skor]" 
                                                                   value="{{ $skor }}" min="0" max="100" placeholder="Skor"
                                                                   class="w-16 text-center rounded-md border-gray-300 focus:border-oranye focus:ring-oranye text-sm font-bold placeholder-gray-300">
                                                            
                                                            <button type="button" @click="openNote = !openNote" 
                                                                    class="p-1.5 rounded-md transition duration-200"
                                                                    :class="openNote ? 'bg-oranye text-white' : 'bg-gray-100 text-gray-500 hover:bg-orange-50 hover:text-oranye'"
                                                                    title="Tambah/Edit Catatan Kriteria">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                            </button>
                                                        </div>
                                                        
                                                        <div x-show="openNote" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="w-full mt-1">
                                                            <input type="text" name="nilai[{{ $pendaftaran->id }}][detail][{{ $param }}][catatan]" 
                                                                   value="{{ $catatan }}" placeholder="Tulis Catatan..."
                                                                   class="w-full text-[10px] rounded border-gray-300 focus:border-oranye focus:ring-oranye placeholder-gray-300 px-2 py-1 bg-yellow-50">
                                                        </div>
                                                    </div>
                                                </td>
                                            @endforeach
                                        @endif
                                        
                                        <td class="py-3 px-4 text-center bg-blue-50/30 align-top pt-5">
                                            <span class="font-black text-blue-700 text-lg">{{ $pendaftaran->nilai_rata_rata ?? 0 }}</span>
                                        </td>
                                        
                                        @php
                                            $catatanAkhir = $pendaftaran->detail_nilai['catatan_instruktur_final'] ?? '';
                                            $hasCatatanAkhir = !empty($catatanAkhir) ? 'true' : 'false';
                                        @endphp
                                        <td class="py-3 px-4 text-center align-top pt-4" x-data="{ openFinal: {{ $hasCatatanAkhir }} }">
                                            <button type="button" x-show="!openFinal" @click="openFinal = true" class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-600 px-3 py-2 rounded-md font-bold transition flex items-center gap-1 mx-auto whitespace-nowrap">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg> Kesimpulan
                                            </button>
                                            
                                            <div x-show="openFinal" x-transition style="display: none;" class="relative">
                                                <textarea name="nilai[{{ $pendaftaran->id }}][catatan_akhir]" rows="2" 
                                                          placeholder="Catatan umum..."
                                                          class="w-48 rounded-md border-gray-300 focus:border-oranye focus:ring-oranye text-[10px] font-medium placeholder-gray-300 p-2 bg-yellow-50">{{ $catatanAkhir }}</textarea>
                                                
                                                <button type="button" @click="openFinal = false" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-0.5 shadow-sm hover:bg-red-600" title="Tutup">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </div>
                                        </td>

                                        <td class="py-3 px-4 text-center bg-gray-50/50 align-top pt-5">
                                            @if($pendaftaran->status_kelulusan == 'lulus')
                                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-[10px] font-black uppercase shadow-sm">LULUS</span>
                                            @elseif($pendaftaran->status_kelulusan == 'tidak_lulus')
                                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-[10px] font-black uppercase shadow-sm">GAGAL</span>
                                            @else
                                                <span class="text-gray-400 text-xs italic">Belum Dinilai</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="10" class="py-10 text-center text-gray-400">
                                            <span class="block italic">Belum ada peserta yang disetujui di kelas ini.</span>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if(count($pesertaKelas) > 0 && !empty($parameters))
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="bg-hitam hover:bg-gray-800 text-white px-8 py-3 rounded-xl shadow-lg font-bold transition transform hover:-translate-y-1 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Hitung & Simpan Evaluasi Akhir
                            </button>
                        </div>
                        @endif
                    </form>
                </div>
            </div>

            <!-- ... BAGIAN JADWAL PERTEMUAN (Tidak ada yang diubah) ... -->
            <div id="absensi" class="mt-10 bg-white overflow-hidden shadow-xl rounded-xl border border-gray-100 scroll-mt-24">
                <div class="p-6 sm:p-8">
                    <h3 class="text-xl font-black text-hitam mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-oranye" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Manajemen Jadwal Pertemuan Harian
                    </h3>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="lg:col-span-1 bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-inner h-fit">
                            <h4 class="font-black text-hitam border-b border-gray-200 pb-2 mb-4">Buat Jadwal Baru</h4>
                            
                            <form action="{{ route('instruktur.pertemuan.store', $kelas->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <div>
                                    <x-input-label for="judul_pertemuan" value="Topik Pertemuan" class="font-bold text-gray-700" />
                                    <x-text-input id="judul_pertemuan" class="block mt-1 w-full text-sm focus:border-oranye focus:ring-oranye" type="text" name="judul_pertemuan" placeholder="Misal: Pertemuan 1 - Teori Las" required />
                                </div>
                                <div>
                                    <x-input-label for="tanggal" value="Tanggal Kelas" class="font-bold text-gray-700" />
                                    <x-text-input id="tanggal" class="block mt-1 w-full text-sm focus:border-oranye focus:ring-oranye" type="date" name="tanggal" required />
                                </div>
                                <div class="bg-white p-3 rounded-lg border border-dashed border-gray-300 hover:border-oranye transition relative mt-2">
                                    <x-input-label for="file_materi" value="Upload Materi / Modul (Opsional)" class="font-bold text-gray-700 text-xs mb-2 text-center block" />
                                    <input id="file_materi" type="file" name="file_materi" accept=".pdf,.doc,.docx,.ppt,.pptx,.zip,.rar" class="block w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-oranye/10 file:text-oranye hover:file:bg-oranye hover:file:text-white cursor-pointer" />
                                </div>
                                <button type="submit" class="w-full mt-4 bg-hitam text-white py-3 rounded-lg shadow hover:bg-oranye font-bold transition flex justify-center items-center gap-2">
                                    Tambah Jadwal
                                </button>
                            </form>
                        </div>

                        <div class="lg:col-span-2 space-y-4">
                            @forelse($kelas->pertemuan as $index => $pertemuan)
                                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition duration-300 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 group">
                                    <div class="flex items-start gap-4">
                                        <div class="bg-orange-50 text-oranye font-black text-xl w-12 h-12 flex items-center justify-center rounded-lg border border-orange-200 shrink-0">
                                            #{{ $index + 1 }}
                                        </div>
                                        <div>
                                            <h5 class="font-black text-hitam text-lg group-hover:text-oranye transition">{{ $pertemuan->judul_pertemuan }}</h5>
                                            <p class="text-sm text-gray-500 font-medium flex items-center gap-1 mt-0.5">
                                                {{ \Carbon\Carbon::parse($pertemuan->tanggal)->translatedFormat('l, d F Y') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 w-full sm:w-auto">
                                        <a href="{{ route('instruktur.pertemuan.show', $pertemuan->id) }}" class="flex-1 sm:flex-none text-center bg-hitam text-white text-xs px-4 py-2.5 rounded-lg shadow hover:bg-oranye font-bold transition">
                                            Isi Presensi
                                        </a>
                                        <form action="{{ route('instruktur.pertemuan.destroy', $pertemuan->id) }}" method="POST" onsubmit="return confirm('Hapus pertemuan ini?');" class="flex-none">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="bg-red-50 text-red-500 hover:bg-red-500 hover:text-white p-2.5 rounded-lg font-bold border border-red-200 transition">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-16 bg-gray-50 border-2 border-dashed border-gray-300 rounded-xl">
                                    <p class="text-gray-500 font-bold">Jadwal Kelas Belum Dibuat</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>