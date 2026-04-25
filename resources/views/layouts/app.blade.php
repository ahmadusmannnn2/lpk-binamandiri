<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'LPK Bina Mandiri') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

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
        </div>
    </body>
</html>