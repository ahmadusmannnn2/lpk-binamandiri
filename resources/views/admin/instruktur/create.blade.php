<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">
            {{ __('Tambah Instruktur & Akun Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-oranye">
                <div class="p-8 text-gray-900">
                    <form action="{{ route('admin.instruktur.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4 bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <h3 class="font-bold text-lg border-b pb-2">Informasi Akun (Login)</h3>
                                <div>
                                    <x-input-label for="name" :value="__('Nama Lengkap')" class="text-hitam font-bold" />
                                    <x-text-input id="name" class="block mt-1 w-full focus:border-oranye focus:ring-oranye" type="text" name="name" :value="old('name')" required />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="email" :value="__('Email')" class="text-hitam font-bold" />
                                    <x-text-input id="email" class="block mt-1 w-full focus:border-oranye focus:ring-oranye" type="email" name="email" :value="old('email')" required />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="password" :value="__('Kata Sandi')" class="text-hitam font-bold" />
                                    <x-text-input id="password" class="block mt-1 w-full focus:border-oranye focus:ring-oranye" type="password" name="password" required />
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" class="text-hitam font-bold" />
                                    <x-text-input id="password_confirmation" class="block mt-1 w-full focus:border-oranye focus:ring-oranye" type="password" name="password_confirmation" required />
                                </div>
                            </div>

                            <div class="space-y-4 bg-white p-4 rounded-lg border border-gray-200">
                                <h3 class="font-bold text-lg border-b pb-2 text-oranye">Profil Instruktur</h3>
                                <div>
                                    <x-input-label for="spesialisasi_las" :value="__('Spesialisasi Pengelasan (Contoh: SMAW 3G, GTAW)')" class="text-hitam font-bold" />
                                    <x-text-input id="spesialisasi_las" class="block mt-1 w-full focus:border-oranye focus:ring-oranye" type="text" name="spesialisasi_las" :value="old('spesialisasi_las')" />
                                </div>
                                <div>
                                    <x-input-label for="nomor_telepon" :value="__('Nomor WhatsApp / HP')" class="text-hitam font-bold" />
                                    <x-text-input id="nomor_telepon" class="block mt-1 w-full focus:border-oranye focus:ring-oranye" type="text" name="nomor_telepon" :value="old('nomor_telepon')" />
                                </div>
                                <div>
                                    <x-input-label for="alamat" :value="__('Alamat Lengkap')" class="text-hitam font-bold" />
                                    <textarea id="alamat" name="alamat" rows="3" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-oranye focus:ring-oranye">{{ old('alamat') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 space-x-4">
                            <a href="{{ route('admin.instruktur.index') }}" class="text-gray-500 hover:text-hitam font-semibold transition">Batal</a>
                            <button type="submit" class="bg-hitam text-white px-6 py-2 rounded-lg hover:bg-oranye transition duration-300 transform hover:-translate-y-1 shadow-lg">
                                Simpan Instruktur Baru
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>