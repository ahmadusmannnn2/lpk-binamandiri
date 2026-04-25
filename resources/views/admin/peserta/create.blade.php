<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Tambah Data Peserta Baru') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-oranye">
                <div class="p-8 text-gray-900">
                    <form action="{{ route('admin.peserta.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div class="space-y-4 bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <h3 class="font-bold text-lg border-b pb-2">1. Akun Login Peserta</h3>
                                <div>
                                    <x-input-label for="name" :value="__('Nama Lengkap')" class="text-hitam font-bold" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                                </div>
                                <div>
                                    <x-input-label for="email" :value="__('Email')" class="text-hitam font-bold" />
                                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                                </div>
                                <div>
                                    <x-input-label for="password" :value="__('Kata Sandi')" class="text-hitam font-bold" />
                                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                                </div>
                                <div>
                                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Sandi')" class="text-hitam font-bold" />
                                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                                </div>
                            </div>

                            <div class="space-y-4 bg-white p-4 rounded-lg border border-gray-200">
                                <h3 class="font-bold text-lg border-b pb-2 text-oranye">2. Biodata & Foto</h3>
                                <div>
                                    <x-input-label for="nik" :value="__('NIK (Nomor Induk Kependudukan)')" class="text-hitam font-bold" />
                                    <x-text-input id="nik" class="block mt-1 w-full" type="text" name="nik" :value="old('nik')" maxlength="16" />
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" class="text-hitam font-bold" />
                                        <x-text-input id="tempat_lahir" class="block mt-1 w-full" type="text" name="tempat_lahir" :value="old('tempat_lahir')" />
                                    </div>
                                    <div>
                                        <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" class="text-hitam font-bold" />
                                        <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir" :value="old('tanggal_lahir')" />
                                    </div>
                                </div>
                                <div>
                                    <x-input-label for="nomor_telepon" :value="__('Nomor Telepon / WA')" class="text-hitam font-bold" />
                                    <x-text-input id="nomor_telepon" class="block mt-1 w-full" type="text" name="nomor_telepon" :value="old('nomor_telepon')" />
                                </div>
                                <div>
                                    <x-input-label for="alamat" :value="__('Alamat Lengkap')" class="text-hitam font-bold" />
                                    <textarea id="alamat" name="alamat" rows="2" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('alamat') }}</textarea>
                                </div>
                                <div>
                                    <x-input-label for="pas_foto" :value="__('Pas Foto (Max 2MB, JPG/PNG)')" class="text-hitam font-bold" />
                                    <input id="pas_foto" type="file" name="pas_foto" accept="image/*" class="block w-full text-sm text-gray-500 mt-1 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-oranye file:text-white hover:file:bg-[#c24b22] transition"/>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end mt-8">
                            <button type="submit" class="bg-hitam text-white px-8 py-3 rounded-lg hover:bg-oranye transition duration-300 transform hover:-translate-y-1 shadow-lg font-bold">
                                Simpan Peserta
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>