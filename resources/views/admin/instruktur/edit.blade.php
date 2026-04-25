<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">
            {{ __('Edit Data Instruktur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-oranye">
                <div class="p-8 text-gray-900">
                    <form action="{{ route('admin.instruktur.update', $instruktur->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4 bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <h3 class="font-bold text-lg border-b pb-2">Informasi Akun (Login)</h3>
                                <div>
                                    <x-input-label for="name" :value="__('Nama Lengkap')" class="text-hitam font-bold" />
                                    <x-text-input id="name" class="block mt-1 w-full focus:border-oranye focus:ring-oranye" type="text" name="name" value="{{ old('name', $instruktur->user->name) }}" required />
                                </div>
                                <div>
                                    <x-input-label for="email" :value="__('Email')" class="text-hitam font-bold" />
                                    <x-text-input id="email" class="block mt-1 w-full focus:border-oranye focus:ring-oranye" type="email" name="email" value="{{ old('email', $instruktur->user->email) }}" required />
                                </div>
                                
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <p class="text-sm text-gray-500 mb-2 italic">*Kosongkan kata sandi di bawah jika tidak ingin mengubahnya.</p>
                                    <div>
                                        <x-input-label for="password" :value="__('Kata Sandi Baru (Opsional)')" class="text-hitam font-bold" />
                                        <x-text-input id="password" class="block mt-1 w-full focus:border-oranye focus:ring-oranye" type="password" name="password" />
                                    </div>
                                    <div class="mt-2">
                                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Sandi Baru')" class="text-hitam font-bold" />
                                        <x-text-input id="password_confirmation" class="block mt-1 w-full focus:border-oranye focus:ring-oranye" type="password" name="password_confirmation" />
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4 bg-white p-4 rounded-lg border border-gray-200">
                                <h3 class="font-bold text-lg border-b pb-2 text-oranye">Profil Instruktur</h3>
                                <div>
                                    <x-input-label for="spesialisasi_las" :value="__('Spesialisasi Pengelasan')" class="text-hitam font-bold" />
                                    <x-text-input id="spesialisasi_las" class="block mt-1 w-full focus:border-oranye focus:ring-oranye" type="text" name="spesialisasi_las" value="{{ old('spesialisasi_las', $instruktur->spesialisasi_las) }}" />
                                </div>
                                <div>
                                    <x-input-label for="nomor_telepon" :value="__('Nomor WhatsApp / HP')" class="text-hitam font-bold" />
                                    <x-text-input id="nomor_telepon" class="block mt-1 w-full focus:border-oranye focus:ring-oranye" type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $instruktur->nomor_telepon) }}" />
                                </div>
                                <div>
                                    <x-input-label for="alamat" :value="__('Alamat Lengkap')" class="text-hitam font-bold" />
                                    <textarea id="alamat" name="alamat" rows="3" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-oranye focus:ring-oranye">{{ old('alamat', $instruktur->alamat) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 space-x-4">
                            <a href="{{ route('admin.instruktur.index') }}" class="text-gray-500 hover:text-hitam font-semibold transition">Batal</a>
                            <button type="submit" class="bg-hitam text-white px-6 py-2 rounded-lg hover:bg-oranye transition duration-300 transform hover:-translate-y-1 shadow-lg">
                                Perbarui Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>