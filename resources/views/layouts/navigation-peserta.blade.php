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
@endphp

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<nav class="sticky top-0 z-50 bg-black/90 backdrop-blur-xl border-b border-oranye shadow-2xl transition-all duration-300">
    <div class="max-w-full mx-auto px-2 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20 gap-2 sm:gap-4">
            
            <div class="shrink-0 flex items-center">
                <a href="{{ route('peserta.dashboard') }}" class="flex items-center gap-3 group">
                    @php
                        $logoNavbar = \App\Models\Pengaturan::where('kunci', 'logo_navbar')->value('nilai');
                        $namaLpk1 = \App\Models\Pengaturan::where('kunci', 'nama_lpk_1')->value('nilai') ?? 'LPK';
                        $namaLpk2 = \App\Models\Pengaturan::where('kunci', 'nama_lpk_2')->value('nilai') ?? 'BINA';
                    @endphp
                    
                    @if($logoNavbar)
                        <img src="{{ asset('storage/' . $logoNavbar) }}" alt="Logo" class="h-8 sm:h-10 w-auto group-hover:scale-105 transition transform duration-300 drop-shadow-lg">
                    @endif
                    
                    <h1 class="text-xl font-black text-white tracking-widest group-hover:text-oranye transition duration-300 hidden lg:block {{ !$logoNavbar ? '!block' : '' }}">
                        {{ $namaLpk1 }}<span class="text-oranye">{{ $namaLpk2 }}</span>
                    </h1>
                </a>
            </div>

            <div class="flex flex-1 justify-center overflow-x-auto no-scrollbar py-2 px-1">
                <div class="flex items-center gap-1 sm:gap-3">
                    
                    <a href="{{ route('peserta.dashboard') }}" 
                       class="group flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('peserta.dashboard') ? 'text-oranye bg-oranye/10 shadow-[inset_0_-3px_0_rgba(222,94,46,1)]' : 'text-gray-200 hover:text-white hover:bg-white/10' }}">
                        <svg class="w-6 h-6 transform group-hover:scale-110 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span class="hidden md:block font-bold text-sm tracking-wide">Dashboard</span>
                    </a>

                    <a href="{{ route('peserta.biodata.index') }}" 
                       class="group flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('peserta.biodata.*') ? 'text-oranye bg-oranye/10 shadow-[inset_0_-3px_0_rgba(222,94,46,1)]' : 'text-gray-200 hover:text-white hover:bg-white/10' }}">
                        <svg class="w-6 h-6 transform group-hover:scale-110 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                        <span class="hidden md:block font-bold text-sm tracking-wide">Biodata</span>
                    </a>

                    <a href="{{ route('peserta.pendaftaran.index') }}" 
                       class="group flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('peserta.pendaftaran.*') ? 'text-oranye bg-oranye/10 shadow-[inset_0_-3px_0_rgba(222,94,46,1)]' : 'text-gray-200 hover:text-white hover:bg-white/10' }}">
                        <svg class="w-6 h-6 transform group-hover:scale-110 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        <span class="hidden md:block font-bold text-sm tracking-wide">Pendaftaran</span>
                    </a>

                    <a href="{{ route('peserta.riwayat.index') }}" 
                       class="group flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('peserta.riwayat.*') ? 'text-oranye bg-oranye/10 shadow-[inset_0_-3px_0_rgba(222,94,46,1)]' : 'text-gray-200 hover:text-white hover:bg-white/10' }}">
                        <svg class="w-6 h-6 transform group-hover:scale-110 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        <span class="hidden md:block font-bold text-sm tracking-wide">Riwayat</span>
                    </a>

                    <a href="{{ route('peserta.riwayat_pembayaran.index') }}" 
                       class="group flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('peserta.riwayat_pembayaran.*') ? 'text-oranye bg-oranye/10 shadow-[inset_0_-3px_0_rgba(222,94,46,1)]' : 'text-gray-200 hover:text-white hover:bg-white/10' }}">
                        <svg class="w-6 h-6 transform group-hover:scale-110 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="hidden md:block font-bold text-sm tracking-wide">Pembayaran</span>
                    </a>

                    <a href="{{ route('peserta.materi.index') }}" 
                       class="group flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('peserta.materi.*') ? 'text-oranye bg-oranye/10 shadow-[inset_0_-3px_0_rgba(222,94,46,1)]' : 'text-gray-200 hover:text-white hover:bg-white/10' }}">
                        <svg class="w-6 h-6 transform group-hover:scale-110 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <span class="hidden md:block font-bold text-sm tracking-wide">Materi</span>
                    </a>

                    <a href="{{ route('peserta.sertifikat.index') }}" 
                       class="group flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('peserta.sertifikat.*') ? 'text-oranye bg-oranye/10 shadow-[inset_0_-3px_0_rgba(222,94,46,1)]' : 'text-gray-200 hover:text-white hover:bg-white/10' }}">
                        <svg class="w-6 h-6 transform group-hover:scale-110 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                        <span class="hidden md:block font-bold text-sm tracking-wide">Sertifikat</span>
                    </a>

                </div>
            </div>

            <div class="shrink-0 flex items-center gap-2 sm:gap-4">
                
                <a href="{{ route('profile.edit') }}" title="Pengaturan Profil" class="relative group cursor-pointer block">
                    <img src="{{ $avatarUrl }}" alt="Profil" class="w-9 h-9 sm:w-10 sm:h-10 rounded-full object-cover border-2 border-transparent group-hover:border-oranye transition duration-300 shadow-xl">
                    <div class="absolute bottom-0 right-0 w-2.5 h-2.5 sm:w-3 sm:h-3 bg-green-500 border-2 border-black rounded-full"></div>
                </a>

                <div class="hidden sm:block w-px h-8 bg-gray-700 mx-1"></div>

                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" title="Keluar dari Sistem" onclick="return confirm('Apakah Anda yakin ingin keluar dari portal pelatihan?');" 
                            class="flex items-center justify-center text-gray-200 hover:text-white bg-transparent hover:bg-red-600/90 p-2 sm:px-3 sm:py-2 rounded-xl transition-all duration-300 group shadow-sm border border-transparent hover:border-red-500">
                        <svg class="w-6 h-6 sm:w-5 sm:h-5 group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span class="hidden lg:block text-sm font-bold ml-2">Keluar</span>
                    </button>
                </form>

            </div>
            
        </div>
    </div>
</nav>
