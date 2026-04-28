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
                <form action="{{ route('admin.pengaturan.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h3 class="font-bold text-lg text-oranye border-b pb-2 mb-4">Identitas Website & Logo</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="md:col-span-1 text-center border-r border-gray-200 pr-4">
                                <x-input-label :value="__('Logo Navbar Saat Ini')" class="font-bold text-hitam mb-2" />
                                @if(isset($pengaturan['logo_navbar']))
                                    <div class="bg-hitam p-4 rounded-lg inline-block">
                                        <img src="{{ asset('storage/' . $pengaturan['logo_navbar']) }}" alt="Logo Website" class="h-12 w-auto object-contain">
                                    </div>
                                @else
                                    <div class="bg-gray-200 p-4 rounded-lg text-sm text-gray-500 italic">
                                        Belum ada logo.
                                    </div>
                                @endif
                                <input id="logo_navbar" type="file" name="logo_navbar" class="block w-full text-xs mt-4 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:bg-oranye file:text-white hover:file:bg-[#c24b22]"/>
                                <p class="text-[10px] text-gray-500 mt-1">Format: PNG/SVG transparan, Max 2MB.</p>
                            </div>
                            <div class="md:col-span-2 space-y-4">
                                <div class="grid grid-cols-2 gap-4 bg-white p-3 border rounded shadow-sm">
                                    <div>
                                        <x-input-label for="nama_lpk_1" :value="__('Teks Logo Bagian 1 (Putih)')" />
                                        <x-text-input id="nama_lpk_1" class="block mt-1 w-full" type="text" name="nama_lpk_1" value="{{ $pengaturan['nama_lpk_1'] ?? 'LPK' }}" required />
                                    </div>
                                    <div>
                                        <x-input-label for="nama_lpk_2" :value="__('Teks Logo Bagian 2 (Oranye)')" />
                                        <x-text-input id="nama_lpk_2" class="block mt-1 w-full" type="text" name="nama_lpk_2" value="{{ $pengaturan['nama_lpk_2'] ?? 'BINA' }}" required />
                                    </div>
                                </div>

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