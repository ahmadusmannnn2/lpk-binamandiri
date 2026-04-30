<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-hitam leading-tight">
            {{ __('Tambah Program Pelatihan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-oranye">
                <div class="p-8 text-gray-900">
                    <form action="{{ route('admin.program.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <x-input-label for="nama_program" :value="__('Nama Program Pelatihan')" class="text-hitam font-bold text-sm" />
                            <x-text-input id="nama_program" class="block mt-1 w-full focus:border-oranye focus:ring-oranye rounded-xl transition shadow-sm" type="text" name="nama_program" :value="old('nama_program')" required autofocus placeholder="Misal: Sertifikasi Welder SMAW 3G" />
                            <x-input-error :messages="$errors->get('nama_program')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="harga_pelatihan" :value="__('Harga Pelatihan (Rp)')" class="text-hitam font-bold text-sm" />
                                <div class="relative mt-1 rounded-xl shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <span class="text-gray-500 sm:text-sm font-bold">Rp</span>
                                    </div>
                                    <x-text-input id="harga_pelatihan" class="block w-full pl-10 focus:border-oranye focus:ring-oranye rounded-xl transition" type="number" name="harga_pelatihan" :value="old('harga_pelatihan', 0)" min="0" required />
                                </div>
                                <p class="text-[11px] text-gray-500 mt-1.5 font-medium ml-1">Isi 0 jika program ini gratis.</p>
                                <x-input-error :messages="$errors->get('harga_pelatihan')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="durasi_hari" :value="__('Durasi Kelas (Hari Kerja)')" class="text-hitam font-bold text-sm" />
                                <div class="relative mt-1 rounded-xl shadow-sm">
                                    <x-text-input id="durasi_hari" class="block w-full pr-12 focus:border-oranye focus:ring-oranye rounded-xl transition" type="number" name="durasi_hari" :value="old('durasi_hari', 0)" min="1" required />
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4">
                                        <span class="text-gray-500 sm:text-sm font-bold">Hari</span>
                                    </div>
                                </div>
                                <p class="text-[11px] text-gray-500 mt-1.5 font-medium ml-1">Berapa lama kelas akan berlangsung (Contoh: 28).</p>
                                <x-input-error :messages="$errors->get('durasi_hari')" class="mt-2" />
                            </div>
                        </div>

                        <!-- BAGIAN PARAMETER PENILAIAN DENGAN PENJELASAN LENGKAP -->
                        <div class="bg-orange-50 p-6 rounded-2xl border border-orange-200 shadow-sm relative overflow-hidden mt-8">
                            <div class="absolute -right-4 -top-4 opacity-10">
                                <svg class="w-32 h-32 text-oranye" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path></svg>
                            </div>
                            
                            <div class="relative z-10">
                                <x-input-label for="parameter_penilaian" :value="__('Setup Kriteria Penilaian Instruktur')" class="text-oranye font-black text-lg mb-2" />
                                
                                <p class="text-sm text-gray-700 mb-4 font-medium leading-relaxed">
                                    Masukkan daftar kriteria kompetensi yang akan dinilai oleh instruktur pada akhir kelas. Setiap kriteria <strong class="text-hitam bg-orange-100 px-1 rounded">wajib dipisahkan dengan tanda koma ( , )</strong>. Parameter ini akan otomatis menjadi kolom tabel penilaian di akun Instruktur dan dicetak di bagian belakang sertifikat Peserta.
                                </p>
                                
                                <x-text-input id="parameter_penilaian" class="block mt-2 w-full focus:border-oranye focus:ring-oranye rounded-xl border-orange-300 shadow-inner bg-white" type="text" name="parameter_penilaian" :value="old('parameter_penilaian')" placeholder="Ketik kriteria di sini..." required />
                                <x-input-error :messages="$errors->get('parameter_penilaian')" class="mt-2" />

                                <div class="mt-5 bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-orange-100">
                                    <span class="font-bold text-hitam text-xs block mb-3 uppercase tracking-wider">💡 Contoh Pengisian (Copy-Paste jika sesuai):</span>
                                    
                                    <ul class="space-y-3">
                                        <li class="text-sm">
                                            <span class="block font-bold text-gray-800 text-xs mb-1">Pengelasan Dasar:</span>
                                            <code class="text-oranye bg-orange-50 px-2 py-1 rounded border border-orange-100 select-all block break-words">1F, 2F, 3F, K3 Umum, Teori Dasar Las</code>
                                        </li>
                                        <li class="text-sm border-t border-orange-100 pt-3">
                                            <span class="block font-bold text-gray-800 text-xs mb-1">Sertifikasi SMAW / FCAW Lanjut:</span>
                                            <code class="text-oranye bg-orange-50 px-2 py-1 rounded border border-orange-100 select-all block break-words">1G, 2G, 3G, 4G, Visual Test (VT), Penetrant Test (PT)</code>
                                        </li>
                                        <li class="text-sm border-t border-orange-100 pt-3">
                                            <span class="block font-bold text-gray-800 text-xs mb-1">Program Non-Teknik (Bahasa/Sikap):</span>
                                            <code class="text-oranye bg-orange-50 px-2 py-1 rounded border border-orange-100 select-all block break-words">Ujian Tulis, Ujian Lisan, Kedisiplinan, Attitude Kerja</code>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <x-input-label for="deskripsi" :value="__('Deskripsi Program / Silabus Singkat')" class="text-hitam font-bold text-sm" />
                            <textarea id="deskripsi" name="deskripsi" rows="4" class="block mt-1 w-full border-gray-300 rounded-xl shadow-sm focus:border-oranye focus:ring-oranye transition p-3 text-sm placeholder-gray-400" placeholder="Jelaskan secara singkat apa yang akan dipelajari di program ini...">{{ old('deskripsi') }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-10 pt-6 border-t border-gray-100 gap-4">
                            <a href="{{ route('admin.program.index') }}" class="text-gray-500 hover:text-hitam font-bold transition px-4 py-2 rounded-lg hover:bg-gray-100">Batal</a>
                            <button type="submit" class="bg-hitam text-white px-8 py-3.5 rounded-xl hover:bg-oranye transition duration-300 transform hover:-translate-y-1 shadow-lg font-bold flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                Simpan Program Baru
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>