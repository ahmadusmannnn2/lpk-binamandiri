<x-guest-layout>
    <div class="text-center mb-6">
        <div class="mx-auto w-16 h-16 bg-orange-100 text-oranye rounded-full flex items-center justify-center mb-4 shadow-sm border-2 border-white">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path></svg>
        </div>
        <h2 class="text-2xl font-black text-hitam">Lupa Kata Sandi? 🔐</h2>
    </div>

    <div class="mb-6 text-sm text-gray-500 font-medium leading-relaxed text-center bg-gray-50 p-4 rounded-xl border border-gray-100">
        {{ __('Jangan panik! Cukup masukkan alamat email aktif yang Anda gunakan saat mendaftar. Kami akan mengirimkan tautan khusus agar Anda dapat membuat kata sandi baru.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-center font-bold text-green-600 bg-green-50 p-3 rounded-lg border border-green-200" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Alamat Email')" class="font-bold text-hitam" />
            <x-text-input id="email" class="block mt-1 w-full rounded-xl focus:ring-oranye focus:border-oranye transition shadow-sm bg-gray-50/50" type="email" name="email" :value="old('email')" required autofocus placeholder="Masukkan email Anda..." />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-center" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-sm font-black text-white bg-hitam hover:bg-oranye focus:outline-none transition transform hover:-translate-y-1">
                KIRIM TAUTAN RESET SANDI
            </button>
        </div>

        <div class="text-center mt-6">
            <a href="{{ route('login') }}" class="text-sm font-bold text-gray-400 hover:text-hitam transition flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Halaman Login
            </a>
        </div>
    </form>
</x-guest-layout>