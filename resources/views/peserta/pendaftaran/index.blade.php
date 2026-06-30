<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">
            {{ __('Pilih Program Pelatihan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if($pendaftaranAktif)
                <div class="mb-8 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg shadow-sm flex items-start gap-3">
                    <svg class="w-6 h-6 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <h4 class="font-bold text-blue-800">Informasi Pendaftaran</h4>
                        <p class="text-sm text-blue-700 mt-1">Anda saat ini sudah memiliki pendaftaran yang berstatus <strong>{{ str_replace('_', ' ', strtoupper($pendaftaranAktif->status_pendaftaran)) }}</strong> pada kelas <strong>{{ $pendaftaranAktif->kelas->nama_kelas ?? 'Tidak diketahui' }}</strong>. Anda tetap bisa melihat-lihat program lain, namun disarankan menyelesaikan program saat ini terlebih dahulu.</p>
                    </div>
                </div>
            @endif

            <div class="text-center mb-10">
                <h3 class="text-3xl font-black text-hitam">Program <span class="text-oranye">Unggulan</span> Kami</h3>
                <p class="text-gray-500 mt-2">Pilih program pelatihan yang sesuai dengan minat dan karir Anda ke depan.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($programs as $program)
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden group hover:shadow-2xl hover:border-oranye/50 transition duration-300 flex flex-col">
                        <div class="h-40 bg-hitam relative overflow-hidden flex items-center justify-center group-hover:opacity-90 transition">
                            @if($program->gambar)
                                <img src="{{ asset('storage/' . $program->gambar) }}" alt="{{ $program->nama_program }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                                <svg class="w-16 h-16 text-oranye/50 group-hover:scale-110 transition duration-500 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            @endif
                        </div>
                        
                        <div class="p-6 flex flex-col flex-1">
                            <h4 class="text-xl font-bold text-hitam mb-2 group-hover:text-oranye transition">{{ $program->nama_program }}</h4>
                            <p class="text-sm text-gray-500 line-clamp-3 mb-6 flex-1">{{ $program->deskripsi ?? 'Tidak ada deskripsi untuk program ini.' }}</p>
                            
                            <a href="{{ route('peserta.pendaftaran.show_program', $program->id) }}" class="block w-full text-center bg-gray-50 hover:bg-oranye text-gray-700 hover:text-white font-bold py-3 px-4 rounded-xl border border-gray-200 hover:border-oranye transition duration-300">
                                Lihat Pilihan Kelas
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center bg-white rounded-2xl shadow-sm border border-gray-200">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        <h3 class="text-xl font-bold text-gray-400">Belum ada program pelatihan yang tersedia.</h3>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>