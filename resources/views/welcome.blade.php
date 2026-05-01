<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    @php
        // Logika Favicon & Nama LPK Dinamis
        $logoApp = \App\Models\Pengaturan::where('kunci', 'logo_navbar')->value('nilai');
        $faviconUrl = $logoApp ? asset('storage/' . $logoApp) : asset('favicon.ico');
        
        $namaLpk1 = $pengaturan['nama_lpk_1'] ?? 'LPK';
        $namaLpk2 = $pengaturan['nama_lpk_2'] ?? 'BINA MANDIRI';
        $appName = $namaLpk1 . ' ' . $namaLpk2;
    @endphp

    <title>Beranda | {{ $appName }}</title>
    <link rel="icon" href="{{ $faviconUrl }}" type="image/png">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,800,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .animate-fade-in-up {
            animation: fadeInUp 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(30px);
        }

        .animate-fade-in-up.delay-1 { animation-delay: 0.2s; }
        .animate-fade-in-up.delay-2 { animation-delay: 0.4s; }
        .animate-fade-in-up.delay-3 { animation-delay: 0.6s; }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .bg-pattern {
            background-image: radial-gradient(#de5e2e 1px, transparent 1px);
            background-size: 30px 30px;
            opacity: 0.05;
        }
    </style>
</head>

<body class="antialiased bg-gray-50 text-hitam font-sans selection:bg-oranye selection:text-white">

    <nav class="fixed w-full z-50 transition-all duration-300 bg-hitam/95 backdrop-blur-md border-b border-white/10 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center gap-2 cursor-pointer group">
                    @if($logoApp)
                        <img src="{{ asset('storage/' . $logoApp) }}" alt="Logo" class="h-10 w-auto group-hover:scale-105 transition transform duration-300">
                    @endif
                    <span class="font-black text-2xl tracking-widest text-white group-hover:text-oranye transition duration-300 {{ $logoApp ? 'hidden sm:block' : '' }}">
                        {{ $namaLpk1 }}<span class="text-oranye">{{ $namaLpk2 }}</span>
                    </span>
                </div>

                <div class="hidden md:flex space-x-8">
                    <a href="#tentang" class="text-gray-300 hover:text-oranye font-semibold transition duration-300 text-sm tracking-widest uppercase">Tentang Kami</a>
                    <a href="#program" class="text-gray-300 hover:text-oranye font-semibold transition duration-300 text-sm tracking-widest uppercase">Program</a>
                    <a href="#kualitas" class="text-gray-300 hover:text-oranye font-semibold transition duration-300 text-sm tracking-widest uppercase">Kualitas</a>
                </div>
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-white bg-oranye hover:bg-[#c24b22] px-6 py-2 rounded-full font-bold transition transform hover:-translate-y-1 shadow-lg shadow-oranye/30">Dashboard 🚀</a>
                        @else
                            <a href="{{ route('login') }}" class="text-white hover:text-oranye font-bold transition duration-300">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-hitam bg-white hover:bg-gray-200 px-6 py-2 rounded-full font-bold transition transform hover:-translate-y-1 shadow-lg">Daftar Pelatihan</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="relative bg-hitam min-h-screen flex items-center justify-center overflow-hidden pt-20">
        <div class="absolute inset-0 bg-pattern"></div>
        <div class="absolute top-1/4 -right-20 w-96 h-96 bg-oranye rounded-full mix-blend-screen filter blur-[100px] opacity-30 animate-pulse"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center mt-10">
            <div class="inline-block px-4 py-1.5 rounded-full bg-oranye/20 border border-oranye/30 text-oranye font-bold text-sm tracking-widest uppercase mb-6 animate-fade-in-up">
                Indonesian Welding Training Centre
            </div>
            <h1 class="text-5xl md:text-7xl font-black text-white leading-tight mb-6 animate-fade-in-up delay-1 tracking-tight">
                {{ $pengaturan['hero_judul'] ?? 'Creating Value For The World.' }}
            </h1>
            <p class="mt-4 text-xl text-gray-400 max-w-3xl mx-auto mb-10 animate-fade-in-up delay-2 leading-relaxed whitespace-pre-line">
                {{ $pengaturan['hero_deskripsi'] ?? 'Mewujudkan visi Anda menjadi sumber daya Welder Profesional dunia dengan standar teknologi pengelasan internasional.' }}
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4 animate-fade-in-up delay-3">
                <a href="{{ route('register') }}" class="px-8 py-4 bg-oranye hover:bg-[#c24b22] text-white rounded-full font-extrabold text-lg transition transform hover:scale-105 shadow-[0_0_20px_rgba(222,94,46,0.5)]">
                    Gabung Pelatihan
                </a>
                <a href="#tentang" class="px-8 py-4 bg-transparent border-2 border-gray-500 hover:border-white text-gray-300 hover:text-white rounded-full font-bold text-lg transition">
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </div>

    <div class="relative -mt-16 z-20 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="glass-card bg-hitam/80 rounded-2xl shadow-2xl p-8 grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-gray-700">
            <div>
                <p class="text-4xl font-black text-oranye mb-1">1.000+</p>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Pekerja Dikirim ke Luar Negeri</p>
            </div>
            <div>
                <p class="text-4xl font-black text-oranye mb-1">5 Tahun</p>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Pengalaman Ekspor Tenaga Kerja</p>
            </div>
            <div>
                <p class="text-4xl font-black text-oranye mb-1">K3</p>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Prioritas Keselamatan Kerja</p>
            </div>
            <div>
                <p class="text-4xl font-black text-oranye mb-1">4 Bahasa</p>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Fasilitas Lab Bahasa Asing</p>
            </div>
        </div>
    </div>

    <div id="tentang" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-oranye font-bold tracking-widest uppercase mb-2">Introduction</h2>
                    <h3 class="text-4xl font-black text-hitam mb-6 leading-tight">Mencetak SDM Unggul & Siap Bersaing Global</h3>

                    <div class="text-gray-600 mb-6 text-lg leading-relaxed text-justify whitespace-pre-line">
                        {{ $pengaturan['tentang_deskripsi'] ?? 'BINA MANDIRI adalah lembaga pelatihan yang beroperasi di sektor pengelasan, kelistrikan, dan pengecatan. Berlokasi di Jlamprang, Wonosobo, lembaga ini dipimpin langsung oleh Bapak Doni Khojin.' }}
                    </div>

                    <div class="bg-gray-50 border-l-4 border-oranye p-6 rounded shadow-sm mt-8">
                        <h4 class="font-black text-xl text-hitam mb-2">Visi Kami</h4>
                        <p class="text-gray-700 italic">"Menjadi lembaga pelatihan las serta tempat uji kompetensi unggul di bidang teknologi pengelasan berstandar internasional, agar Indonesia dapat menjadi sumber daya welder profesional di dunia."</p>
                    </div>
                </div>
                <div class="relative">
                    <div class="absolute inset-0 bg-oranye transform translate-x-4 translate-y-4 rounded-2xl opacity-20"></div>
                    <img src="https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Welding Training" class="rounded-2xl shadow-xl relative z-10 w-full h-[500px] object-cover grayscale hover:grayscale-0 transition duration-700">
                </div>
            </div>
        </div>
    </div>

    <div id="program" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-oranye font-bold tracking-widest uppercase mb-2">Training Center</h2>
                <h3 class="text-4xl font-black text-hitam">Program Sertifikasi Kompetensi</h3>
                <div class="w-24 h-1 bg-oranye mx-auto mt-6 rounded-full"></div>
            </div>

            <!-- Menampilkan Program Dinamis dari Database -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($programs as $key => $program)
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 hover:shadow-2xl transition duration-500 transform hover:-translate-y-2 overflow-hidden group flex flex-col">
                        <div class="h-48 bg-hitam relative flex items-center justify-center overflow-hidden shrink-0">
                            <div class="absolute inset-0 bg-oranye opacity-20 group-hover:opacity-40 transition duration-500"></div>
                            <h4 class="text-6xl font-black text-white/10 absolute -right-4 -bottom-4">0{{ $key + 1 }}</h4>
                            <p class="text-white text-2xl font-black relative z-10 text-center px-4">{{ current(explode(' ', $program->nama_program)) }}</p>
                        </div>
                        <div class="p-8 flex flex-col flex-grow">
                            <div class="inline-block px-3 py-1 bg-gray-100 text-hitam text-xs font-bold rounded-full mb-4 self-start">
                                Rp {{ number_format($program->harga_pelatihan, 0, ',', '.') }}
                            </div>
                            <h4 class="text-2xl font-black text-hitam mb-2">{{ $program->nama_program }}</h4>
                            <p class="text-gray-500 mb-6 text-sm flex-grow line-clamp-3">
                                {{ $program->deskripsi ?? 'Pelatihan intensif untuk memenuhi standar ketat dunia industri global.' }}
                            </p>
                            <ul class="space-y-2 mb-8">
                                <li class="flex items-center text-sm text-gray-700 font-semibold">
                                    <svg class="w-5 h-5 text-green-500 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> 
                                    Sertifikat Tersertifikasi
                                </li>
                                <li class="flex items-center text-sm text-gray-700 font-semibold">
                                    <svg class="w-5 h-5 text-green-500 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 
                                    Durasi: {{ $program->durasi_hari }} Hari Pelatihan
                                </li>
                            </ul>
                            <a href="{{ route('register') }}" class="block w-full py-3 text-center rounded-xl bg-hitam text-white font-bold hover:bg-oranye transition duration-300 mt-auto">
                                Daftar Sekarang
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 font-bold text-lg">Program pelatihan sedang diperbarui.</p>
                        <p class="text-gray-400">Silakan kembali beberapa saat lagi.</p>
                    </div>
                @endforelse
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('register') }}" class="inline-flex items-center text-oranye font-bold hover:text-hitam transition duration-300">
                    Lihat Semua Program & Jadwal di Portal Pendaftaran 
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <div id="kualitas" class="py-24 bg-hitam text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-pattern opacity-10"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-oranye font-bold tracking-widest uppercase mb-2">Our Workers</h2>
                <h3 class="text-4xl font-black">Quality Guaranteed</h3>
                <div class="w-24 h-1 bg-oranye mx-auto mt-6 rounded-full"></div>
                <p class="mt-6 text-gray-400 max-w-3xl mx-auto">Kami menyediakan tenaga kerja berkualitas dengan sikap kerja yang positif melalui sistem Quality Control yang ketat:</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-gray-900 border border-gray-800 p-6 rounded-xl hover:border-oranye transition duration-300">
                    <div class="text-oranye text-4xl mb-4 font-black">01</div>
                    <h4 class="font-bold text-xl mb-2">Seleksi Ketat</h4>
                    <p class="text-sm text-gray-400">Pemeriksaan administrasi mendalam serta penilaian kemampuan teknis dan bahasa.</p>
                </div>
                <div class="bg-gray-900 border border-gray-800 p-6 rounded-xl hover:border-oranye transition duration-300">
                    <div class="text-oranye text-4xl mb-4 font-black">02</div>
                    <h4 class="font-bold text-xl mb-2">Tes Medis & Psikologi</h4>
                    <p class="text-sm text-gray-400">Pengujian oleh pakar profesional menggunakan instrumen modern dari institusi terakreditasi.</p>
                </div>
                <div class="bg-gray-900 border border-gray-800 p-6 rounded-xl hover:border-oranye transition duration-300">
                    <div class="text-oranye text-4xl mb-4 font-black">03</div>
                    <h4 class="font-bold text-xl mb-2">Pelatihan Intensif</h4>
                    <p class="text-sm text-gray-400">Meningkatkan skill teknis dan mengenalkan budaya serta adat istiadat negara tujuan kerja.</p>
                </div>
                <div class="bg-gray-900 border border-gray-800 p-6 rounded-xl hover:border-oranye transition duration-300">
                    <div class="text-oranye text-4xl mb-4 font-black">04</div>
                    <h4 class="font-bold text-xl mb-2">Lab Bahasa Asing</h4>
                    <p class="text-sm text-gray-400">Pelatihan khusus bahasa Inggris, Kanton, Arab, dan Mandarin menyesuaikan negara tujuan.</p>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-gray-100 py-16 border-t border-gray-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-12">
            <!-- Kolom 1: Profil & Sosial Media -->
            <div>
                <span class="font-black text-2xl tracking-widest text-hitam mb-4 block">{{ $namaLpk1 }}<span class="text-oranye">{{ $namaLpk2 }}</span></span>
                <p class="text-sm text-gray-600 mb-6 leading-relaxed">Telah memiliki posisi kuat dan dipertimbangkan sebagai salah satu perusahaan terbaik dalam mengadakan pelatihan pengelasan berstandar K3.</p>
                
                <!-- Ikon Sosial Media -->
                <div class="flex items-center space-x-4 mt-6">
                    <!-- Facebook -->
                    <a href="#" target="_blank" class="w-10 h-10 rounded-full bg-white border border-gray-300 flex items-center justify-center text-gray-500 hover:text-white hover:bg-[#1877F2] hover:border-[#1877F2] transition-all duration-300 transform hover:-translate-y-1 shadow-sm">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <!-- Instagram -->
                    <a href="#" target="_blank" class="w-10 h-10 rounded-full bg-white border border-gray-300 flex items-center justify-center text-gray-500 hover:text-white hover:bg-gradient-to-tr hover:from-[#f09433] hover:via-[#e6683c] hover:to-[#bc1888] hover:border-transparent transition-all duration-300 transform hover:-translate-y-1 shadow-sm">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                    <!-- YouTube -->
                    <a href="#" target="_blank" class="w-10 h-10 rounded-full bg-white border border-gray-300 flex items-center justify-center text-gray-500 hover:text-white hover:bg-[#FF0000] hover:border-[#FF0000] transition-all duration-300 transform hover:-translate-y-1 shadow-sm">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                </div>
            </div>

            <!-- Kolom 2: Tautan Navigasi -->
            <div>
                <h4 class="text-hitam font-black mb-6 uppercase tracking-widest">Tautan Navigasi</h4>
                <ul class="space-y-3 text-sm font-semibold text-gray-600">
                    <li><a href="#tentang" class="hover:text-oranye transition duration-300 flex items-center"><span class="mr-2 text-oranye">▹</span> Profil Perusahaan</a></li>
                    <li><a href="#program" class="hover:text-oranye transition duration-300 flex items-center"><span class="mr-2 text-oranye">▹</span> Training Center</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-oranye transition duration-300 flex items-center"><span class="mr-2 text-oranye">▹</span> Portal Siswa & Instruktur</a></li>
                </ul>
            </div>

            <!-- Kolom 3: Kontak Cerdas (Bisa di-klik) -->
            <div>
                <h4 class="text-hitam font-black mb-6 uppercase tracking-widest">Hubungi Kami</h4>
                <ul class="space-y-5 text-sm text-gray-600 font-medium">
                    <!-- Link Google Maps -->
                    <li>
                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($pengaturan['kontak_alamat'] ?? 'Jl. Karya Tralis No. 58 RT 04/RW 03 Jlamprang, Wonosobo, Central Java') }}" target="_blank" class="flex items-start group hover:text-oranye transition duration-300">
                            <svg class="w-5 h-5 text-oranye mr-3 mt-0.5 shrink-0 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="whitespace-pre-line leading-relaxed">{{ $pengaturan['kontak_alamat'] ?? "Jl. Karya Tralis No. 58 RT 04/RW 03\nJlamprang, Wonosobo, Central Java" }}</span>
                        </a>
                    </li>
                    <!-- Link Telepon / WhatsApp -->
                    @php
                        // Memisahkan nomor jika ada lebih dari 1 (misal dipisah dengan /) lalu mengambil angka saja untuk link tel:
                        $rawPhone = $pengaturan['kontak_telepon'] ?? '0812 7889 2727 / 0823 2444 9382';
                        $cleanPhone = preg_replace('/[^0-9\+]/', '', explode('/', $rawPhone)[0]);
                    @endphp
                    <li>
                        <a href="tel:{{ $cleanPhone }}" class="flex items-center group hover:text-oranye transition duration-300">
                            <svg class="w-5 h-5 text-oranye mr-3 shrink-0 group-hover:scale-110 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span>{{ $rawPhone }}</span>
                        </a>
                    </li>
                    <!-- Link Email -->
                    <li>
                        <a href="mailto:{{ $pengaturan['kontak_email'] ?? 'binamandiricentre@gmail.com' }}" class="flex items-center group hover:text-oranye transition duration-300">
                            <svg class="w-5 h-5 text-oranye mr-3 shrink-0 group-hover:scale-110 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span>{{ $pengaturan['kontak_email'] ?? 'binamandiricentre@gmail.com' }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 pt-8 border-t border-gray-300 text-center text-sm text-gray-500 font-semibold">
            <p>&copy; {{ date('Y') }} {{ $appName }}. Hak Cipta Dilindungi Undang-Undang.</p>
        </div>
    </footer>

</body>
</html>