<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-8">
        <h2 class="text-2xl font-black text-hitam">Selamat Datang Kembali 👋</h2>
        <p class="text-sm text-gray-500 mt-2 font-medium">Masuk untuk melanjutkan ke portal pelatihan Anda.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Alamat Email')" class="font-bold text-hitam" />
            <x-text-input id="email" class="block mt-1 w-full rounded-xl focus:ring-oranye focus:border-oranye transition shadow-sm bg-gray-50/50" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Masukkan email terdaftar..." />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password dengan Fitur Toggle -->
        <div x-data="{ show: false }">
            <div class="flex justify-between items-end">
                <x-input-label for="password" :value="__('Kata Sandi')" class="font-bold text-hitam" />
                @if (Route::has('password.request'))
                    <a class="text-xs font-bold text-oranye hover:text-[#c24b22] transition rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-oranye" href="{{ route('password.request') }}">
                        {{ __('Lupa Sandi?') }}
                    </a>
                @endif
            </div>
            
            <div class="relative mt-1">
                <x-text-input id="password" class="block w-full pr-12 rounded-xl focus:ring-oranye focus:border-oranye transition shadow-sm bg-gray-50/50" 
                              x-bind:type="show ? 'text' : 'password'" 
                              name="password" required autocomplete="current-password" placeholder="••••••••" />
                
                <!-- Tombol Mata -->
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-oranye focus:outline-none transition">
                    <!-- Eye Closed (Password Hidden) -->
                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>
                    <!-- Eye Open (Password Visible) -->
                    <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-oranye shadow-sm focus:ring-oranye group-hover:border-oranye transition cursor-pointer" name="remember">
                <span class="ml-2 text-sm text-gray-600 font-medium group-hover:text-hitam transition">{{ __('Ingat Saya') }}</span>
            </label>
        </div>

        <div class="mt-8 pt-4">
            <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-sm font-black text-white bg-hitam hover:bg-oranye focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-oranye transition transform hover:-translate-y-1">
                MASUK SEKARANG
            </button>
        </div>
        
        <div class="text-center mt-6">
            <p class="text-sm text-gray-600 font-medium">Belum punya akun? 
                <a href="{{ route('register') }}" class="font-bold text-oranye hover:text-hitam transition hover:underline">Daftar di sini</a>
            </p>
        </div>
    </form>
</x-guest-layout>