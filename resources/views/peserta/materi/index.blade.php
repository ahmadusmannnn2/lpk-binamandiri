<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Materi Pelatihan') }}</h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-blue-50 border border-blue-200 p-5 rounded-2xl shadow-sm flex items-start gap-4">
                <div class="bg-white p-2 rounded-full shadow-sm">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div>
                    <h4 class="font-bold text-blue-900">Pusat Pembelajaran</h4>
                    <p class="text-sm text-blue-800 mt-1">Berikut adalah materi dari kelas yang Anda ikuti. Materi akan ditambahkan oleh instruktur secara berkala sesuai dengan jadwal pertemuan.</p>
                </div>
            </div>

            @forelse($pendaftaran as $daftar)
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-hitam transition hover:shadow-2xl">
                    <div class="p-6 md:p-8 bg-gray-50 border-b flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div>
                            <h3 class="font-black text-2xl text-hitam mb-1">{{ $daftar->kelas?->nama_kelas ?? 'Kelas Telah Dihapus' }}</h3>
                            <p class="text-sm text-oranye font-bold uppercase tracking-wider">{{ $daftar->kelas?->programPelatihan?->nama_program ?? 'Program Terhapus' }}</p>
                        </div>
                        <div class="text-left md:text-right text-sm text-gray-500 bg-white px-4 py-2 border border-gray-200 rounded-xl shadow-sm">
                            <p>Instruktur Pengajar</p>
                            <p class="font-black text-hitam text-base">{{ $daftar->kelas?->instruktur?->user?->name ?? 'Belum Ditentukan' }}</p>
                        </div>
                    </div>
                    
                    <div class="p-6 md:p-8">
                        @if($daftar->kelas?->materi?->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($daftar->kelas->materi as $materi)
                                    <div class="border border-gray-200 rounded-2xl p-5 hover:border-oranye hover:shadow-lg transition bg-white relative group">
                                        <div class="absolute top-5 right-5 text-gray-200 group-hover:text-oranye transition">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <h4 class="font-black text-hitam text-lg pr-10 leading-tight mb-2">{{ $materi->judul_materi }}</h4>
                                        <p class="text-sm text-gray-500 mb-6 h-10 overflow-hidden line-clamp-2">{{ $materi->deskripsi }}</p>
                                        <a href="{{ asset('storage/' . $materi->file_materi) }}" target="_blank" download class="flex items-center justify-center gap-2 w-full text-center bg-gray-100 group-hover:bg-oranye group-hover:text-white text-hitam text-sm font-bold py-3 rounded-xl transition shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                            Unduh File Materi
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-10 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"></path></svg>
                                <p class="text-gray-500 font-bold">Materi belum diunggah</p>
                                <p class="text-xs text-gray-400 mt-1">Instruktur belum menambahkan materi apapun untuk kelas ini.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center bg-white p-16 rounded-2xl shadow border border-gray-100">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    <p class="text-gray-500 font-bold text-lg">Akses Materi Dikunci</p>
                    <p class="text-gray-400 text-sm mt-1">Anda belum tergabung dalam kelas manapun yang telah disetujui oleh admin.</p>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>