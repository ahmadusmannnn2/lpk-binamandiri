<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Edit Data Peserta') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-oranye">
                <div class="p-8 text-gray-900">
                    <form action="{{ route('admin.peserta.update', $peserta->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div class="space-y-4 bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <h3 class="font-bold text-lg border-b pb-2">1. Akun Login Peserta</h3>
                                <div>
                                    <x-input-label for="name" :value="__('Nama Lengkap')" class="text-hitam font-bold" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name', $peserta->user->name) }}" required />
                                </div>
                                <div>
                                    <x-input-label for="email" :value="__('Email')" class="text-hitam font-bold" />
                                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ old('email', $peserta->user->email) }}" required />
                                </div>
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <p class="text-xs text-gray-500 mb-2 italic">*Kosongkan jika tidak ubah sandi.</p>
                                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" placeholder="Sandi Baru" />
                                    <x-text-input id="password_confirmation" class="block mt-2 w-full" type="password" name="password_confirmation" placeholder="Konfirmasi Sandi Baru" />
                                </div>
                            </div>

                            <div class="space-y-4 bg-white p-4 rounded-lg border border-gray-200">
                                <h3 class="font-bold text-lg border-b pb-2 text-oranye">2. Biodata & Foto</h3>
                                <div>
                                    <x-input-label for="nik" :value="__('NIK')" class="text-hitam font-bold" />
                                    <x-text-input id="nik" class="block mt-1 w-full" type="text" name="nik" value="{{ old('nik', $peserta->nik) }}" maxlength="16" />
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" class="text-hitam font-bold" />
                                        <x-text-input id="tempat_lahir" class="block mt-1 w-full" type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $peserta->tempat_lahir) }}" />
                                    </div>
                                    <div>
                                        <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" class="text-hitam font-bold" />
                                        <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $peserta->tanggal_lahir) }}" />
                                    </div>
                                </div>
                                <div>
                                    <x-input-label for="nomor_telepon" :value="__('Nomor Telepon / WA')" class="text-hitam font-bold" />
                                    <x-text-input id="nomor_telepon" class="block mt-1 w-full" type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $peserta->nomor_telepon) }}" />
                                </div>
                                <div>
                                    <x-input-label for="alamat" :value="__('Alamat Lengkap')" class="text-hitam font-bold" />
                                    <textarea id="alamat" name="alamat" rows="2" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('alamat', $peserta->alamat) }}</textarea>
                                </div>
                                
                                <div class="bg-gray-50 p-3 rounded-md border">
                                    <x-input-label :value="__('Foto Saat Ini')" class="text-hitam font-bold mb-2" />
                                    @if($peserta->pas_foto)
                                        <img src="{{ asset('storage/' . $peserta->pas_foto) }}" class="w-20 h-20 object-cover rounded shadow mb-2">
                                    @else
                                        <p class="text-xs text-red-500 mb-2">Belum ada foto</p>
                                    @endif
                                    <x-input-label for="pas_foto" :value="__('Upload Foto Baru (Max 2MB)')" class="text-xs text-gray-600" />
                                    <input id="pas_foto" type="file" name="pas_foto" accept="image/*" class="block w-full text-xs text-gray-500 mt-1 file:mr-4 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:bg-gray-200 file:text-hitam hover:file:bg-gray-300 transition"/>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end mt-8">
                            <button type="submit" class="bg-hitam text-white px-8 py-3 rounded-lg hover:bg-oranye transition duration-300 transform hover:-translate-y-1 shadow-lg font-bold">
                                Perbarui Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>