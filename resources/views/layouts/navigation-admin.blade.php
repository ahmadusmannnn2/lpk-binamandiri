@php
    // Logika Cerdas Foto Profil
    $avatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=FFFFFF&background=de5e2e';
    
    // PRIORITAS 1: Avatar kustom dari Profile (Fitur Baru)
    if (Auth::user()->avatar) {
        $avatarUrl = asset('storage/' . Auth::user()->avatar);
    } 
    // PRIORITAS 2: Pas foto saat pendaftaran (Peserta)
    elseif (Auth::user()->role === 'peserta' && Auth::user()->peserta && Auth::user()->peserta->pas_foto) {
        $avatarUrl = asset('storage/' . Auth::user()->peserta->pas_foto);
    } 
    // PRIORITAS 3: Foto profil bawaan Instruktur
    elseif (Auth::user()->role === 'instruktur' && Auth::user()->instruktur && Auth::user()->instruktur->foto) {
        $avatarUrl = asset('storage/' . Auth::user()->instruktur->foto);
    }
    
    // Logika Menu Aktif
    $isMasterActive = request()->routeIs('admin.program.*') || request()->routeIs('admin.instruktur.*') || request()->routeIs('admin.peserta.*') || request()->routeIs('admin.kelas.*');
    $isAkademikActive = request()->routeIs('admin.nilai.*') || request()->routeIs('admin.sertifikat.*');
@endphp

<div x-data="{ sidebarOpen: false }">

    <!-- UBAH KE FIXED & W-FULL AGAR SELALU MENEMPEL DI ATAS -->
    <nav class="fixed top-0 inset-x-0 w-full z-40 bg-hitam/80 backdrop-blur-lg border-b border-oranye/50 shadow-lg transition-all duration-300">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <div class="flex items-center gap-5">
                    <button @click="sidebarOpen = true" class="text-white hover:text-oranye focus:outline-none transition transform hover:scale-110 bg-white/5 hover:bg-white/10 p-2.5 rounded-xl shadow-sm border border-white/10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                        @php
                            $logoNavbar = \App\Models\Pengaturan::where('kunci', 'logo_navbar')->value('nilai');
                            $namaLpk1 = \App\Models\Pengaturan::where('kunci', 'nama_lpk_1')->value('nilai') ?? 'LPK';
                            $namaLpk2 = \App\Models\Pengaturan::where('kunci', 'nama_lpk_2')->value('nilai') ?? 'BINA';
                        @endphp
                        
                        @if($logoNavbar)
                            <img src="{{ asset('storage/' . $logoNavbar) }}" alt="Logo" class="h-10 w-auto group-hover:scale-105 transition transform duration-300 drop-shadow-md">
                        @endif
                        
                        <h1 class="text-2xl font-black text-white tracking-widest group-hover:text-oranye transition duration-300 {{ $logoNavbar ? 'hidden sm:block' : '' }}">
                            {{ $namaLpk1 }}<span class="text-oranye">{{ $namaLpk2 }}</span>
                        </h1>
                    </a>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 group cursor-pointer p-1.5 rounded-full hover:bg-white/5 transition duration-300 border border-transparent hover:border-gray-700">
                        <div class="hidden md:block text-right">
                            <div class="text-sm font-bold text-white group-hover:text-oranye transition duration-300">{{ Auth::user()->name }}</div>
                            <div class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">Administrator</div>
                        </div>
                        <div class="relative">
                            <img src="{{ $avatarUrl }}" alt="Profil" class="w-10 h-10 rounded-full object-cover border-2 border-gray-600 group-hover:border-oranye transition duration-300 shadow-md">
                            <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-hitam rounded-full"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- SPACER: Ganjalan setinggi navbar (h-20) agar konten di bawahnya tidak tertutup -->
    <div class="h-20"></div>

    <!-- Sisa Sidebar (Tidak Berubah) -->
    <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 bg-black/80 z-50 backdrop-blur-sm" @click="sidebarOpen = false" style="display: none;"></div>

    <aside class="fixed inset-y-0 left-0 w-72 bg-hitam border-r border-gray-800 z-[60] transform transition-transform duration-300 ease-in-out shadow-2xl flex flex-col"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
        
        <div class="h-20 flex items-center justify-between px-6 border-b border-gray-800 bg-hitam">
            <span class="text-white font-black tracking-widest text-lg">MENU <span class="text-oranye">NAVIGASI</span></span>
            <button @click="sidebarOpen = false" class="text-gray-300 hover:text-oranye transition transform hover:rotate-90 duration-300 bg-gray-900 p-2 rounded-lg border border-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto py-4 space-y-1 no-scrollbar bg-hitam">
            
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-4 transition duration-200 border-l-4 {{ request()->routeIs('admin.dashboard') ? 'border-oranye text-oranye bg-gray-900' : 'border-transparent text-gray-200 hover:text-oranye hover:bg-gray-900' }}">
                <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span class="font-bold">Dashboard Utama</span>
            </a>

            <!-- DATA MASTER -->
            <div x-data="{ masterOpen: {{ $isMasterActive ? 'true' : 'false' }} }">
                <button @click="masterOpen = !masterOpen" class="w-full flex items-center justify-between px-6 py-4 transition duration-200 border-l-4 {{ $isMasterActive ? 'border-oranye text-oranye bg-gray-900' : 'border-transparent text-gray-200 hover:text-oranye hover:bg-gray-900' }}">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                        <span class="font-bold">Data Master</span>
                    </div>
                    <svg :class="{'rotate-180 text-oranye': masterOpen}" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                
                <div x-show="masterOpen" x-collapse class="bg-[#0a0a0a] py-2 border-y border-gray-800" style="display: {{ $isMasterActive ? 'block' : 'none' }};">
                    <a href="{{ route('admin.program.index') }}" class="flex items-center pl-16 pr-6 py-3 text-sm transition {{ request()->routeIs('admin.program.*') ? 'text-oranye font-bold' : 'text-gray-300 hover:text-white hover:bg-gray-900' }}">
                        <div class="w-1.5 h-1.5 rounded-full mr-3 {{ request()->routeIs('admin.program.*') ? 'bg-oranye shadow-[0_0_8px_rgba(222,94,46,0.8)]' : 'bg-gray-600' }}"></div> Program Pelatihan
                    </a>
                    <a href="{{ route('admin.instruktur.index') }}" class="flex items-center pl-16 pr-6 py-3 text-sm transition {{ request()->routeIs('admin.instruktur.*') ? 'text-oranye font-bold' : 'text-gray-300 hover:text-white hover:bg-gray-900' }}">
                        <div class="w-1.5 h-1.5 rounded-full mr-3 {{ request()->routeIs('admin.instruktur.*') ? 'bg-oranye shadow-[0_0_8px_rgba(222,94,46,0.8)]' : 'bg-gray-600' }}"></div> Instruktur
                    </a>
                    <a href="{{ route('admin.peserta.index') }}" class="flex items-center pl-16 pr-6 py-3 text-sm transition {{ request()->routeIs('admin.peserta.*') ? 'text-oranye font-bold' : 'text-gray-300 hover:text-white hover:bg-gray-900' }}">
                        <div class="w-1.5 h-1.5 rounded-full mr-3 {{ request()->routeIs('admin.peserta.*') ? 'bg-oranye shadow-[0_0_8px_rgba(222,94,46,0.8)]' : 'bg-gray-600' }}"></div> Peserta LPK
                    </a>
                    <a href="{{ route('admin.kelas.index') }}" class="flex items-center pl-16 pr-6 py-3 text-sm transition {{ request()->routeIs('admin.kelas.*') ? 'text-oranye font-bold' : 'text-gray-300 hover:text-white hover:bg-gray-900' }}">
                        <div class="w-1.5 h-1.5 rounded-full mr-3 {{ request()->routeIs('admin.kelas.*') ? 'bg-oranye shadow-[0_0_8px_rgba(222,94,46,0.8)]' : 'bg-gray-600' }}"></div> Kelola Kelas
                    </a>
                </div>
            </div>

            <!-- MENU VERIFIKASI -->
            <a href="{{ route('admin.verifikasi.index') }}" class="flex items-center px-6 py-4 transition duration-200 border-l-4 {{ request()->routeIs('admin.verifikasi.*') ? 'border-oranye text-oranye bg-gray-900' : 'border-transparent text-gray-200 hover:text-oranye hover:bg-gray-900' }}">
                <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-bold">Verifikasi Pendaftar</span>
            </a>

            <!-- AKADEMIK & KELULUSAN -->
            <div x-data="{ akademikOpen: {{ $isAkademikActive ? 'true' : 'false' }} }">
                <button @click="akademikOpen = !akademikOpen" class="w-full flex items-center justify-between px-6 py-4 transition duration-200 border-l-4 {{ $isAkademikActive ? 'border-oranye text-oranye bg-gray-900' : 'border-transparent text-gray-200 hover:text-oranye hover:bg-gray-900' }}">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <span class="font-bold">Akademik & Lulusan</span>
                    </div>
                    <svg :class="{'rotate-180 text-oranye': akademikOpen}" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                
                <div x-show="akademikOpen" x-collapse class="bg-[#0a0a0a] py-2 border-y border-gray-800" style="display: {{ $isAkademikActive ? 'block' : 'none' }};">
                    <a href="{{ route('admin.nilai.index') }}" class="flex items-center pl-16 pr-6 py-3 text-sm transition {{ request()->routeIs('admin.nilai.*') ? 'text-oranye font-bold' : 'text-gray-300 hover:text-white hover:bg-gray-900' }}">
                        <div class="w-1.5 h-1.5 rounded-full mr-3 {{ request()->routeIs('admin.nilai.*') ? 'bg-oranye shadow-[0_0_8px_rgba(222,94,46,0.8)]' : 'bg-gray-600' }}"></div> Rekap Nilai Peserta
                    </a>
                    <a href="{{ route('admin.sertifikat.index') }}" class="flex items-center pl-16 pr-6 py-3 text-sm transition {{ request()->routeIs('admin.sertifikat.*') ? 'text-oranye font-bold' : 'text-gray-300 hover:text-white hover:bg-gray-900' }}">
                        <div class="w-1.5 h-1.5 rounded-full mr-3 {{ request()->routeIs('admin.sertifikat.*') ? 'bg-oranye shadow-[0_0_8px_rgba(222,94,46,0.8)]' : 'bg-gray-600' }}"></div> Cetak Sertifikat
                    </a>
                </div>
            </div>

            <!-- LAPORAN & PENGATURAN -->
            <a href="{{ route('admin.laporan.index') }}" class="flex items-center px-6 py-4 transition duration-200 border-l-4 {{ request()->routeIs('admin.laporan.*') ? 'border-oranye text-oranye bg-gray-900' : 'border-transparent text-gray-200 hover:text-oranye hover:bg-gray-900' }}">
                <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span class="font-bold">Laporan & Rekap</span>
            </a>

            <a href="{{ route('admin.pengaturan.index') }}" class="flex items-center px-6 py-4 transition duration-200 border-l-4 {{ request()->routeIs('admin.pengaturan.*') ? 'border-oranye text-oranye bg-gray-900' : 'border-transparent text-gray-200 hover:text-oranye hover:bg-gray-900' }}">
                <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span class="font-bold">Pengaturan Web</span>
            </a>

            <a href="{{ route('profile.edit') }}" class="flex items-center px-6 py-4 transition duration-200 border-l-4 {{ request()->routeIs('profile.edit') ? 'border-oranye text-oranye bg-gray-900' : 'border-transparent text-gray-200 hover:text-oranye hover:bg-gray-900' }}">
                <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <span class="font-bold">Profil Akun</span>
            </a>
            
        </div>

        <div class="px-6 py-5 border-t border-gray-800 bg-[#0a0a0a]">
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin keluar dari sistem keamanan LPK Bina Mandiri?');" 
                        class="w-full flex items-center justify-center px-4 py-3 transition duration-300 rounded-lg text-red-500 hover:text-white hover:bg-red-600 border border-red-500/30 hover:border-red-600 group font-bold shadow-sm">
                    <svg class="w-5 h-5 mr-3 group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013-3v1"></path></svg>
                    <span>Keluar Sistem</span>
                </button>
            </form>
        </div>

    </aside>

</div>