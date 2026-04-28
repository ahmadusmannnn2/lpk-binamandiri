<section>
    <header>
        <h2 class="text-lg font-black text-oranye">
            {{ __('Perbarui Kata Sandi') }}
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            {{ __('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Kata Sandi Saat Ini')" class="font-bold text-hitam" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full focus:border-oranye focus:ring-oranye" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Kata Sandi Baru')" class="font-bold text-hitam" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full focus:border-oranye focus:ring-oranye" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Sandi Baru')" class="font-bold text-hitam" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full focus:border-oranye focus:ring-oranye" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 mt-8">
            <button type="submit" class="bg-oranye text-white px-6 py-2 rounded-lg font-bold shadow-lg hover:bg-[#c24b22] transition transform hover:-translate-y-1">
                {{ __('Ganti Kata Sandi') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm font-bold text-green-600 bg-green-100 px-3 py-1 rounded"
                >{{ __('Sandi Diperbarui.') }}</p>
            @endif
        </div>
    </form>
</section>