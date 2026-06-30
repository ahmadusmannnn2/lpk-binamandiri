<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Ruang Belajar Saya') }}</h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(!$peserta || !$peserta->nik || !$peserta->pas_foto)
            <div class="bg-red-50 border-l-4 border-red-500 p-5 rounded-r-2xl shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex items-start gap-4">
                    <div class="bg-red-100 p-2 rounded-full shrink-0">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <p class="font-bold text-red-800 text-lg">Perhatian: Biodata Belum Lengkap!</p>
                        <p class="text-sm text-red-700 mt-1">Anda tidak bisa mendaftar kelas sebelum melengkapi informasi pribadi, NIK, dan mengunggah Pas Foto.</p>
                    </div>
                </div>
                <a href="{{ route('peserta.biodata.index') }}" class="bg-red-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-md hover:bg-red-700 transition w-full sm:w-auto text-center whitespace-nowrap">Lengkapi Sekarang</a>
            </div>
            @endif

            <div class="bg-hitam text-white rounded-3xl p-8 md:p-10 shadow-xl border-b-4 border-oranye flex items-center justify-between relative overflow-hidden">
                <div class="absolute -right-10 -top-10 opacity-10">
                    <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"></path><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                </div>
                <div class="relative z-10">
                    <h3 class="text-3xl md:text-4xl font-black mb-2 tracking-tight">Semangat Belajar, <span class="text-oranye">{{ Auth::user()->name }}!</span> 🚀</h3>
                    <p class="text-gray-300 max-w-xl text-sm md:text-base">Konsistensi adalah kunci menjadi ahli. Mari pantau kehadiran harian Anda dan perhatikan evaluasi akhir dari instruktur.</p>
                </div>
            </div>

            @if($kelasAktif)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-6">
                    
                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-white p-6 md:p-8 rounded-2xl shadow-lg border border-gray-100 relative">
                            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-oranye to-[#c24b22] rounded-t-2xl"></div>
                            
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 mt-2">Kelas Aktif Saat Ini</p>
                            <h4 class="font-black text-2xl text-hitam leading-tight">{{ $kelasAktif->kelas?->nama_kelas ?? 'Kelas Tidak Ditemukan' }}</h4>
                            <p class="text-sm text-oranye font-bold mb-6">{{ $kelasAktif->kelas?->programPelatihan?->nama_program ?? 'Program Dihapus' }}</p>
                            
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 mb-6">
                                <div class="flex items-center gap-3 mb-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    <span class="font-medium">Instruktur: <span class="font-bold text-hitam">{{ $kelasAktif->kelas?->instruktur?->user?->name ?? 'Belum Ada' }}</span></span>
                                </div>
                                <div class="flex items-center gap-3 text-sm text-gray-600">
                                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="font-medium">Periode: <span class="font-bold text-hitam">{{ \Carbon\Carbon::parse($kelasAktif->kelas?->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($kelasAktif->kelas?->tanggal_selesai)->format('d M Y') }}</span></span>
                                </div>
                            </div>
                            
                            <div class="bg-blue-50 rounded-xl p-5 border border-blue-200 mt-4">
                                <p class="text-[10px] font-black text-blue-800 uppercase tracking-widest border-b border-blue-200 pb-2 mb-4 flex items-center justify-between">
                                    Rapor Evaluasi Akhir
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </p>
                                
                                <div class="space-y-4">
                                    <div>
                                        <div class="flex justify-between text-xs font-bold mb-1">
                                            <span class="text-blue-900">Total Kehadiran</span>
                                            <span class="{{ $kelasAktif->kehadiran >= 80 ? 'text-green-600' : 'text-red-600' }}">{{ $kelasAktif->kehadiran ?? 0 }}%</span>
                                        </div>
                                        <div class="w-full bg-blue-200 rounded-full h-2">
                                            <div class="{{ $kelasAktif->kehadiran >= 80 ? 'bg-green-500' : 'bg-red-500' }} h-full rounded-full transition-all duration-1000" style="width: {{ $kelasAktif->kehadiran ?? 0 }}%"></div>
                                        </div>
                                    </div>

                                    @php
                                        $parameters = $kelasAktif->kelas?->programPelatihan?->parameter_penilaian ?? [];
                                        $detailNilai = $kelasAktif->detail_nilai ?? [];
                                        $catatanAkhir = $detailNilai['catatan_instruktur_final'] ?? '';
                                    @endphp

                                    <div class="space-y-2 border-t border-blue-200 pt-3">
                                        @if(empty($parameters))
                                            <p class="text-xs text-gray-500 italic text-center">Kriteria penilaian belum diatur.</p>
                                        @else
                                            @foreach($parameters as $param)
                                                @php
                                                    $kriteriaData = $detailNilai[$param] ?? null;
                                                    $skor = is_array($kriteriaData) ? ($kriteriaData['skor'] ?? '-') : (is_numeric($kriteriaData) ? $kriteriaData : '-');
                                                    $catatan = is_array($kriteriaData) ? ($kriteriaData['catatan'] ?? '') : '';
                                                @endphp
                                                <div class="bg-white p-3 rounded-lg border border-blue-100 shadow-sm">
                                                    <div class="flex justify-between items-center text-sm">
                                                        <span class="font-bold text-gray-700">{{ $param }}</span>
                                                        <span class="font-black text-hitam bg-gray-100 px-2 py-0.5 rounded">{{ $skor }}</span>
                                                    </div>
                                                    @if(!empty($catatan))
                                                        <div class="mt-2 text-xs text-gray-600 bg-yellow-50 p-2 rounded border border-yellow-100 flex items-start gap-1.5">
                                                            <svg class="w-3.5 h-3.5 text-yellow-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                            <span class="italic leading-tight">"{{ $catatan }}"</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>

                                    <div class="flex justify-between items-center text-sm mt-3 pt-3 border-t border-blue-200">
                                        <span class="font-black text-blue-900 uppercase tracking-wider text-[10px]">Nilai Rata-rata</span>
                                        <span class="font-black text-blue-700 text-lg">{{ $kelasAktif->nilai_rata_rata ?? 0 }}</span>
                                    </div>

                                    @if(!empty($catatanAkhir))
                                        <div class="bg-blue-100 p-3 rounded-lg border border-blue-200">
                                            <span class="text-[10px] font-bold text-blue-800 uppercase block mb-1">Catatan Kesimpulan:</span>
                                            <p class="text-xs text-blue-900 font-medium leading-relaxed">"{{ $catatanAkhir }}"</p>
                                        </div>
                                    @endif

                                    <div class="pt-3 border-t border-blue-200 flex justify-between items-center">
                                        <span class="font-bold text-blue-900 text-xs">Status Kelulusan</span>
                                        @if($kelasAktif->status_kelulusan == 'lulus')
                                            <span class="bg-green-500 text-white px-3 py-1 rounded text-xs font-black uppercase tracking-wider shadow-sm">LULUS</span>
                                        @elseif($kelasAktif->status_kelulusan == 'tidak_lulus')
                                            <span class="bg-red-500 text-white px-3 py-1 rounded text-xs font-black uppercase tracking-wider shadow-sm">GAGAL</span>
                                        @else
                                            <span class="bg-yellow-400 text-yellow-900 px-3 py-1 rounded text-xs font-black uppercase tracking-wider shadow-sm">PROSES</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            @if($kelasAktif->status_kelulusan == 'lulus')
                            <div class="mt-4">
                                @if(isset($detailNilai['nomor_sertifikat']))
                                    <a href="{{ route('peserta.sertifikat.index') }}" class="block w-full text-center bg-hitam text-white py-3 rounded-xl font-bold shadow-lg hover:bg-oranye transition flex justify-center items-center gap-2 transform hover:-translate-y-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Ambil Sertifikat Saya
                                    </a>
                                @else
                                    <div class="bg-yellow-50 border border-yellow-200 p-3 rounded-xl text-center shadow-sm">
                                        <p class="text-[11px] font-bold text-yellow-800 uppercase tracking-widest mb-1">Status Sertifikat</p>
                                        <p class="text-xs text-yellow-700">Anda telah lulus. Menunggu Admin memproses & menerbitkan nomor registrasi sertifikat Anda.</p>
                                    </div>
                                @endif
                            </div>
                            @endif

                        </div>
                    </div>

                    <div class="lg:col-span-2 bg-white p-6 md:p-8 rounded-2xl shadow-lg border border-gray-100">
                        <h4 class="font-black text-xl text-hitam mb-2 flex items-center gap-2">
                            <svg class="w-6 h-6 text-oranye" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Timeline Kehadiran & Materi
                        </h4>
                        <p class="text-sm text-gray-500 mb-8 pb-4 border-b border-gray-100">Pantau kehadiran harian Anda dan unduh modul materi yang dilampirkan instruktur.</p>
                        
                        @if($kelasAktif->kelas?->pertemuan && $kelasAktif->kelas->pertemuan->count() > 0)
                            <div class="relative border-l-2 border-dashed border-gray-300 ml-4 space-y-8 pb-8 mt-4">
                                @foreach($kelasAktif->kelas->pertemuan as $pertemuan)
                                    @php
                                        // Cari data absensi untuk kehadiran
                                        $absen = \App\Models\Absensi::where('pertemuan_id', $pertemuan->id)
                                                    ->where('pendaftaran_id', $kelasAktif->id)
                                                    ->first();
                                                    
                                        $sudahSelesai = \Carbon\Carbon::parse($pertemuan->tanggal)->isPast();
                                        $hariIni = \Carbon\Carbon::parse($pertemuan->tanggal)->isToday();
                                    @endphp
                                    
                                    <div class="relative pl-8 group">
                                        <div class="absolute -left-[11px] top-1 w-5 h-5 rounded-full border-4 border-white shadow-sm flex items-center justify-center transition-colors duration-300 {{ $hariIni ? 'bg-oranye animate-pulse' : ($sudahSelesai ? 'bg-hitam' : 'bg-gray-300') }}"></div>
                                        
                                        <div class="bg-white border {{ $hariIni ? 'border-oranye shadow-md' : 'border-gray-200 group-hover:border-gray-300' }} rounded-xl p-5 transition-all duration-300 relative">
                                            
                                            <div class="absolute -top-3 left-4 bg-white px-2">
                                                <span class="text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded border {{ $hariIni ? 'bg-orange-50 text-oranye border-oranye' : 'bg-gray-50 text-gray-500 border-gray-200' }}">
                                                    {{ \Carbon\Carbon::parse($pertemuan->tanggal)->translatedFormat('l, d M Y') }}
                                                </span>
                                            </div>

                                            <h5 class="font-black text-lg text-hitam mt-2">{{ $pertemuan->judul_pertemuan }}</h5>
                                            
                                            <div class="mt-4 flex flex-col sm:flex-row gap-3">
                                                
                                                @if($absen && $absen->status != 'alpa')
                                                    <div class="bg-gray-50 px-4 py-3 rounded-lg border border-gray-100 flex items-center gap-3 w-full sm:w-1/2">
                                                        <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 bg-green-100 text-green-600">

                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                        </div>
                                                        <div>
                                                            <p class="text-[10px] text-gray-500 font-bold uppercase">Status Presensi</p>
                                                            <p class="text-sm font-black text-hitam capitalize">{{ $absen->status }}</p>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="bg-gray-50 px-4 py-3 rounded-lg border border-dashed border-gray-300 flex items-center gap-3 w-full sm:w-1/2">
                                                        <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center shrink-0">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                        </div>
                                                        <div>
                                                            <p class="text-[10px] text-gray-500 font-bold uppercase">Status Presensi</p>
                                                            <p class="text-xs font-bold text-gray-400 italic">Belum Diabsen</p>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if($pertemuan->file_materi)
                                                    <a href="{{ asset('storage/' . $pertemuan->file_materi) }}" target="_blank" download class="bg-hitam hover:bg-gray-800 text-white px-4 py-3 rounded-lg border border-gray-800 flex items-center gap-3 transition group/btn w-full sm:w-1/2">
                                                        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center group-hover/btn:scale-110 transition transform shrink-0">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                        </div>
                                                        <div>
                                                            <p class="text-[10px] text-gray-300 font-bold uppercase">Modul / Materi</p>
                                                            <p class="text-sm font-black">Unduh File</p>
                                                        </div>
                                                    </a>
                                                @else
                                                    <div class="bg-gray-50 px-4 py-3 rounded-lg border border-gray-100 flex items-center gap-3 w-full sm:w-1/2 opacity-60 cursor-not-allowed">
                                                        <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center shrink-0">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                                        </div>
                                                        <div>
                                                            <p class="text-[10px] text-gray-500 font-bold uppercase">Modul / Materi</p>
                                                            <p class="text-xs font-bold text-gray-400 italic">Tidak ada file</p>
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>
                                            
                                        </div>
                                    </div>
                                @endforeach

                                <div class="relative pl-8 pt-4">
                                    <div class="absolute -left-[14px] bg-white w-7 h-7 rounded-full border-4 border-gray-300 shadow flex items-center justify-center">
                                        <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                                    </div>
                                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-5 text-center shadow-sm">
                                        <h5 class="font-black text-blue-900">Evaluasi Akhir Instruktur</h5>
                                        <p class="text-xs text-blue-700 mt-1">Lihat detail nilai dan catatan kelulusan pada Rapor di panel sebelah kiri.</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-16 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <p class="text-gray-500 font-bold text-lg">Jadwal Belum Disusun</p>
                                <p class="text-sm text-gray-400 mt-1">Instruktur belum menambahkan jadwal kehadiran untuk kelas Anda.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="bg-white p-12 rounded-3xl shadow-lg text-center border border-gray-100 mt-8 relative overflow-hidden group">
                    <div class="w-24 h-24 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition duration-500">
                        <svg class="w-12 h-12 text-oranye" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h4 class="text-2xl font-black text-hitam mb-3">Belum Ada Kelas Aktif</h4>
                    <p class="text-gray-500 max-w-lg mx-auto mb-8 leading-relaxed">Anda belum mendaftar kelas pelatihan, atau pendaftaran Anda sedang dalam tahap verifikasi oleh Admin.</p>
                    <a href="{{ route('peserta.pendaftaran.index') }}" class="inline-flex items-center gap-2 bg-hitam text-white px-8 py-3.5 rounded-xl font-bold shadow-lg hover:shadow-xl hover:bg-oranye transition transform hover:-translate-y-1">
                        Daftar Program Sekarang
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>