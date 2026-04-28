<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('peserta.pendaftaran.show_program', $kelas->program_pelatihan_id) }}" class="text-gray-500 hover:text-oranye transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-xl text-hitam leading-tight">
                {{ __('Selesaikan Pendaftaran') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-oranye">
                <div class="p-6 sm:p-10 flex flex-col md:flex-row gap-10">
                    
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
                                        // Mengambil harga dari tabel kelas jika ada, jika tidak pakai harga default program
                                        $hargaTagihan = $kelas->harga ?? $kelas->programPelatihan->harga_pelatihan ?? 0;
                                    @endphp
                                    <p class="text-4xl font-black text-oranye">Rp {{ number_format($hargaTagihan, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 bg-blue-50 rounded-xl p-5 border border-blue-100 flex gap-4">
                            <div class="bg-white p-3 rounded-lg shadow-sm h-fit">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-blue-900 mb-1">Metode Pembayaran Manual</h4>
                                <p class="text-sm text-blue-800">Silakan transfer sesuai nominal tagihan ke rekening berikut:</p>
                                <div class="mt-2 bg-white px-4 py-2 rounded border border-blue-200 inline-block">
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Bank BCA</p>
                                    <p class="font-black text-lg text-hitam tracking-widest">123 456 789</p>
                                    <p class="text-xs font-bold text-gray-700">a.n LPK Bina Mandiri</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-full md:w-1/3 flex flex-col justify-center">
                        <form action="{{ route('peserta.pendaftaran.store', $kelas->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm relative z-10">
                            @csrf
                            
                            <h3 class="font-bold text-hitam mb-4 text-center">Konfirmasi Pembayaran</h3>
                            
                            <div class="mb-6">
                                <label for="bukti_pembayaran" class="block text-sm font-bold text-gray-700 mb-2 text-center">Upload Bukti Transfer</label>
                                <div class="border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:border-oranye hover:bg-orange-50 transition cursor-pointer relative">
                                    <input id="bukti_pembayaran" type="file" name="bukti_pembayaran" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required />
                                    <svg class="mx-auto h-10 w-10 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                    <p class="text-xs text-gray-500 font-medium">Klik atau seret file ke sini</p>
                                    <p class="text-[10px] text-gray-400 mt-1">JPG/PNG (Maks 2MB)</p>
                                </div>
                                <x-input-error :messages="$errors->get('bukti_pembayaran')" class="mt-2 text-center" />
                            </div>

                            <button type="submit" class="w-full bg-hitam text-white px-6 py-3 rounded-xl hover:bg-oranye transition shadow-lg hover:shadow-xl font-bold flex items-center justify-center gap-2 group">
                                <span>Kirim & Daftar</span>
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                            
                            <a href="{{ route('peserta.pendaftaran.show_program', $kelas->program_pelatihan_id) }}" class="block w-full text-center text-sm font-bold text-gray-500 hover:text-red-500 mt-4 transition">
                                Batalkan
                            </a>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>