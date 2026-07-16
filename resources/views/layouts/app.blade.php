<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @php
            // 1. Logika Favicon Dinamis (Anti-Cache Cerdas)
            $pengaturanLogo = \App\Models\Pengaturan::where('kunci', 'logo_navbar')->first();
            $logoApp = $pengaturanLogo ? $pengaturanLogo->nilai : null;
            $faviconUrl = $logoApp ? asset('storage/' . $logoApp) . '?v=' . ($pengaturanLogo->updated_at ? $pengaturanLogo->updated_at->timestamp : '1') : asset('favicon.ico');

            // 2. Logika Nama LPK
            $namaLpk1 = \App\Models\Pengaturan::where('kunci', 'nama_lpk_1')->value('nilai') ?? 'LPK';
            $namaLpk2 = \App\Models\Pengaturan::where('kunci', 'nama_lpk_2')->value('nilai') ?? 'BINA MANDIRI';
            $appName = $namaLpk1 . ' ' . $namaLpk2;

            // 3. Logika Title Dinamis Berdasarkan Route
            $routeName = Route::currentRouteName(); // Contoh: admin.instruktur.index
            $pageTitle = 'Dashboard';
            
            if ($routeName) {
                $parts = explode('.', $routeName);
                // Jika route punya minimal 2 bagian (contoh: admin dan instruktur)
                if (count($parts) >= 2) {
                    $menu = ucfirst($parts[1]); // Mengambil kata "Instruktur"
                    $action = $parts[2] ?? '';  // Mengambil kata "index / create / edit"
                    
                    if ($action == 'index') $pageTitle = 'Kelola Data ' . $menu;
                    elseif ($action == 'create') $pageTitle = 'Tambah ' . $menu;
                    elseif ($action == 'edit') $pageTitle = 'Edit ' . $menu;
                    elseif ($action == 'show') $pageTitle = 'Detail ' . $menu;
                    else $pageTitle = $menu;
                }
            }
        @endphp

        <!-- TITTLE & FAVICON DINAMIS -->
        <title>{{ $pageTitle }} | {{ $appName }}</title>
        <link rel="icon" href="{{ $faviconUrl }}">
        <link rel="shortcut icon" href="{{ $faviconUrl }}">
        <link rel="apple-touch-icon" href="{{ $faviconUrl }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-hitam bg-gray-50">
        <div class="min-h-screen bg-gray-50">
            
            @if(auth()->user()->role === 'admin')
                @include('layouts.navigation-admin')
            @elseif(auth()->user()->role === 'instruktur')
                @include('layouts.navigation-instruktur')
            @else
                @include('layouts.navigation-peserta')
            @endif

            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="transition-all duration-300 ease-in-out">
                {{ $slot }}
            </main>

            @if(auth()->user()->role === 'peserta')
                <x-floating-chat />
            @endif
        </div>

        @stack('scripts')
    </body>
</html>