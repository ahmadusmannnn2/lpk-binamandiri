<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Ruang Kerja Instruktur') }}</h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- 1. PAPAN SAMBUTAN PERSONAL (POIN 5) -->
            <div class="bg-hitam text-white rounded-3xl p-8 md:p-10 shadow-2xl border-b-4 border-oranye flex items-center justify-between relative overflow-hidden">
                <div class="absolute -right-10 -top-10 opacity-10 pointer-events-none">
                    <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11l3 3L22 4"></path></svg>
                </div>
                <div class="relative z-10 flex items-center gap-6">
                    <div class="w-20 h-20 bg-gray-800 rounded-full border-2 border-oranye flex items-center justify-center shadow-lg shrink-0">
                        <svg class="w-10 h-10 text-oranye" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-3xl md:text-4xl font-black mb-1 tracking-tight">Selamat Bertugas, <span class="text-oranye">{{ Auth::user()->name }}!</span></h3>
                        <p class="text-gray-400 text-sm md:text-base font-medium">Spesialisasi: <span class="text-white font-bold">{{ $instruktur->spesialisasi_las ?? 'Instruktur Umum' }}</span></p>
                    </div>
                </div>
            </div>

            <!-- 2. WIDGET TUGAS TERTUNDA (POIN 1) -->
            @if($tugasTertunda->count() > 0)
            <div class="bg-red-50 border-l-4 border-red-500 p-5 rounded-r-2xl shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border border-red-100 relative overflow-hidden">
                <div class="flex items-start gap-4 relative z-10">
                    <div class="bg-red-100 p-3 rounded-full shrink-0">
                        <svg class="w-6 h-6 text-red-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <p class="font-black text-red-800 text-lg">Peringatan: Ada Tugas Tertunda!</p>
                        <p class="text-sm text-red-700 mt-1">Anda memiliki <strong>{{ $tugasTertunda->count() }} pertemuan kelas</strong> yang sudah lewat namun belum diisi data kehadirannya (Absensi).</p>
                    </div>
                </div>
                <a href="{{ route('instruktur.jadwal.index') }}" class="bg-red-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-md hover:bg-red-700 transition w-full sm:w-auto text-center whitespace-nowrap z-10">
                    Isi Absensi Sekarang
                </a>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- KOLOM KIRI (QUICK ACCESS KELAS BERJALAN - POIN 4) -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-6 h-6 text-oranye" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <h4 class="font-black text-xl text-hitam">Jalan Pintas Kelas Aktif</h4>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse($kelasAktif as $kelas)
                            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:border-oranye transition duration-300 group relative">
                                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-oranye to-[#c24b22] rounded-t-2xl"></div>
                                
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-2 mb-1">{{ $kelas->programPelatihan->nama_program ?? 'Program' }}</p>
                                <h5 class="font-black text-xl text-hitam leading-tight">{{ $kelas->nama_kelas }}</h5>
                                
                                <div class="flex items-center gap-4 mt-4 text-sm text-gray-600 bg-gray-50 p-3 rounded-xl border border-gray-100">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-oranye" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        <span class="font-bold">{{ $kelas->pendaftaran_count }} Peserta</span>
                                    </div>
                                    <div class="w-px h-4 bg-gray-300"></div>
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span class="font-bold text-[11px]">{{ \Carbon\Carbon::parse($kelas->tanggal_selesai)->format('d M') }}</span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-3 gap-2 mt-5">
                                    <a href="{{ route('instruktur.materi.index', $kelas->id) }}" title="Upload Materi" class="bg-gray-100 hover:bg-hitam hover:text-white text-gray-700 text-center py-2 rounded-lg text-[10px] font-bold transition shadow-sm flex flex-col items-center justify-center gap-1 border border-gray-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        Materi
                                    </a>
                                    <a href="{{ route('instruktur.jadwal.show', $kelas->id) }}#absensi" title="Isi Kehadiran" class="bg-blue-50 hover:bg-blue-600 text-blue-700 hover:text-white text-center py-2 rounded-lg text-[10px] font-bold transition shadow-sm flex flex-col items-center justify-center gap-1 border border-blue-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Absensi
                                    </a>
                                    <a href="{{ route('instruktur.jadwal.show', $kelas->id) }}#penilaian" title="Beri Penilaian Akhir" class="bg-oranye hover:bg-[#c24b22] text-white text-center py-2 rounded-lg text-[10px] font-bold transition shadow-md flex flex-col items-center justify-center gap-1 border border-orange-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Rapor
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full bg-white p-8 rounded-2xl shadow-sm border-2 border-dashed border-gray-200 text-center">
                                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                <p class="text-gray-500 font-bold">Belum ada kelas aktif yang ditugaskan kepada Anda saat ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- KOLOM KANAN (TIMELINE JADWAL - POIN 2) -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 h-full">
                        <h4 class="font-black text-xl text-hitam mb-6 flex items-center gap-2 border-b border-gray-100 pb-3">
                            <svg class="w-6 h-6 text-oranye" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Jadwal Mengajar
                        </h4>

                        <!-- TIMELINE HARI INI -->
                        <div class="mb-8">
                            <span class="bg-oranye text-white px-3 py-1 rounded-md text-xs font-black uppercase tracking-widest shadow-sm">Hari Ini</span>
                            
                            <div class="mt-5 space-y-5 relative before:absolute before:inset-0 before:ml-2 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-gray-200 before:to-transparent pl-6">
                                @forelse($jadwalHariIni as $jdw)
                                    <div class="relative">
                                        <div class="absolute -left-[30px] bg-oranye w-4 h-4 rounded-full border-4 border-orange-100 shadow-sm animate-pulse mt-1"></div>
                                        <div class="bg-orange-50 border border-orange-100 p-4 rounded-xl shadow-sm hover:shadow-md transition">
                                            <p class="text-xs font-black text-oranye mb-1">{{ $jdw->kelas->nama_kelas }}</p>
                                            <p class="font-bold text-hitam text-sm">{{ $jdw->judul_pertemuan }}</p>
                                            <a href="{{ route('instruktur.pertemuan.show', $jdw->id) }}" class="mt-3 block text-center bg-white border border-gray-200 text-xs font-bold text-hitam py-1.5 rounded hover:bg-hitam hover:text-white transition">Masuk Kelas</a>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-400 italic">Tidak ada jadwal kelas hari ini.</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- TIMELINE BESOK -->
                        <div>
                            <span class="bg-gray-200 text-gray-600 px-3 py-1 rounded-md text-xs font-black uppercase tracking-widest">Besok</span>
                            
                            <div class="mt-5 space-y-5 relative before:absolute before:inset-0 before:ml-2 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-gray-200 before:to-transparent pl-6 opacity-70">
                                @forelse($jadwalBesok as $jdw)
                                    <div class="relative">
                                        <div class="absolute -left-[30px] bg-gray-400 w-4 h-4 rounded-full border-4 border-gray-100 mt-1"></div>
                                        <div class="bg-gray-50 border border-gray-200 p-4 rounded-xl">
                                            <p class="text-xs font-bold text-gray-500 mb-1">{{ $jdw->kelas->nama_kelas }}</p>
                                            <p class="font-bold text-gray-700 text-sm">{{ $jdw->judul_pertemuan }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-400 italic">Tidak ada jadwal kelas besok.</p>
                                @endforelse
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>