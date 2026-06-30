<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Jadwal Mengajar Saya') }}</h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-hitam text-white p-6 md:p-8 rounded-2xl shadow-xl border-b-4 border-oranye flex items-start gap-4 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 opacity-10">
                    <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <div class="relative z-10">
                    <h4 class="font-black text-2xl mb-1">Daftar Kelas Anda</h4>
                    <p class="text-sm text-gray-300 max-w-2xl leading-relaxed">Berikut adalah daftar kelas pelatihan yang ditugaskan kepada Anda. Pilih kelas untuk membuat jadwal pertemuan, mengunggah materi, dan mengisi nilai peserta.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($kelas as $item)
                    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-lg transition duration-300 hover:border-oranye flex flex-col h-full group">
                        <div class="flex justify-between items-start mb-3">
                            <h4 class="font-black text-xl text-hitam leading-tight group-hover:text-oranye transition">{{ $item->nama_kelas }}</h4>
                            @if($item->status_kelas == 'menunggu')
                                <span class="bg-yellow-100 text-yellow-700 py-1 px-3 rounded-full text-[10px] font-black uppercase tracking-wider border border-yellow-200 shrink-0">Menunggu</span>
                            @elseif($item->status_kelas == 'berjalan')
                                <span class="bg-green-100 text-green-700 py-1 px-3 rounded-full text-[10px] font-black uppercase tracking-wider border border-green-200 shrink-0 animate-pulse">Berjalan</span>
                            @else
                                <span class="bg-gray-100 text-gray-600 py-1 px-3 rounded-full text-[10px] font-black uppercase tracking-wider border border-gray-200 shrink-0">Selesai</span>
                            @endif
                        </div>
                        
                        <p class="text-sm font-bold text-oranye uppercase tracking-wider mb-4">{{ $item->programPelatihan?->nama_program ?? 'Program Terhapus' }}</p>
                        
                        <div class="mt-auto pt-4 border-t border-gray-100 space-y-2 mb-6">
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                <strong>Kuota:</strong> {{ $item->kuota_peserta }} Peserta
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <strong>Periode:</strong> {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2 w-full mt-2">
                            <a href="{{ route('instruktur.jadwal.show', $item->id) }}#absensi" class="flex flex-col items-center justify-center gap-1 bg-blue-50 border border-blue-200 text-blue-700 py-2.5 rounded-xl hover:bg-blue-600 hover:text-white transition font-bold text-[10px] sm:text-xs shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Absensi
                            </a>
                            <a href="{{ route('instruktur.jadwal.show', $item->id) }}#penilaian" class="flex flex-col items-center justify-center gap-1 bg-oranye border border-orange-500 text-white py-2.5 rounded-xl hover:bg-[#c24b22] transition font-bold text-[10px] sm:text-xs shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                Rapor
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16 bg-white border border-gray-100 rounded-3xl shadow-sm">
                        <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <h4 class="text-xl font-bold text-hitam mb-2">Belum Ada Jadwal</h4>
                        <p class="text-gray-500">Anda belum ditugaskan untuk mengajar di kelas manapun saat ini.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>