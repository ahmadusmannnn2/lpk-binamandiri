<x-guest-layout>
    <div class="animate-[fadeIn_0.8s_ease-out] w-full sm:max-w-md mt-6 px-8 py-10 bg-white shadow-2xl overflow-hidden sm:rounded-2xl border-t-8 border-oranye">
        
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-bold text-hitam mb-2">Selamat Datang</h2>
            <p class="text-sm text-gray-500">Sistem Informasi LPK Bina Mandiri</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div class="relative group">
                <x-input-label for="email" :value="__('Email')" class="text-hitam group-focus-within:text-oranye transition-colors duration-300" />
                <x-text-input id="email" class="block mt-1 w-full focus:ring-oranye focus:border-oranye transition-all duration-300 rounded-lg shadow-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="relative group mt-4">
                <x-input-label for="password" :value="__('Kata Sandi')" class="text-hitam group-focus-within:text-oranye transition-colors duration-300" />
                <x-text-input id="password" class="block mt-1 w-full focus:ring-oranye focus:border-oranye transition-all duration-300 rounded-lg shadow-sm"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-oranye shadow-sm focus:ring-oranye transition duration-150 ease-in-out" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Ingat Saya') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-6">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-oranye rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-oranye transition-colors duration-300" href="{{ route('password.request') }}">
                        {{ __('Lupa sandi?') }}
                    </a>
                @endif

                <button type="submit" class="inline-flex items-center px-6 py-3 bg-oranye border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#c24b22] hover:-translate-y-1 hover:shadow-lg focus:bg-[#c24b22] active:bg-hitam focus:outline-none focus:ring-2 focus:ring-oranye focus:ring-offset-2 transition-all duration-300 ease-in-out transform">
                    {{ __('Masuk') }}
                </button>
            </div>
        </form>
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</x-guest-layout>