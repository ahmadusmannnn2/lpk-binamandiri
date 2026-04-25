<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-hitam leading-tight">
            {{ __('Dashboard Instruktur LPK Bina Mandiri') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg transition-all duration-500 hover:shadow-lg border-t-4 border-oranye">
                <div class="p-6 text-gray-900">
                    Selamat datang, {{ Auth::user()->name }}! Anda login sebagai <strong>Instruktur</strong>.
                </div>
            </div>
        </div>
    </div>
</x-app-layout>