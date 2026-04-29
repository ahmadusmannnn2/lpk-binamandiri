<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Ruang Belajar Saya') }}</h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(!$peserta || !$peserta->nik || !$peserta->pas_foto)
            <div class="bg-red-50 border-l-4 border-red-500 p-5 rounded-r-2xl shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex items-start gap-4">
                    <div class="bg-red-100 p-2 rounded-full">
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
                    <p class="text-gray-300 max-w-xl text-sm md:text-base">Konsistensi adalah kunci menjadi ahli. Mari pantau kemajuan kelas Anda, unduh materi, dan perhatikan evaluasi instruktur.</p>
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
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    <span class="font-medium">Instruktur: <span class="font-bold text-hitam">{{ $kelasAktif->kelas?->instruktur?->user?->name ?? 'Belum Ada' }}</span></span>
                                </div>
                                <div class="flex items-center gap-3 text-sm text-gray-600">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="font-medium">Periode: <span class="font-bold text-hitam">{{ \Carbon\Carbon::parse($kelasAktif->kelas?->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($kelasAktif->kelas?->tanggal_selesai)->format('d M Y') }}</span></span>
                                </div>
                            </div>
                            
                            <div class="bg-blue-50 rounded-xl p-5 border border-blue-200 mt-4">
                                <p class="text-[10px] font-black text-blue-800 uppercase tracking-widest border-b border-blue-200 pb-2 mb-3">Rapor Evaluasi Akhir</p>
                                
                                <div class="space-y-3">
                                    <div>
                                        <div class="flex justify-between text-xs font-bold mb-1">
                                            <span class="text-blue-900">Total Kehadiran</span>
                                            <span class="{{ $kelasAktif->kehadiran >= 80 ? 'text-green-600' : 'text-red-600' }}">{{ $kelasAktif->kehadiran ?? 0 }}%</span>
                                        </div>
                                        <div class="w-full bg-blue-200 rounded-full h-2">
                                            <div class="{{ $kelasAktif->kehadiran >= 80 ? 'bg-green-500' : 'bg-red-500' }} h-full rounded-full" style="width: {{ $kelasAktif->kehadiran ?? 0 }}%"></div>
                                        </div>
                                    </div>

                                    <div class="flex justify-between items-center text-sm">
                                        <span class="font-medium text-blue-900">Nilai Ujian Teori</span>
                                        <span class="font-black text-hitam">{{ $kelasAktif->nilai_teori ?? 0 }}</span>
                                    </div>
                                    
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="font-medium text-blue-900">Nilai Ujian Praktik</span>
                                        <span class="font-black text-hitam">{{ $kelasAktif->nilai_praktik ?? 0 }}</span>
                                    </div>

                                    <div class="pt-3 border-t border-blue-200 flex justify-between items-center">
                                        <span class="font-bold text-blue-900">Status Kelulusan</span>
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
                                <a href="{{ route('peserta.sertifikat.index') }}" class="block w-full text-center bg-hitam text-white py-3 rounded-xl font-bold shadow-lg hover:bg-oranye transition flex justify-center items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Ambil Sertifikat Saya
                                </a>
                            </div>
                            @endif

                        </div>
                    </div>

                    <div class="lg:col-span-2 bg-white p-6 md:p-8 rounded-2xl shadow-lg border border-gray-100">
                        <h4 class="font-black text-xl text-hitam mb-2 flex items-center gap-2">
                            <svg class="w-6 h-6 text-oranye" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Timeline & Progress Pembelajaran
                        </h4>
                        <p class="text-sm text-gray-500 mb-8 pb-4 border-b border-gray-100">Semua materi, status kehadiran, dan nilai harian Anda terekam di sini.</p>
                        
                        @if($kelasAktif->kelas?->pertemuan && $kelasAktif->kelas->pertemuan->count() > 0)
                            <div class="relative border-l-2 border-dashed border-gray-300 ml-4 space-y-10 pb-8 mt-4">
                                @foreach($kelasAktif->kelas->pertemuan as $pertemuan)
                                    @php
                                        // Cari data absensi peserta ini untuk pertemuan yang sedang di-looping
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
                                            
                                            @if($absen && $absen->status != 'alpa')
                                                <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-3">
                                                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-100 flex items-center gap-3">
                                                        <div class="w-8 h-8 rounded-full flex items-center justify-center
                                                            {{ $absen->status == 'hadir' ? 'bg-green-100 text-green-600' : ($absen->status == 'izin' ? 'bg-blue-100 text-blue-600' : 'bg-yellow-100 text-yellow-600') }}">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                        </div>
                                                        <div>
                                                            <p class="text-[10px] text-gray-500 font-bold uppercase">Status</p>
                                                            <p class="text-sm font-black text-hitam capitalize">{{ $absen->status }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-100 flex items-center gap-3">
                                                        <div class="w-8 h-8 rounded-full bg-orange-50 text-oranye flex items-center justify-center">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                                                        </div>
                                                        <div>
                                                            <p class="text-[10px] text-gray-500 font-bold uppercase">Nilai Harian</p>
                                                            <p class="text-sm font-black text-hitam">{{ $absen->nilai ?? '-' }}</p>
                                                        </div>
                                                    </div>

                                                    @if($pertemuan->file_materi)
                                                        <a href="{{ asset('storage/' . $pertemuan->file_materi) }}" target="_blank" download class="bg-hitam hover:bg-gray-800 text-white p-3 rounded-lg border border-gray-800 flex items-center gap-3 transition group/btn">
                                                            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center group-hover/btn:scale-110 transition transform">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                            </div>
                                                            <div>
                                                                <p class="text-[10px] text-gray-300 font-bold uppercase">Modul / Materi</p>
                                                                <p class="text-sm font-black">Unduh File</p>
                                                            </div>
                                                        </a>
                                                    @else
                                                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100 flex items-center justify-center">
                                                            <p class="text-xs text-gray-400 font-medium italic">Tidak ada materi</p>
                                                        </div>
                                                    @endif
                                                </div>

                                                @if($absen->catatan)
                                                    <div class="mt-4 bg-yellow-50 border border-yellow-200 rounded-lg p-3 text-sm text-yellow-800 flex gap-2">
                                                        <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                                        <div>
                                                            <span class="font-bold text-[10px] uppercase tracking-wider block mb-1">Catatan Instruktur:</span>
                                                            <span class="font-medium italic">"{{ $absen->catatan }}"</span>
                                                        </div>
                                                    </div>
                                                @endif

                                            @else
                                                <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-dashed border-gray-300 flex items-center justify-between">
                                                    <p class="text-sm text-gray-500 italic">Belum ada data presensi atau nilai masuk.</p>
                                                    
                                                    @if($pertemuan->file_materi)
                                                        <a href="{{ asset('storage/' . $pertemuan->file_materi) }}" target="_blank" download class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1 bg-blue-50 px-3 py-1.5 rounded-full border border-blue-200">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                            Unduh Materi
                                                        </a>
                                                    @endif
                                                </div>
                                            @endif
                                            
                                        </div>
                                    </div>
                                @endforeach

                                <div class="relative pl-8 pt-6">
                                    <div class="absolute -left-[14px] bg-white w-7 h-7 rounded-full border-4 border-gray-300 shadow flex items-center justify-center">
                                        <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                                    </div>
                                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-5 text-center">
                                        <h5 class="font-black text-gray-700">Evaluasi Akhir & Sertifikasi</h5>
                                        <p class="text-xs text-gray-500 mt-1">Admin akan merilis sertifikat jika Anda dinyatakan Lulus pada kartu Rapor di sebelah kiri.</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-16 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <p class="text-gray-500 font-bold text-lg">Jadwal Belum Disusun</p>
                                <p class="text-sm text-gray-400 mt-1">Instruktur belum menambahkan jadwal pertemuan untuk kelas Anda.</p>
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