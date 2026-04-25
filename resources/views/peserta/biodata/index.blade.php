<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Lengkapi Biodata Diri') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm"><p class="font-bold">Berhasil</p><p>{{ session('success') }}</p></div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm"><p class="font-bold">Perhatian</p><p>{{ session('error') }}</p></div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-oranye">
                <div class="p-8">
                    <p class="text-sm text-gray-500 mb-6 border-b pb-4">Silakan lengkapi biodata dan unggah pas foto Anda sebelum melakukan pendaftaran kelas pelatihan.</p>

                    <form action="{{ route('peserta.biodata.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="nik" :value="__('NIK KTP')" class="text-hitam font-bold" />
                                <x-text-input id="nik" class="block mt-1 w-full" type="text" name="nik" value="{{ old('nik', $peserta->nik) }}" required />
                            </div>
                            <div>
                                <x-input-label for="nomor_telepon" :value="__('No HP / WhatsApp')" class="text-hitam font-bold" />
                                <x-text-input id="nomor_telepon" class="block mt-1 w-full" type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $peserta->nomor_telepon) }}" required />
                            </div>
                            <div>
                                <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" class="text-hitam font-bold" />
                                <x-text-input id="tempat_lahir" class="block mt-1 w-full" type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $peserta->tempat_lahir) }}" required />
                            </div>
                            <div>
                                <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" class="text-hitam font-bold" />
                                <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $peserta->tanggal_lahir) }}" required />
                            </div>
                            <div class="md:col-span-2">
                                <x-input-label for="alamat" :value="__('Alamat Lengkap')" class="text-hitam font-bold" />
                                <textarea id="alamat" name="alamat" rows="2" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>{{ old('alamat', $peserta->alamat) }}</textarea>
                            </div>
                            <div class="md:col-span-2 bg-gray-50 p-4 rounded border">
                                <x-input-label for="pas_foto" :value="__('Pas Foto Resmi (Maks 2MB, JPG/PNG)')" class="text-hitam font-bold mb-2" />
                                @if($peserta->pas_foto)
                                    <img src="{{ asset('storage/' . $peserta->pas_foto) }}" class="w-24 h-24 object-cover rounded shadow mb-3 border border-oranye">
                                @else
                                    <p class="text-xs text-red-500 mb-2">*Anda belum mengunggah foto</p>
                                @endif
                                <input id="pas_foto" type="file" name="pas_foto" accept="image/*" class="block w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-oranye file:text-white" {{ $peserta->pas_foto ? '' : 'required' }}/>
                            </div>
                        </div>

                        <div class="flex justify-end mt-8">
                            <button type="submit" class="bg-hitam text-white px-8 py-3 rounded-lg hover:bg-oranye font-bold shadow-lg">Simpan Biodata</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>