<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">
            {{ __('Tambah Program Pelatihan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-oranye">
                <div class="p-8 text-gray-900">
                    <form action="{{ route('admin.program.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <x-input-label for="nama_program" :value="__('Nama Program Pelatihan')" class="text-hitam font-bold" />
                            <x-text-input id="nama_program" class="block mt-1 w-full focus:border-oranye focus:ring-oranye" type="text" name="nama_program" :value="old('nama_program')" required autofocus />
                            <x-input-error :messages="$errors->get('nama_program')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="harga_pelatihan" :value="__('Harga Pelatihan (Rp)')" class="text-hitam font-bold" />
                            <x-text-input id="harga_pelatihan" class="block mt-1 w-full focus:border-oranye focus:ring-oranye" type="number" name="harga_pelatihan" :value="old('harga_pelatihan', 0)" required />
                            <p class="text-xs text-gray-500 mt-1">Isi 0 jika program ini gratis.</p>
                            <x-input-error :messages="$errors->get('harga_pelatihan')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="deskripsi" :value="__('Deskripsi Program')" class="text-hitam font-bold" />
                            <textarea id="deskripsi" name="deskripsi" rows="4" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-oranye focus:ring-oranye">{{ old('deskripsi') }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6 space-x-4">
                            <a href="{{ route('admin.program.index') }}" class="text-gray-500 hover:text-hitam font-semibold transition">Batal</a>
                            <button type="submit" class="bg-hitam text-white px-6 py-2 rounded-lg hover:bg-oranye transition duration-300 transform hover:-translate-y-1 shadow-lg">
                                Simpan Program
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>