<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-hitam leading-tight">
                    {{ __('Pengaturan Konten Website') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Kelola teks, logo, dan informasi kontak yang tampil di halaman depan (Landing Page) secara real-time.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl shadow-sm flex items-center">
                    <svg class="w-6 h-6 text-green-500 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <p class="font-bold text-green-800">Pembaruan Berhasil</p>
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-oranye">
                <form action="{{ route('admin.pengaturan.update') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
                    @csrf
                    @method('PUT')

                    <!-- 1. IDENTITAS & LOGO -->
                    <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 opacity-5 pointer-events-none">
                            <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path></svg>
                        </div>
                        
                        <div class="flex items-center gap-2 mb-6 border-b border-gray-200 pb-3 relative z-10">
                            <svg class="w-6 h-6 text-oranye" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <h3 class="font-black text-xl text-hitam">Identitas Website & Logo</h3>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 relative z-10">
                            <!-- Kolom Logo -->
                            <div class="lg:col-span-1 text-center bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
                                <x-input-label :value="__('Logo Utama Navbar')" class="font-bold text-hitam mb-4" />
                                
                                <div class="bg-hitam/5 p-4 rounded-xl flex items-center justify-center min-h-[120px] mb-4 border-2 border-dashed border-gray-300">
                                    @if(isset($pengaturan['logo_navbar']) && $pengaturan['logo_navbar'])
                                        <img src="{{ asset('storage/' . $pengaturan['logo_navbar']) }}" alt="Logo Website" class="max-h-20 w-auto object-contain drop-shadow-md">
                                    @else
                                        <div class="text-gray-400 flex flex-col items-center">
                                            <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <span class="text-xs font-bold uppercase tracking-wider">Belum Ada Logo</span>
                                        </div>
                                    @endif
                                </div>
                                
                                <input id="logo_navbar" type="file" name="logo_navbar" accept="image/*" class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-oranye file:text-white hover:file:bg-hitam cursor-pointer transition"/>
                                <p class="text-[10px] text-gray-400 mt-2 font-bold uppercase tracking-wider">Format: PNG Transparan (Max 2MB)</p>
                            </div>

                            <!-- Kolom Teks Nama -->
                            <div class="lg:col-span-2 space-y-5">
                                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
                                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">Pengaturan Teks Merek (Brand)</p>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <x-input-label for="nama_lpk_1" :value="__('Teks Logo Awal (Putih/Hitam)')" class="font-bold text-hitam text-sm" />
                                            <x-text-input id="nama_lpk_1" class="block mt-1 w-full rounded-xl focus:ring-oranye focus:border-oranye transition shadow-sm" type="text" name="nama_lpk_1" value="{{ $pengaturan['nama_lpk_1'] ?? 'LPK' }}" placeholder="Contoh: LPK" required />
                                        </div>
                                        <div>
                                            <x-input-label for="nama_lpk_2" :value="__('Teks Logo Akhir (Oranye)')" class="font-bold text-hitam text-sm" />
                                            <x-text-input id="nama_lpk_2" class="block mt-1 w-full rounded-xl focus:ring-oranye focus:border-oranye transition shadow-sm" type="text" name="nama_lpk_2" value="{{ $pengaturan['nama_lpk_2'] ?? 'BINA MANDIRI' }}" placeholder="Contoh: BINA MANDIRI" required />
                                        </div>
                                    </div>
                                    <p class="text-[11px] text-gray-400 mt-3 font-medium">Teks ini akan ditampilkan di sebelah logo pada Navbar dan judul tab browser.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. HERO BANNER & TENTANG KAMI -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        
                        <!-- Kiri: Hero Banner -->
                        <div class="bg-orange-50 p-6 rounded-2xl border border-orange-100 relative overflow-hidden">
                            <div class="flex items-center gap-2 mb-6 border-b border-orange-200 pb-3 relative z-10">
                                <svg class="w-6 h-6 text-oranye" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
                                <h3 class="font-black text-xl text-oranye">Banner Utama (Hero)</h3>
                            </div>
                            
                            <div class="space-y-4 relative z-10">
                                <div>
                                    <x-input-label for="hero_judul" :value="__('Judul Utama (Headline)')" class="font-bold text-hitam text-sm" />
                                    <x-text-input id="hero_judul" class="block mt-1 w-full rounded-xl focus:ring-oranye focus:border-oranye transition shadow-sm border-white" type="text" name="hero_judul" value="{{ $pengaturan['hero_judul'] ?? '' }}" placeholder="Kalimat penarik perhatian..." required />
                                </div>
                                <div>
                                    <x-input-label for="hero_deskripsi" :value="__('Deskripsi Singkat')" class="font-bold text-hitam text-sm" />
                                    <textarea id="hero_deskripsi" name="hero_deskripsi" rows="4" class="block mt-1 w-full border-white rounded-xl shadow-sm focus:border-oranye focus:ring-oranye transition text-sm" placeholder="Jelaskan secara singkat nilai jual LPK..." required>{{ $pengaturan['hero_deskripsi'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Kanan: Tentang Kami -->
                        <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200 relative overflow-hidden">
                            <div class="flex items-center gap-2 mb-6 border-b border-gray-200 pb-3 relative z-10">
                                <svg class="w-6 h-6 text-oranye" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                <h3 class="font-black text-xl text-hitam">Profil Perusahaan</h3>
                            </div>
                            
                            <div class="relative z-10 h-full">
                                <x-input-label for="tentang_deskripsi" :value="__('Teks Tentang Kami')" class="font-bold text-hitam text-sm" />
                                <textarea id="tentang_deskripsi" name="tentang_deskripsi" rows="8" class="block mt-1 w-full border-gray-300 rounded-xl shadow-sm focus:border-oranye focus:ring-oranye transition text-sm leading-relaxed" placeholder="Ceritakan sejarah dan visi misi LPK di sini..." required>{{ $pengaturan['tentang_deskripsi'] ?? '' }}</textarea>
                                <p class="text-[10px] text-gray-400 mt-2 font-bold uppercase tracking-wider">Tips: Gunakan tombol 'Enter' untuk memisahkan antar paragraf.</p>
                            </div>
                        </div>

                    </div>

                    <!-- 3. KONTAK & FOOTER -->
                    <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200 relative overflow-hidden">
                        <div class="flex items-center gap-2 mb-6 border-b border-gray-200 pb-3 relative z-10">
                            <svg class="w-6 h-6 text-oranye" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <h3 class="font-black text-xl text-hitam">Informasi Kontak & Footer</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 relative z-10">
                            <div>
                                <x-input-label for="kontak_alamat" :value="__('Alamat Lengkap Kantor/Lab')" class="font-bold text-hitam text-sm" />
                                <textarea id="kontak_alamat" name="kontak_alamat" rows="4" class="block mt-1 w-full border-gray-300 rounded-xl shadow-sm focus:border-oranye focus:ring-oranye transition text-sm" placeholder="Jl. Raya Nomor X, Kota..." required>{{ $pengaturan['kontak_alamat'] ?? '' }}</textarea>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="kontak_telepon" :value="__('Nomor Telepon / WhatsApp')" class="font-bold text-hitam text-sm" />
                                    <x-text-input id="kontak_telepon" class="block mt-1 w-full rounded-xl focus:ring-oranye focus:border-oranye transition shadow-sm" type="text" name="kontak_telepon" value="{{ $pengaturan['kontak_telepon'] ?? '' }}" placeholder="0812-xxxx-xxxx" required />
                                </div>
                                <div>
                                    <x-input-label for="kontak_email" :value="__('Alamat Email LPK')" class="font-bold text-hitam text-sm" />
                                    <x-text-input id="kontak_email" class="block mt-1 w-full rounded-xl focus:ring-oranye focus:border-oranye transition shadow-sm" type="email" name="kontak_email" value="{{ $pengaturan['kontak_email'] ?? '' }}" placeholder="info@lpkbina.com" required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-10 pt-6 border-t border-gray-100">
                        <button type="submit" class="bg-hitam text-white hover:bg-oranye px-10 py-3.5 rounded-xl font-black tracking-wide shadow-xl transition duration-300 transform hover:-translate-y-1 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            Simpan Pengaturan Web
                        </button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</x-app-layout>