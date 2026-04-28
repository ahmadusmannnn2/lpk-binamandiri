<section>
    <header>
        <h2 class="text-lg font-black text-hitam">
            {{ __('Informasi Profil') }}
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            {{ __("Perbarui nama tampilan dan alamat email akun Anda di sini.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="font-bold text-hitam" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full focus:border-oranye focus:ring-oranye" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Alamat Email')" class="font-bold text-hitam" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full focus:border-oranye focus:ring-oranye" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div class="flex items-center gap-4 mt-8">
            <button type="submit" class="bg-hitam text-white px-6 py-2 rounded-lg font-bold shadow-lg hover:bg-oranye transition transform hover:-translate-y-1">
                {{ __('Simpan Perubahan') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm font-bold text-green-600 bg-green-100 px-3 py-1 rounded"
                >{{ __('Berhasil Disimpan.') }}</p>
            @endif
        </div>
    </form>
</section>