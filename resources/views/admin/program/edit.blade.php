<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ url()->previous() }}" class="text-gray-500 hover:text-oranye transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-xl text-hitam leading-tight">
                {{ __('Edit Program Pelatihan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-oranye">
                <div class="p-8 text-gray-900">
                    <form action="{{ route('admin.program.update', $program->id) }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <x-input-label for="nama_program" :value="__('Nama Program Pelatihan')" class="text-hitam font-bold" />
                            <x-text-input id="nama_program" class="block mt-1 w-full focus:border-oranye focus:ring-oranye rounded-xl" type="text" name="nama_program" value="{{ old('nama_program', $program->nama_program) }}" required autofocus />
                            <x-input-error :messages="$errors->get('nama_program')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="harga_pelatihan" :value="__('Harga Pelatihan (Rp)')" class="text-hitam font-bold" />
                                <x-text-input id="harga_pelatihan" class="block mt-1 w-full focus:border-oranye focus:ring-oranye rounded-xl" type="number" name="harga_pelatihan" value="{{ old('harga_pelatihan', $program->harga_pelatihan) }}" required />
                                <x-input-error :messages="$errors->get('harga_pelatihan')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="durasi_hari" :value="__('Durasi Kelas (Hari Kerja)')" class="text-hitam font-bold" />
                                <x-text-input id="durasi_hari" class="block mt-1 w-full focus:border-oranye focus:ring-oranye rounded-xl" type="number" name="durasi_hari" value="{{ old('durasi_hari', $program->durasi_hari) }}" required />
                                <x-input-error :messages="$errors->get('durasi_hari')" class="mt-2" />
                            </div>
                        </div>

                        <!-- INPUT GAMBAR/THUMBNAIL -->
                        <div class="mt-6">
                            <x-input-label for="gambar" :value="__('Thumbnail / Gambar Program (Opsional)')" class="text-hitam font-bold text-sm" />
                            
                            @if($program->gambar)
                                <div class="mt-3 mb-4">
                                    <p class="text-xs text-gray-500 mb-2 font-bold uppercase tracking-wider">Gambar Saat Ini:</p>
                                    <img src="{{ asset('storage/' . $program->gambar) }}" alt="{{ $program->nama_program }}" class="w-48 h-32 object-cover rounded-xl border-4 border-gray-100 shadow-sm">
                                </div>
                            @endif

                            <input id="gambar" type="file" name="gambar" accept="image/jpeg,image/png,image/jpg,image/webp" class="block w-full text-sm text-gray-500 mt-2 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-orange-50 file:text-oranye hover:file:bg-orange-100 transition cursor-pointer border border-gray-200 rounded-xl" />
                            <p class="text-[11px] text-gray-500 mt-1.5 font-medium ml-1">Format didukung: JPG, PNG, WEBP. Maks: 2MB. Kosongkan jika tidak ingin mengubah.</p>
                            <x-input-error :messages="$errors->get('gambar')" class="mt-2" />
                        </div>



                        <div>
                            <x-input-label for="deskripsi" :value="__('Deskripsi Program')" class="text-hitam font-bold mt-6" />
                            <textarea id="deskripsi" name="deskripsi" rows="4" class="block mt-1 w-full border-gray-300 rounded-xl shadow-sm focus:border-oranye focus:ring-oranye">{{ old('deskripsi', $program->deskripsi) }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-100 space-x-4">
                            <a href="{{ route('admin.program.index') }}" class="text-gray-500 hover:text-hitam font-bold transition">Batal</a>
                            <button type="submit" class="bg-hitam text-white px-8 py-3 rounded-xl hover:bg-oranye transition duration-300 transform hover:-translate-y-1 shadow-lg font-bold">
                                Perbarui Program
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>