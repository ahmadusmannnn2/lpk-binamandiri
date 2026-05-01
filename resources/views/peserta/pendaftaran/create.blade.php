<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('peserta.pendaftaran.show_program', $kelas->program_pelatihan_id) }}" class="text-gray-500 hover:text-oranye transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-xl text-hitam leading-tight">
                {{ __('Konfirmasi Pendaftaran') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-oranye">
                <div class="p-6 sm:p-10 flex flex-col md:flex-row gap-10">
                    
                    <!-- BAGIAN KIRI: INFO TAGIHAN -->
                    <div class="flex-1 w-full">
                        <h3 class="text-xl font-black text-hitam border-b border-gray-200 pb-3 mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-oranye" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Detail Tagihan Anda
                        </h3>
                        
                        <div class="bg-gray-50 rounded-xl border border-dashed border-gray-300 p-6 relative">
                            <div class="absolute -left-3 top-1/2 w-6 h-6 bg-white rounded-full border-r border-dashed border-gray-300"></div>
                            <div class="absolute -right-3 top-1/2 w-6 h-6 bg-white rounded-full border-l border-dashed border-gray-300"></div>

                            <div class="space-y-4">
                                <div>
                                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Program Pelatihan</p>
                                    <p class="text-lg font-bold text-hitam">{{ $kelas->programPelatihan->nama_program }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Angkatan / Kelas</p>
                                    <p class="text-base font-semibold text-gray-700">{{ $kelas->nama_kelas }}</p>
                                </div>
                                
                                <div class="border-t border-gray-200 my-4 pt-4">
                                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-1">Total Pembayaran</p>
                                    @php
                                        $hargaTagihan = $kelas->harga ?? $kelas->programPelatihan->harga_pelatihan ?? 0;
                                    @endphp
                                    <p class="text-4xl font-black text-oranye">Rp {{ number_format($hargaTagihan, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- INFO MIDTRANS -->
                        <div class="mt-6 bg-blue-50 rounded-xl p-5 border border-blue-100 flex gap-4">
                            <div class="bg-white p-3 rounded-lg shadow-sm h-fit">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-blue-900 mb-1">Sistem Pembayaran Otomatis</h4>
                                <p class="text-sm text-blue-800">Anda dapat membayar menggunakan QRIS, GoPay, OVO, Virtual Account BCA/Mandiri/BNI. Pembayaran akan terkonfirmasi secara instan.</p>
                            </div>
                        </div>
                    </div>

                    <!-- BAGIAN KANAN: TOMBOL LANJUT -->
                    <div class="w-full md:w-1/3 flex flex-col justify-center">
                        <form action="{{ route('peserta.pendaftaran.store', $kelas->id) }}" method="POST" class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm relative z-10 text-center">
                            @csrf
                            
                            <h3 class="font-bold text-hitam mb-4">Konfirmasi Pendaftaran</h3>
                            <p class="text-sm text-gray-500 mb-6">Dengan melanjutkan, Anda akan terdaftar di kelas ini dan diarahkan ke halaman pembayaran aman Midtrans.</p>

                            <button type="submit" class="w-full bg-hitam text-white px-6 py-4 rounded-xl hover:bg-oranye transition shadow-lg hover:shadow-xl font-bold flex items-center justify-center gap-2 group">
                                <span>Lanjut ke Pembayaran</span>
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                            
                            <a href="{{ route('peserta.pendaftaran.show_program', $kelas->program_pelatihan_id) }}" class="block w-full text-center text-sm font-bold text-gray-400 hover:text-red-500 mt-4 transition">
                                Batalkan
                            </a>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>