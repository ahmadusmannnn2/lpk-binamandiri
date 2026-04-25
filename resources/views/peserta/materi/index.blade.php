<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Materi Pelatihan') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <p class="text-gray-600 bg-white p-4 rounded shadow-sm border-l-4 border-oranye">Berikut adalah materi pembelajaran dari kelas-kelas yang Anda ikuti. Silakan unduh untuk dipelajari.</p>

            @forelse($pendaftaran as $daftar)
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-hitam">
                    <div class="p-6 bg-gray-50 border-b flex justify-between items-center">
                        <div>
                            <h3 class="font-bold text-lg text-hitam">{{ $daftar->kelas->nama_kelas }}</h3>
                            <p class="text-sm text-oranye font-bold">{{ $daftar->kelas->programPelatihan->nama_program }}</p>
                        </div>
                        <div class="text-right text-xs text-gray-500">
                            <p>Instruktur: <strong>{{ $daftar->kelas->instruktur->user->name }}</strong></p>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        @if($daftar->kelas->materi->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($daftar->kelas->materi as $materi)
                                    <div class="border rounded-lg p-4 hover:shadow-md transition bg-white relative">
                                        <div class="absolute top-4 right-4 text-gray-300">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <h4 class="font-bold text-hitam pr-8">{{ $materi->judul_materi }}</h4>
                                        <p class="text-xs text-gray-500 mt-2 mb-4 h-8 overflow-hidden">{{ $materi->deskripsi }}</p>
                                        <a href="{{ asset('storage/' . $materi->file_materi) }}" target="_blank" download class="inline-block w-full text-center bg-gray-100 hover:bg-oranye hover:text-white text-hitam text-sm font-bold py-2 rounded transition">
                                            Unduh Materi
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-gray-400 italic py-4">Instruktur belum mengunggah materi untuk kelas ini.</p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center bg-white p-10 rounded-lg shadow border-2 border-dashed border-gray-300">
                    <p class="text-gray-500">Anda belum tergabung dalam kelas manapun yang telah disetujui.</p>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>