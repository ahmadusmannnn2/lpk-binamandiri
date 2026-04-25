<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Pengaturan Konten Landing Page') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm"><p class="font-bold">Berhasil</p><p>{{ session('success') }}</p></div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-oranye p-8">
                <form action="{{ route('admin.pengaturan.update') }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h3 class="font-bold text-lg text-oranye border-b pb-2 mb-4">Bagian Header (Utama)</h3>
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="hero_judul" :value="__('Teks Judul Utama (Hero)')" />
                                <x-text-input id="hero_judul" class="block mt-1 w-full" type="text" name="hero_judul" value="{{ $pengaturan['hero_judul'] ?? '' }}" required />
                            </div>
                            <div>
                                <x-input-label for="hero_deskripsi" :value="__('Teks Deskripsi Singkat')" />
                                <textarea id="hero_deskripsi" name="hero_deskripsi" rows="3" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-oranye focus:ring-oranye" required>{{ $pengaturan['hero_deskripsi'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h3 class="font-bold text-lg text-oranye border-b pb-2 mb-4">Bagian Tentang Kami</h3>
                        <div>
                            <x-input-label for="tentang_deskripsi" :value="__('Deskripsi Perusahaan')" />
                            <textarea id="tentang_deskripsi" name="tentang_deskripsi" rows="5" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-oranye focus:ring-oranye" required>{{ $pengaturan['tentang_deskripsi'] ?? '' }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">Gunakan Enter untuk membuat paragraf baru.</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h3 class="font-bold text-lg text-oranye border-b pb-2 mb-4">Kontak & Footer</h3>
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="kontak_alamat" :value="__('Alamat Lengkap LPK')" />
                                <textarea id="kontak_alamat" name="kontak_alamat" rows="2" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-oranye focus:ring-oranye" required>{{ $pengaturan['kontak_alamat'] ?? '' }}</textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="kontak_telepon" :value="__('Nomor Telepon / WA')" />
                                    <x-text-input id="kontak_telepon" class="block mt-1 w-full" type="text" name="kontak_telepon" value="{{ $pengaturan['kontak_telepon'] ?? '' }}" required />
                                </div>
                                <div>
                                    <x-input-label for="kontak_email" :value="__('Alamat Email')" />
                                    <x-text-input id="kontak_email" class="block mt-1 w-full" type="email" name="kontak_email" value="{{ $pengaturan['kontak_email'] ?? '' }}" required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-hitam text-white hover:bg-oranye px-8 py-3 rounded-lg font-bold shadow-lg transition transform hover:-translate-y-1">Simpan Perubahan Web</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>