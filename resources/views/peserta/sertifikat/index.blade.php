<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('E-Sertifikat Kelulusan') }}</h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-hitam text-white rounded-2xl p-8 shadow-xl border-b-4 border-oranye flex items-center justify-between relative overflow-hidden">
                <div class="absolute right-0 top-0 opacity-10 pointer-events-none">
                    <svg class="w-64 h-64 transform translate-x-16 -translate-y-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 15l-4.243 2.227.81-4.727L5.137 9.17l4.746-.69L12 4l2.117 4.48 4.746.69-3.43 3.33.81 4.727L12 15z"></path></svg>
                </div>
                <div class="relative z-10">
                    <h3 class="text-3xl font-black mb-2">Pencapaian Anda 🏆</h3>
                    <p class="text-gray-300 max-w-2xl">Berikut adalah daftar sertifikat kompetensi dari kelas pelatihan yang telah berhasil Anda selesaikan. Unduh dan gunakan untuk menunjang karir Anda.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-8">
                @forelse($sertifikat as $item)
                    <div class="bg-white border border-gray-200 rounded-2xl p-1 shadow-md hover:shadow-2xl transition duration-300 group">
                        <div class="bg-gray-50 border border-dashed border-gray-300 rounded-xl p-6 h-full flex flex-col relative overflow-hidden">
                            
                            <div class="absolute top-4 -right-8 bg-green-500 text-white text-[10px] font-black px-10 py-1 rotate-45 shadow-sm uppercase tracking-widest">
                                Lulus
                            </div>
                            
                            <div class="text-center mb-6 pt-4">
                                <div class="w-20 h-20 mx-auto bg-gradient-to-br from-oranye to-[#c24b22] rounded-full flex items-center justify-center text-white mb-4 shadow-lg group-hover:scale-110 transition transform duration-500 border-4 border-white">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                                </div>
                                <h4 class="font-black text-hitam text-xl leading-tight">{{ $item->kelas?->programPelatihan?->nama_program ?? 'Program Terhapus' }}</h4>
                                <p class="text-sm text-oranye font-bold mt-2">{{ $item->kelas?->nama_kelas ?? 'Kelas Terhapus' }}</p>
                            </div>
                            
                            <div class="bg-white rounded-lg border border-gray-100 p-4 mb-6 mt-auto">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-xs text-gray-500 font-bold uppercase">Nilai Teori</span>
                                    <span class="text-sm font-black text-hitam">{{ $item->nilai_teori ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-xs text-gray-500 font-bold uppercase">Nilai Praktik</span>
                                    <span class="text-sm font-black text-hitam">{{ $item->nilai_praktik ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between items-center pt-2 border-t border-gray-100">
                                    <span class="text-xs text-gray-500 font-bold uppercase">Tgl Kelulusan</span>
                                    <span class="text-xs font-bold text-oranye">{{ \Carbon\Carbon::parse($item->updated_at)->format('d F Y') }}</span>
                                </div>
                            </div>
                            
                            <a href="{{ route('peserta.sertifikat.cetak', $item->id) }}" target="_blank" class="block w-full text-center bg-hitam text-white px-4 py-3 rounded-lg hover:bg-oranye transition font-bold shadow hover:shadow-lg flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Lihat & Cetak Sertifikat
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-100">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-50 border-2 border-dashed border-gray-300 mb-4">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <h4 class="text-xl font-bold text-hitam mb-2">Belum Ada Sertifikat</h4>
                        <p class="text-gray-500 max-w-md mx-auto">Anda belum memiliki sertifikat kelulusan. Terus semangat belajar dan penuhi standar kelulusan kelas Anda!</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>