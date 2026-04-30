<section>
    <header>
        <h2 class="text-xl font-black text-hitam">
            {{ __('Informasi Profil Akun') }}
        </h2>
        <p class="mt-1 text-sm text-gray-500 font-medium">
            {{ __("Perbarui nama, alamat email, dan identitas foto profil akun Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- PENTING: Tambahkan enctype="multipart/form-data" agar bisa kirim gambar -->
    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- UI FOTO PROFIL -->
        <!-- UI FOTO PROFIL -->
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 mb-6 p-5 bg-gray-50 rounded-2xl border border-gray-200">
            <div class="relative w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-lg shrink-0 bg-gray-200">
                @php
                    // MENGGUNAKAN Auth::user() AGAR TIDAK ERROR
                    $currentUser = Auth::user();
                    $currentAvatar = 'https://ui-avatars.com/api/?name='.urlencode($currentUser->name).'&color=FFFFFF&background=de5e2e';
                    
                    if ($currentUser->avatar) {
                        $currentAvatar = asset('storage/' . $currentUser->avatar);
                    } elseif ($currentUser->role === 'peserta' && $currentUser->peserta?->pas_foto) {
                        $currentAvatar = asset('storage/' . $currentUser->peserta->pas_foto);
                    } elseif ($currentUser->role === 'instruktur' && $currentUser->instruktur?->foto) {
                        $currentAvatar = asset('storage/' . $currentUser->instruktur->foto);
                    }
                @endphp
                <img src="{{ $currentAvatar }}" alt="Avatar" class="w-full h-full object-cover">
            </div>
            <div class="w-full text-center sm:text-left">
                <x-input-label for="avatar" :value="__('Ubah Foto Profil (Opsional)')" class="font-bold text-hitam mb-2" />
                <input id="avatar" name="avatar" type="file" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-xs file:font-black file:uppercase file:tracking-wider file:bg-hitam file:text-white hover:file:bg-oranye transition duration-300 cursor-pointer shadow-sm">
                <p class="text-[10px] text-gray-400 mt-2 font-bold uppercase tracking-wider">Format: JPG, PNG, GIF (Maks: 2MB)</p>
                <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
            </div>
        </div>

        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="font-bold text-hitam" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full rounded-xl focus:border-oranye focus:ring-oranye shadow-sm" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Alamat Email')" class="font-bold text-hitam" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full rounded-xl focus:border-oranye focus:ring-oranye shadow-sm" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Alamat email Anda belum diverifikasi.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
            <button type="submit" class="bg-hitam text-white px-6 py-2.5 rounded-xl font-bold shadow hover:bg-oranye transition duration-300 transform hover:-translate-y-0.5">
                {{ __('Simpan Perubahan') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-sm font-bold text-green-600 bg-green-50 px-3 py-1.5 rounded-lg border border-green-200">
                    {{ __('Tersimpan.') }}
                </p>
            @endif
        </div>
    </form>
</section>