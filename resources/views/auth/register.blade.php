<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-black text-hitam">Buat Akun Peserta 🚀</h2>
        <p class="text-sm text-gray-500 mt-2 font-medium">Lengkapi data di bawah untuk mulai belajar.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="font-bold text-hitam" />
            <x-text-input id="name" class="block mt-1 w-full rounded-xl focus:ring-oranye focus:border-oranye transition shadow-sm bg-gray-50/50" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Sesuai KTP/Ijazah..." />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Alamat Email Aktif')" class="font-bold text-hitam" />
            <x-text-input id="email" class="block mt-1 w-full rounded-xl focus:ring-oranye focus:border-oranye transition shadow-sm bg-gray-50/50" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="email@contoh.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div x-data="{ show: false }">
            <x-input-label for="password" :value="__('Kata Sandi')" class="font-bold text-hitam" />
            <div class="relative mt-1">
                <x-text-input id="password" class="block w-full pr-12 rounded-xl focus:ring-oranye focus:border-oranye transition shadow-sm bg-gray-50/50"
                              x-bind:type="show ? 'text' : 'password'" 
                              name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter..." />
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-oranye transition focus:outline-none">
                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>
                    <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div x-data="{ showConf: false }">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" class="font-bold text-hitam" />
            <div class="relative mt-1">
                <x-text-input id="password_confirmation" class="block w-full pr-12 rounded-xl focus:ring-oranye focus:border-oranye transition shadow-sm bg-gray-50/50"
                              x-bind:type="showConf ? 'text' : 'password'" 
                              name="password_confirmation" required autocomplete="new-password" placeholder="Ketik ulang sandi..." />
                <button type="button" @click="showConf = !showConf" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-oranye transition focus:outline-none">
                    <svg x-show="!showConf" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>
                    <svg x-show="showConf" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-8 pt-4">
            <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-sm font-black text-white bg-oranye hover:bg-hitam focus:outline-none transition transform hover:-translate-y-1">
                BUAT AKUN
            </button>
        </div>
        
        <div class="text-center mt-6">
            <p class="text-sm text-gray-600 font-medium">Sudah mendaftar sebelumnya? 
                <a href="{{ route('login') }}" class="font-bold text-oranye hover:text-hitam transition hover:underline">Masuk di sini</a>
            </p>
        </div>
    </form>
</x-guest-layout>