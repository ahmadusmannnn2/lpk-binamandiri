<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @php
            $logoApp = \App\Models\Pengaturan::where('kunci', 'logo_navbar')->value('nilai');
            $faviconUrl = $logoApp ? asset('storage/' . $logoApp) : asset('favicon.ico');
            $namaLpk1 = \App\Models\Pengaturan::where('kunci', 'nama_lpk_1')->value('nilai') ?? 'LPK';
            $namaLpk2 = \App\Models\Pengaturan::where('kunci', 'nama_lpk_2')->value('nilai') ?? 'BINA MANDIRI';
            $appName = $namaLpk1 . ' ' . $namaLpk2;

            $routeName = Route::currentRouteName();
            $pageTitle = 'Selamat Datang';
            if ($routeName == 'login') $pageTitle = 'Masuk ke Sistem';
            elseif ($routeName == 'register') $pageTitle = 'Buat Akun Baru';
            elseif ($routeName == 'password.request') $pageTitle = 'Lupa Kata Sandi';
        @endphp

        <title>{{ $pageTitle }} | {{ $appName }}</title>
        <link rel="icon" href="{{ $faviconUrl }}" type="image/png">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-100 relative overflow-x-hidden selection:bg-oranye selection:text-white">
        
        <div class="fixed top-[-10%] left-[-10%] w-96 h-96 bg-oranye/20 rounded-full mix-blend-multiply filter blur-3xl opacity-70 pointer-events-none"></div>
        <div class="fixed bottom-[-10%] right-[-10%] w-96 h-96 bg-blue-400/20 rounded-full mix-blend-multiply filter blur-3xl opacity-70 pointer-events-none"></div>

        <div class="min-h-screen flex flex-col justify-center items-center py-10 relative z-10 px-4">
            
            <div class="mb-8 text-center transform transition duration-500 hover:scale-105">
                <a href="/" class="inline-flex flex-col items-center gap-3">
                    @if($logoApp)
                        <img src="{{ asset('storage/' . $logoApp) }}" alt="Logo" class="h-20 w-auto drop-shadow-xl">
                    @endif
                    <h1 class="text-3xl font-black text-hitam tracking-widest uppercase shadow-sm">
                        {{ $namaLpk1 }}<span class="text-oranye">{{ $namaLpk2 }}</span>
                    </h1>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-8 py-10 bg-white/80 backdrop-blur-xl shadow-[0_20px_50px_-12px_rgba(0,0,0,0.1)] border border-white rounded-3xl">
                {{ $slot }}
            </div>
            
            <p class="mt-8 text-xs text-gray-500 font-bold uppercase tracking-widest text-center">
                &copy; {{ date('Y') }} {{ $appName }}. Hak Cipta Dilindungi.
            </p>
        </div>
    </body>
</html>