<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BINA MANDIRI WELDING CENTER</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,800,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .animate-fade-in-up {
            animation: fadeInUp 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(30px);
        }

        .animate-fade-in-up.delay-1 {
            animation-delay: 0.2s;
        }

        .animate-fade-in-up.delay-2 {
            animation-delay: 0.4s;
        }

        .animate-fade-in-up.delay-3 {
            animation-delay: 0.6s;
        }

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

    <nav
        class="fixed w-full z-50 transition-all duration-300 bg-hitam/95 backdrop-blur-md border-b border-white/10 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center gap-2 cursor-pointer group">
                    @php
                        $logoNavbar = \App\Models\Pengaturan::where('kunci', 'logo_navbar')->value('nilai');
                        $namaLpk1 = \App\Models\Pengaturan::where('kunci', 'nama_lpk_1')->value('nilai') ?? 'LPK';
                        $namaLpk2 = \App\Models\Pengaturan::where('kunci', 'nama_lpk_2')->value('nilai') ?? 'BINA';
                    @endphp

                    @if($logoNavbar)
                        <img src="{{ asset('storage/' . $logoNavbar) }}" alt="Logo"
                            class="h-10 w-auto group-hover:scale-105 transition transform duration-300">
                    @endif

                    <span
                        class="font-black text-2xl tracking-widest text-white group-hover:text-oranye transition duration-300 {{ $logoNavbar ? 'hidden sm:block' : '' }}">
                        {{ $namaLpk1 }}<span class="text-oranye">{{ $namaLpk2 }}</span>
                    </span>
                </div>

                <div class="hidden md:flex space-x-8">
                    <a href="#tentang"
                        class="text-gray-300 hover:text-oranye font-semibold transition duration-300 text-sm tracking-widest uppercase">Tentang
                        Kami</a>
                    <a href="#program"
                        class="text-gray-300 hover:text-oranye font-semibold transition duration-300 text-sm tracking-widest uppercase">Program</a>
                    <a href="#kualitas"
                        class="text-gray-300 hover:text-oranye font-semibold transition duration-300 text-sm tracking-widest uppercase">Kualitas</a>
                </div>
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="text-white bg-oranye hover:bg-[#c24b22] px-6 py-2 rounded-full font-bold transition transform hover:-translate-y-1 shadow-lg shadow-oranye/30">Dashboard
                                🚀</a>
                        @else
                            <a href="{{ route('login') }}"
                                class="text-white hover:text-oranye font-bold transition duration-300">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="text-hitam bg-white hover:bg-gray-200 px-6 py-2 rounded-full font-bold transition transform hover:-translate-y-1 shadow-lg">Daftar
                                    Pelatihan</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="relative bg-hitam min-h-screen flex items-center justify-center overflow-hidden pt-20">
        <div class="absolute inset-0 bg-pattern"></div>
        <div
            class="absolute top-1/4 -right-20 w-96 h-96 bg-oranye rounded-full mix-blend-screen filter blur-[100px] opacity-30 animate-pulse">
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center mt-10">
            <div
                class="inline-block px-4 py-1.5 rounded-full bg-oranye/20 border border-oranye/30 text-oranye font-bold text-sm tracking-widest uppercase mb-6 animate-fade-in-up">
                Indonesian Welding Training Centre
            </div>
            <h1
                class="text-5xl md:text-7xl font-black text-white leading-tight mb-6 animate-fade-in-up delay-1 tracking-tight">
                {{ $pengaturan['hero_judul'] ?? 'Creating Value For The World.' }}
            </h1>
            <p
                class="mt-4 text-xl text-gray-400 max-w-3xl mx-auto mb-10 animate-fade-in-up delay-2 leading-relaxed whitespace-pre-line">
                {{ $pengaturan['hero_deskripsi'] ?? 'Mewujudkan visi Anda menjadi sumber daya Welder Profesional dunia dengan standar teknologi pengelasan internasional.' }}
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4 animate-fade-in-up delay-3">
                <a href="{{ route('register') }}"
                    class="px-8 py-4 bg-oranye hover:bg-[#c24b22] text-white rounded-full font-extrabold text-lg transition transform hover:scale-105 shadow-[0_0_20px_rgba(222,94,46,0.5)]">
                    Gabung Pelatihan
                </a>
                <a href="#tentang"
                    class="px-8 py-4 bg-transparent border-2 border-gray-500 hover:border-white text-gray-300 hover:text-white rounded-full font-bold text-lg transition">
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </div>

    <div class="relative -mt-16 z-20 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div
            class="glass-card bg-hitam/80 rounded-2xl shadow-2xl p-8 grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-gray-700">
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
                    <h3 class="text-4xl font-black text-hitam mb-6 leading-tight">Mencetak SDM Unggul & Siap Bersaing
                        Global</h3>

                    <div class="text-gray-600 mb-6 text-lg leading-relaxed text-justify whitespace-pre-line">
                        {{ $pengaturan['tentang_deskripsi'] ?? 'BINA MANDIRI adalah lembaga pelatihan yang beroperasi di sektor pengelasan, kelistrikan, dan pengecatan. Berlokasi di Jlamprang, Wonosobo, lembaga ini dipimpin langsung oleh Bapak Doni Khojin.' }}
                    </div>

                    <div class="bg-gray-50 border-l-4 border-oranye p-6 rounded shadow-sm mt-8">
                        <h4 class="font-black text-xl text-hitam mb-2">Visi Kami</h4>
                        <p class="text-gray-700 italic">"Menjadi lembaga pelatihan las serta tempat uji kompetensi
                            unggul di bidang teknologi pengelasan berstandar internasional, agar Indonesia dapat menjadi
                            sumber daya welder profesional di dunia."</p>
                    </div>
                </div>
                <div class="relative">
                    <div
                        class="absolute inset-0 bg-oranye transform translate-x-4 translate-y-4 rounded-2xl opacity-20">
                    </div>
                    <img src="https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                        alt="Welding Training"
                        class="rounded-2xl shadow-xl relative z-10 w-full h-[500px] object-cover grayscale hover:grayscale-0 transition duration-700">
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

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div
                    class="bg-white rounded-2xl shadow-lg border border-gray-100 hover:shadow-2xl transition duration-500 transform hover:-translate-y-2 overflow-hidden group">
                    <div class="h-48 bg-hitam relative flex items-center justify-center overflow-hidden">
                        <div
                            class="absolute inset-0 bg-oranye opacity-20 group-hover:opacity-40 transition duration-500">
                        </div>
                        <h4 class="text-6xl font-black text-white/20 absolute -right-4 -bottom-4">3G</h4>
                        <p class="text-white text-2xl font-black relative z-10">Sertifikasi Plat 3G</p>
                    </div>
                    <div class="p-8">
                        <div class="inline-block px-3 py-1 bg-gray-100 text-hitam text-xs font-bold rounded-full mb-4">
                            Kombinasi</div>
                        <h4 class="text-2xl font-black text-hitam mb-2">Sertifikasi Plat 3G (Kombinasi)</h4>
                        <p class="text-gray-500 mb-6 text-sm">Pelatihan intensif kombinasi untuk memenuhi standar ketat
                            dunia industri global.</p>
                        <ul class="space-y-2 mb-8">
                            <li class="flex items-center text-sm text-gray-700 font-semibold"><svg
                                    class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg> Sertifikat: BNSP</li>
                            <li class="flex items-center text-sm text-gray-700 font-semibold"><svg
                                    class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg> Durasi: 43 Hari</li>
                        </ul>
                    </div>
                </div>

                <div
                    class="bg-white rounded-2xl shadow-lg border border-gray-100 hover:shadow-2xl transition duration-500 transform hover:-translate-y-2 overflow-hidden group">
                    <div class="h-48 bg-hitam relative flex items-center justify-center overflow-hidden">
                        <div
                            class="absolute inset-0 bg-oranye opacity-20 group-hover:opacity-40 transition duration-500">
                        </div>
                        <h4 class="text-5xl font-black text-white/20 absolute -right-4 -bottom-4">GTAW</h4>
                        <p class="text-white text-2xl font-black relative z-10">Gas Tungsten Arc</p>
                    </div>
                    <div class="p-8">
                        <div class="inline-block px-3 py-1 bg-gray-100 text-hitam text-xs font-bold rounded-full mb-4">
                            Advance</div>
                        <h4 class="text-2xl font-black text-hitam mb-2">GTAW (1F - 3G)</h4>
                        <p class="text-gray-500 mb-6 text-sm">Penguasaan pengelasan presisi tingkat tinggi untuk
                            industri manufaktur dan perkapalan.</p>
                        <ul class="space-y-2 mb-8">
                            <li class="flex items-center text-sm text-gray-700 font-semibold"><svg
                                    class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg> Sertifikat: BNSP</li>
                            <li class="flex items-center text-sm text-gray-700 font-semibold"><svg
                                    class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg> Durasi: 32 Hari</li>
                        </ul>
                    </div>
                </div>

                <div
                    class="bg-white rounded-2xl shadow-lg border border-gray-100 hover:shadow-2xl transition duration-500 transform hover:-translate-y-2 overflow-hidden group">
                    <div class="h-48 bg-hitam relative flex items-center justify-center overflow-hidden">
                        <div
                            class="absolute inset-0 bg-oranye opacity-20 group-hover:opacity-40 transition duration-500">
                        </div>
                        <h4 class="text-5xl font-black text-white/20 absolute -right-4 -bottom-4">SMAW</h4>
                        <p class="text-white text-2xl font-black relative z-10">Shielded Metal Arc</p>
                    </div>
                    <div class="p-8">
                        <div class="inline-block px-3 py-1 bg-gray-100 text-hitam text-xs font-bold rounded-full mb-4">
                            Fundamental</div>
                        <h4 class="text-2xl font-black text-hitam mb-2">SMAW (1F - 3G)</h4>
                        <p class="text-gray-500 mb-6 text-sm">Fondasi terbaik untuk calon welder profesional yang
                            mengedepankan efisiensi kerja.</p>
                        <ul class="space-y-2 mb-8">
                            <li class="flex items-center text-sm text-gray-700 font-semibold"><svg
                                    class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg> Sertifikat: BNSP</li>
                            <li class="flex items-center text-sm text-gray-700 font-semibold"><svg
                                    class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg> Durasi: 26 Hari</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('register') }}"
                    class="inline-flex items-center text-oranye font-bold hover:text-hitam transition duration-300">
                    Lihat Program Lainnya (FCAW / GMAW) <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
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
                <p class="mt-6 text-gray-400 max-w-3xl mx-auto">Kami menyediakan tenaga kerja berkualitas dengan sikap
                    kerja yang positif melalui sistem Quality Control yang ketat:</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div
                    class="bg-gray-900 border border-gray-800 p-6 rounded-xl hover:border-oranye transition duration-300">
                    <div class="text-oranye text-4xl mb-4 font-black">01</div>
                    <h4 class="font-bold text-xl mb-2">Seleksi Ketat</h4>
                    <p class="text-sm text-gray-400">Pemeriksaan administrasi mendalam serta penilaian kemampuan teknis
                        dan bahasa.</p>
                </div>
                <div
                    class="bg-gray-900 border border-gray-800 p-6 rounded-xl hover:border-oranye transition duration-300">
                    <div class="text-oranye text-4xl mb-4 font-black">02</div>
                    <h4 class="font-bold text-xl mb-2">Tes Medis & Psikologi</h4>
                    <p class="text-sm text-gray-400">Pengujian oleh pakar profesional menggunakan instrumen modern dari
                        institusi terakreditasi.</p>
                </div>
                <div
                    class="bg-gray-900 border border-gray-800 p-6 rounded-xl hover:border-oranye transition duration-300">
                    <div class="text-oranye text-4xl mb-4 font-black">03</div>
                    <h4 class="font-bold text-xl mb-2">Pelatihan Intensif</h4>
                    <p class="text-sm text-gray-400">Meningkatkan skill teknis dan mengenalkan budaya serta adat
                        istiadat negara tujuan kerja.</p>
                </div>
                <div
                    class="bg-gray-900 border border-gray-800 p-6 rounded-xl hover:border-oranye transition duration-300">
                    <div class="text-oranye text-4xl mb-4 font-black">04</div>
                    <h4 class="font-bold text-xl mb-2">Lab Bahasa Asing</h4>
                    <p class="text-sm text-gray-400">Pelatihan khusus bahasa Inggris, Kanton, Arab, dan Mandarin
                        menyesuaikan negara tujuan.</p>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-gray-100 py-16 border-t border-gray-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-12">
            <div>
                <span class="font-black text-2xl tracking-widest text-hitam mb-4 block">BINA<span
                        class="text-oranye">MANDIRI</span></span>
                <p class="text-sm text-gray-600 mb-6 leading-relaxed">Telah memiliki posisi kuat dan dipertimbangkan
                    sebagai salah satu perusahaan terbaik dalam mengadakan pelatihan pengelasan berstandar K3.</p>
            </div>
            <div>
                <h4 class="text-hitam font-black mb-6 uppercase tracking-widest">Tautan Navigasi</h4>
                <ul class="space-y-3 text-sm font-semibold text-gray-600">
                    <li><a href="#tentang" class="hover:text-oranye transition">Profil Perusahaan</a></li>
                    <li><a href="#program" class="hover:text-oranye transition">Training Center</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-oranye transition">Portal Siswa &
                            Instruktur</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-hitam font-black mb-6 uppercase tracking-widest">Hubungi Kami (Contact Us)</h4>
                <ul class="space-y-4 text-sm text-gray-600">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-oranye mr-3 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span
                            class="whitespace-pre-line">{{ $pengaturan['kontak_alamat'] ?? "Jl. Karya Tralis No. 58 RT 04/RW 03\nJlamprang, Wonosobo, Central Java" }}</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-oranye mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                        <span>{{ $pengaturan['kontak_telepon'] ?? '0812 7889 2727 / 0823 2444 9382' }}</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-oranye mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span>{{ $pengaturan['kontak_email'] ?? 'binamandiricentre@gmail.com' }}</span>
                    </li>
                </ul>
            </div>
        </div>
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 pt-8 border-t border-gray-300 text-center text-sm text-gray-500 font-semibold">
            <p>&copy; {{ date('Y') }} BINA MANDIRI WELDING CENTER. Hak Cipta Dilindungi Undang-Undang.</p>
        </div>
    </footer>

</body>

</html>