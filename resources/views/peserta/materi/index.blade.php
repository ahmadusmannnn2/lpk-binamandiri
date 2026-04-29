<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Silabus & Evaluasi Harian') }}</h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-hitam text-white p-6 md:p-8 rounded-2xl shadow-xl border-b-4 border-oranye flex items-start gap-4 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 opacity-10">
                    <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zm0 7l-10 5 10 5 10-5-10-5zm0 7l-10 5 10 5 10-5-10-5z"></path></svg>
                </div>
                <div class="bg-white/10 p-3 rounded-2xl shadow-inner backdrop-blur-sm relative z-10 hidden sm:block">
                    <svg class="w-10 h-10 text-oranye" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div class="relative z-10">
                    <h4 class="font-black text-2xl mb-1">Pusat Pembelajaran & Evaluasi</h4>
                    <p class="text-sm text-gray-300 max-w-2xl leading-relaxed">Halaman ini memuat silabus detail topik pertemuan Anda setiap harinya. Anda dapat mengunduh modul materi dan memantau nilai serta catatan evaluasi dari Instruktur.</p>
                </div>
            </div>

            @forelse($pendaftaran as $daftar)
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-3xl border border-gray-100 transition hover:shadow-2xl">
                    <div class="p-6 md:p-8 bg-white border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 relative">
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-oranye to-[#c24b22]"></div>
                        <div>
                            <h3 class="font-black text-2xl text-hitam mb-1">{{ $daftar->kelas?->nama_kelas ?? 'Kelas Telah Dihapus' }}</h3>
                            <p class="text-sm text-oranye font-bold uppercase tracking-wider">{{ $daftar->kelas?->programPelatihan?->nama_program ?? 'Program Terhapus' }}</p>
                        </div>
                        <div class="text-left md:text-right text-sm text-gray-500 bg-gray-50 px-5 py-3 border border-gray-200 rounded-xl shadow-sm">
                            <p class="text-xs font-bold uppercase tracking-widest mb-1">Instruktur Pengajar</p>
                            <p class="font-black text-hitam text-base flex items-center gap-2">
                                <svg class="w-4 h-4 text-oranye" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                {{ $daftar->kelas?->instruktur?->user?->name ?? 'Belum Ditentukan' }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="p-6 md:p-8 bg-gray-50/50">
                        @php
                            $pertemuanList = $daftar->kelas?->pertemuan ?? collect();
                        @endphp

                        @if($pertemuanList->count() > 0)
                            <div class="space-y-4">
                                @foreach($pertemuanList as $index => $materi)
                                    @php
                                        // Cari data absensi/evaluasi peserta ini untuk pertemuan ini
                                        $absen = \App\Models\Absensi::where('pertemuan_id', $materi->id)
                                                    ->where('pendaftaran_id', $daftar->id)
                                                    ->first();
                                    @endphp

                                    <div x-data="{ openDetail: false }" class="bg-white border border-gray-200 rounded-2xl hover:border-oranye hover:shadow-md transition duration-300 group overflow-hidden">
                                        
                                        <div class="p-5 flex flex-col md:flex-row gap-5 items-start md:items-center">
                                            <div class="w-16 h-16 shrink-0 bg-orange-50 text-oranye rounded-xl border border-orange-100 flex flex-col items-center justify-center shadow-sm group-hover:bg-oranye group-hover:text-white transition duration-300">
                                                <span class="text-[10px] font-bold uppercase tracking-widest leading-none mb-1">Hari</span>
                                                <span class="text-2xl font-black leading-none">{{ $index + 1 }}</span>
                                            </div>

                                            <div class="flex-grow">
                                                <h4 class="font-black text-hitam text-lg leading-tight mb-2 group-hover:text-oranye transition">{{ $materi->judul_pertemuan }}</h4>
                                                
                                                <div class="flex flex-wrap items-center gap-3 text-xs font-medium text-gray-500">
                                                    <span class="flex items-center gap-1 bg-gray-50 px-2 py-1 rounded border border-gray-100">
                                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                        {{ \Carbon\Carbon::parse($materi->tanggal)->translatedFormat('l, d F Y') }}
                                                    </span>
                                                    @if(\Carbon\Carbon::parse($materi->tanggal)->isToday())
                                                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded font-bold uppercase tracking-wider text-[10px] animate-pulse">Hari Ini</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="shrink-0 w-full md:w-auto mt-4 md:mt-0 pt-4 md:pt-0 border-t md:border-t-0 border-gray-100 flex flex-col sm:flex-row gap-2">
                                                
                                                <button @click="openDetail = !openDetail" class="w-full sm:w-auto flex items-center justify-center gap-2 bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white px-5 py-3 rounded-xl font-bold text-sm transition shadow-sm border border-blue-100">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                                    <span x-text="openDetail ? 'Tutup Evaluasi' : 'Lihat Evaluasi'">Lihat Evaluasi</span>
                                                </button>

                                                @if($materi->file_materi)
                                                    <a href="{{ asset('storage/' . $materi->file_materi) }}" target="_blank" download class="w-full sm:w-auto flex items-center justify-center gap-2 bg-hitam hover:bg-oranye text-white px-5 py-3 rounded-xl font-bold text-sm shadow-sm transition transform hover:-translate-y-0.5">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                        Unduh Modul
                                                    </a>
                                                @else
                                                    <div class="w-full sm:w-auto flex items-center justify-center gap-2 bg-gray-50 text-gray-400 px-5 py-3 rounded-xl font-bold text-xs uppercase tracking-wider border border-gray-200 cursor-not-allowed">
                                                        Modul Kosong
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div x-show="openDetail" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="bg-gray-50/80 border-t border-gray-100 p-5 md:p-6">
                                            @if($absen && $absen->status != 'alpa')
                                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                                    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm flex items-center gap-4">
                                                        <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0
                                                            {{ $absen->status == 'hadir' ? 'bg-green-100 text-green-600' : ($absen->status == 'izin' ? 'bg-blue-100 text-blue-600' : 'bg-yellow-100 text-yellow-600') }}">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                        </div>
                                                        <div>
                                                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Status Presensi</p>
                                                            <p class="text-base font-black text-hitam capitalize">{{ $absen->status }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm flex items-center gap-4">
                                                        <div class="w-10 h-10 rounded-full bg-orange-50 text-oranye flex items-center justify-center shrink-0">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                                                        </div>
                                                        <div>
                                                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Nilai Harian</p>
                                                            <p class="text-base font-black text-hitam">{{ $absen->nilai ?? 'Belum Dinilai' }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm flex items-start gap-4 sm:col-span-2 lg:col-span-1">
                                                        <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                                        </div>
                                                        <div>
                                                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Catatan Instruktur</p>
                                                            <p class="text-sm font-medium text-gray-800 mt-1 italic">{{ $absen->catatan ?? 'Tidak ada catatan.' }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="flex flex-col justify-center items-center py-6 bg-white rounded-xl border border-dashed border-gray-300">
                                                    <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    <p class="text-sm text-gray-500 font-bold">Evaluasi Belum Tersedia</p>
                                                    <p class="text-xs text-gray-400 mt-1">Presensi dan nilai untuk pertemuan ini belum dimasukkan oleh instruktur.</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12 bg-white rounded-2xl border-2 border-dashed border-gray-200">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                <p class="text-gray-500 font-bold text-lg">Silabus Belum Tersedia</p>
                                <p class="text-sm text-gray-400 mt-1">Instruktur belum membuat rincian jadwal atau materi untuk kelas ini.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center bg-white p-16 rounded-3xl shadow-sm border border-gray-100">
                    <svg class="w-20 h-20 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    <p class="text-gray-500 font-bold text-xl">Akses Dikunci</p>
                    <p class="text-gray-400 text-sm mt-2 max-w-sm mx-auto">Anda belum tergabung dalam kelas manapun. Lakukan pendaftaran dan tunggu verifikasi dari Admin untuk membuka perpustakaan materi.</p>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>