<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ url()->previous() }}" class="text-gray-500 hover:text-oranye transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-2xl text-hitam leading-tight">
                {{ __('Buat Kelas / Angkatan Baru') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-oranye">
                <div class="p-8 text-gray-900">
                    <form action="{{ route('admin.kelas.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            
                            <!-- KIRI: INFORMASI DASAR KELAS -->
                            <div class="space-y-5 bg-gray-50 p-6 rounded-2xl border border-gray-200 shadow-sm relative overflow-hidden">
                                <div class="absolute -right-4 -top-4 opacity-5 pointer-events-none">
                                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                </div>

                                <h3 class="font-black text-xl border-b border-gray-200 pb-3 text-hitam">Informasi Dasar</h3>
                                
                                <div class="relative z-10">
                                    <x-input-label for="nama_kelas" :value="__('Nama Kelas / Angkatan')" class="text-hitam font-bold text-sm" />
                                    <x-text-input id="nama_kelas" class="block mt-1 w-full focus:ring-oranye focus:border-oranye rounded-xl transition shadow-sm" type="text" name="nama_kelas" :value="old('nama_kelas')" placeholder="Misal: Angkatan 1 - Pagi" required autofocus />
                                </div>
                                <div class="relative z-10">
                                    <x-input-label for="program_pelatihan_id" :value="__('Pilih Program Pelatihan')" class="text-hitam font-bold text-sm" />
                                    <select name="program_pelatihan_id" id="program_pelatihan_id" class="block mt-1 w-full border-gray-300 rounded-xl shadow-sm focus:border-oranye focus:ring-oranye transition" required>
                                        <option value="">-- Pilih Program Pelatihan --</option>
                                        @foreach($program as $prog)
                                            <option value="{{ $prog->id }}">{{ $prog->nama_program }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="relative z-10">
                                    <x-input-label for="instruktur_id" :value="__('Tugaskan Instruktur')" class="text-hitam font-bold text-sm" />
                                    <select name="instruktur_id" id="instruktur_id" class="block mt-1 w-full border-gray-300 rounded-xl shadow-sm focus:border-oranye focus:ring-oranye transition" required>
                                        <option value="">-- Pilih Instruktur Pengajar --</option>
                                        @foreach($instruktur as $ins)
                                            <option value="{{ $ins->id }}">{{ $ins->user->name ?? 'Terhapus' }} ({{ $ins->spesialisasi_las ?? 'Umum' }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- KANAN: PENGATURAN JADWAL & KAPASITAS -->
                            <div class="space-y-5 bg-orange-50 p-6 rounded-2xl border border-orange-100 shadow-sm relative overflow-hidden">
                                <div class="absolute -right-4 -top-4 opacity-10 pointer-events-none">
                                    <svg class="w-32 h-32 text-oranye" fill="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>

                                <h3 class="font-black text-xl border-b border-orange-200 pb-3 text-oranye">Jadwal & Kapasitas</h3>
                                
                                <div class="relative z-10">
                                    <x-input-label for="kuota_peserta" :value="__('Kuota Maksimal Peserta')" class="text-hitam font-bold text-sm" />
                                    <div class="relative mt-1 rounded-xl shadow-sm">
                                        <x-text-input id="kuota_peserta" class="block w-full pr-16 focus:ring-oranye focus:border-oranye rounded-xl transition border-white" type="number" name="kuota_peserta" :value="old('kuota_peserta', 20)" min="1" required />
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4">
                                            <span class="text-gray-500 sm:text-sm font-bold">Orang</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="relative z-10 bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-orange-200 shadow-sm mt-2">
                                    <x-input-label for="tanggal_mulai" :value="__('Tanggal Mulai Kelas')" class="text-hitam font-bold text-sm" />
                                    <x-text-input id="tanggal_mulai" class="block mt-1 w-full focus:ring-oranye focus:border-oranye rounded-lg transition text-sm" type="date" name="tanggal_mulai" :value="old('tanggal_mulai')" required />
                                    
                                    <div class="mt-3 flex items-start gap-2 text-[11px] text-oranye font-bold bg-orange-100/50 p-2 rounded">
                                        <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <p class="leading-tight">Tanggal selesai akan otomatis dihitung oleh sistem berdasarkan durasi hari (Senin-Jumat) dari program pelatihan yang dipilih.</p>
                                    </div>
                                </div>
                                
                                <div class="mt-3 p-3 bg-orange-100/50 rounded-lg text-[11px] text-oranye font-bold flex items-start gap-2">
                                    <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p>Status kelas (Akan Datang / Berjalan / Selesai) ditentukan <strong>otomatis</strong> oleh sistem berdasarkan tanggal mulai dan selesai.</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-10 pt-6 border-t border-gray-100 gap-4">
                            <a href="{{ route('admin.kelas.index') }}" class="text-gray-500 hover:text-hitam font-bold transition px-4 py-2 rounded-lg hover:bg-gray-100">Batal</a>
                            <button type="submit" class="bg-hitam text-white px-8 py-3.5 rounded-xl hover:bg-oranye transition duration-300 transform hover:-translate-y-1 shadow-lg font-bold flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                Simpan Kelas Baru
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>