<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ url()->previous() }}" class="text-gray-500 hover:text-oranye transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-2xl text-hitam leading-tight">
                {{ __('Edit Data Kelas / Angkatan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-oranye">
                <div class="p-8 text-gray-900">
                    <form action="{{ route('admin.kelas.update', $kelas->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            
                            <!-- KIRI: INFORMASI DASAR KELAS -->
                            <div class="space-y-5 bg-gray-50 p-6 rounded-2xl border border-gray-200 shadow-sm relative overflow-hidden">
                                <div class="absolute -right-4 -top-4 opacity-5 pointer-events-none">
                                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                </div>

                                <h3 class="font-black text-xl border-b border-gray-200 pb-3 text-hitam">Informasi Dasar</h3>
                                
                                <div class="relative z-10">
                                    <x-input-label for="nama_kelas" :value="__('Nama Kelas / Angkatan')" class="text-hitam font-bold text-sm" />
                                    <x-text-input id="nama_kelas" class="block mt-1 w-full focus:ring-oranye focus:border-oranye rounded-xl transition shadow-sm" type="text" name="nama_kelas" value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required />
                                </div>
                                <div class="relative z-10">
                                    <x-input-label for="program_pelatihan_id" :value="__('Ubah Program Pelatihan')" class="text-hitam font-bold text-sm" />
                                    <select name="program_pelatihan_id" id="program_pelatihan_id" class="block mt-1 w-full border-gray-300 rounded-xl shadow-sm focus:border-oranye focus:ring-oranye transition" required>
                                        @foreach($program as $prog)
                                            <option value="{{ $prog->id }}" {{ $kelas->program_pelatihan_id == $prog->id ? 'selected' : '' }}>{{ $prog->nama_program }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="relative z-10">
                                    <x-input-label for="instruktur_id" :value="__('Ubah Instruktur')" class="text-hitam font-bold text-sm" />
                                    <select name="instruktur_id" id="instruktur_id" class="block mt-1 w-full border-gray-300 rounded-xl shadow-sm focus:border-oranye focus:ring-oranye transition" required>
                                        @foreach($instruktur as $ins)
                                            <option value="{{ $ins->id }}" {{ $kelas->instruktur_id == $ins->id ? 'selected' : '' }}>{{ $ins->user->name ?? 'Terhapus' }} ({{ $ins->spesialisasi_las ?? 'Umum' }})</option>
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
                                        <x-text-input id="kuota_peserta" class="block w-full pr-16 focus:ring-oranye focus:border-oranye rounded-xl transition border-white" type="number" name="kuota_peserta" value="{{ old('kuota_peserta', $kelas->kuota_peserta) }}" min="1" required />
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4">
                                            <span class="text-gray-500 sm:text-sm font-bold">Orang</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="relative z-10 bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-orange-200 shadow-sm mt-2">
                                    <x-input-label for="tanggal_mulai" :value="__('Tanggal Mulai Kelas')" class="text-hitam font-bold text-sm" />
                                    <x-text-input id="tanggal_mulai" class="block mt-1 w-full focus:ring-oranye focus:border-oranye rounded-lg transition text-sm" type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $kelas->tanggal_mulai) }}" required />
                                    
                                    <div class="mt-3 flex items-start gap-2 text-[11px] text-oranye font-bold bg-orange-100/50 p-2 rounded">
                                        <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                        <p class="leading-tight">Perhatian: Jika Anda mengubah tanggal mulai, sistem akan langsung menghitung ulang Tanggal Selesai secara otomatis. <br><span class="text-gray-600 mt-1 block">Tanggal Selesai saat ini: <strong>{{ \Carbon\Carbon::parse($kelas->tanggal_selesai)->format('d F Y') }}</strong></span></p>
                                    </div>
                                </div>
                                
                                <div class="mt-3 p-3 bg-orange-100/50 rounded-lg text-[11px] text-oranye font-bold flex items-start gap-2">
                                    <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p>Status kelas ditentukan <strong>otomatis</strong> dari tanggal. Ubah tanggal mulai untuk mengubah status kelas.</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-10 pt-6 border-t border-gray-100 gap-4">
                            <a href="{{ route('admin.kelas.index') }}" class="text-gray-500 hover:text-hitam font-bold transition px-4 py-2 rounded-lg hover:bg-gray-100">Batal</a>
                            <button type="submit" class="bg-hitam text-white px-8 py-3.5 rounded-xl hover:bg-oranye transition duration-300 transform hover:-translate-y-1 shadow-lg font-bold flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                Perbarui Data Kelas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>