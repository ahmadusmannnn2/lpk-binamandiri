<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.peserta.index') }}" class="text-gray-500 hover:text-oranye transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-xl text-hitam leading-tight">
                {{ __('Edit Data Peserta: ') }} <span class="text-oranye">{{ $peserta->user->name }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
                    <div class="font-bold text-red-800 mb-1">Terdapat kesalahan:</div>
                    <ul class="list-disc list-inside text-sm text-red-700">
                        @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border-t-4 border-oranye">
                <div class="p-6 sm:p-10">
                    <form action="{{ route('admin.peserta.update', $peserta->id) }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                        @csrf
                        @method('PUT')

                        <div>
                            <h3 class="text-lg font-black text-hitam border-b border-gray-200 pb-2 mb-6 flex items-center gap-2">
                                <svg class="w-5 h-5 text-oranye" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                                Data Akun Login
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="name" value="Nama Lengkap" class="font-bold text-gray-700" />
                                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full focus:border-oranye focus:ring-oranye" value="{{ old('name', $peserta->user->name) }}" required />
                                </div>
                                <div>
                                    <x-input-label for="email" value="Email Aktif" class="font-bold text-gray-700" />
                                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full focus:border-oranye focus:ring-oranye" value="{{ old('email', $peserta->user->email) }}" required />
                                </div>
                                <div class="md:col-span-2 p-3 bg-yellow-50 border border-yellow-200 rounded-lg text-xs text-yellow-700 flex gap-2">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p>Jika peserta lupa sandi, silakan gunakan tombol <strong>"Reset Sandi"</strong> (warna kuning) di halaman tabel daftar peserta sebelumnya.</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-black text-hitam border-b border-gray-200 pb-2 mb-6 flex items-center gap-2">
                                <svg class="w-5 h-5 text-oranye" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Informasi Biodata
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="nik" value="Nomor Induk Kependudukan (NIK)" class="font-bold text-gray-700" />
                                    <x-text-input id="nik" name="nik" type="text" class="mt-1 block w-full focus:border-oranye focus:ring-oranye" value="{{ old('nik', $peserta->nik) }}" maxlength="16" />
                                </div>
                                <div>
                                    <x-input-label for="nomor_telepon" value="Nomor WhatsApp" class="font-bold text-gray-700" />
                                    <x-text-input id="nomor_telepon" name="nomor_telepon" type="text" class="mt-1 block w-full focus:border-oranye focus:ring-oranye" value="{{ old('nomor_telepon', $peserta->nomor_telepon) }}" />
                                </div>
                                <div>
                                    <x-input-label for="jenis_kelamin" value="Jenis Kelamin" class="font-bold text-gray-700" />
                                    <select id="jenis_kelamin" name="jenis_kelamin" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-oranye focus:ring-oranye">
                                        <option value="" disabled {{ empty($peserta->jenis_kelamin) ? 'selected' : '' }}>-- Pilih --</option>
                                        <option value="Laki-laki" {{ old('jenis_kelamin', $peserta->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin', $peserta->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="pendidikan_terakhir" value="Pendidikan Terakhir" class="font-bold text-gray-700" />
                                    <select id="pendidikan_terakhir" name="pendidikan_terakhir" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-oranye focus:ring-oranye">
                                        <option value="" disabled {{ empty($peserta->pendidikan_terakhir) ? 'selected' : '' }}>-- Pilih --</option>
                                        <option value="SD/Sederajat" {{ old('pendidikan_terakhir', $peserta->pendidikan_terakhir) == 'SD/Sederajat' ? 'selected' : '' }}>SD / Sederajat</option>
                                        <option value="SMP/Sederajat" {{ old('pendidikan_terakhir', $peserta->pendidikan_terakhir) == 'SMP/Sederajat' ? 'selected' : '' }}>SMP / Sederajat</option>
                                        <option value="SMA/SMK/Sederajat" {{ old('pendidikan_terakhir', $peserta->pendidikan_terakhir) == 'SMA/SMK/Sederajat' ? 'selected' : '' }}>SMA / SMK / Sederajat</option>
                                        <option value="D3 / Diploma" {{ old('pendidikan_terakhir', $peserta->pendidikan_terakhir) == 'D3 / Diploma' ? 'selected' : '' }}>D3 / Diploma</option>
                                        <option value="S1 / Sarjana" {{ old('pendidikan_terakhir', $peserta->pendidikan_terakhir) == 'S1 / Sarjana' ? 'selected' : '' }}>S1 / Sarjana</option>
                                    </select>
                                </div>
                                <div class="md:col-span-2">
                                    <x-input-label for="alamat_lengkap" value="Alamat Lengkap KTP" class="font-bold text-gray-700" />
                                    <textarea id="alamat_lengkap" name="alamat_lengkap" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-oranye focus:ring-oranye">{{ old('alamat_lengkap', $peserta->alamat_lengkap) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-black text-hitam border-b border-gray-200 pb-2 mb-6 flex items-center gap-2">
                                <svg class="w-5 h-5 text-oranye" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                Berkas & Dokumen
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                
                                <div class="bg-gray-50 border border-gray-200 p-4 rounded-xl relative">
                                    <x-input-label value="Pas Foto" class="font-bold text-hitam mb-3 text-center block" />
                                    @if($peserta->pas_foto)
                                        <div class="flex justify-center mb-2">
                                            <img src="{{ asset('storage/' . $peserta->pas_foto) }}" class="h-16 w-16 object-cover rounded-full border-2 border-green-500">
                                        </div>
                                    @endif
                                    <input type="file" name="pas_foto" class="block w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-2 file:rounded file:border-0 file:bg-oranye/10 file:text-oranye hover:file:bg-oranye hover:file:text-white" accept=".jpg,.jpeg,.png">
                                </div>

                                <div class="bg-gray-50 border border-gray-200 p-4 rounded-xl relative">
                                    <x-input-label value="File KTP" class="font-bold text-hitam mb-3 text-center block" />
                                    @if($peserta->file_ktp)
                                        <div class="flex justify-center mb-2">
                                            <a href="{{ asset('storage/' . $peserta->file_ktp) }}" target="_blank" class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full font-bold hover:bg-green-200">Lihat KTP</a>
                                        </div>
                                    @endif
                                    <input type="file" name="file_ktp" class="block w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-2 file:rounded file:border-0 file:bg-oranye/10 file:text-oranye hover:file:bg-oranye hover:file:text-white" accept=".jpg,.jpeg,.png">
                                </div>

                                <div class="bg-gray-50 border border-gray-200 p-4 rounded-xl relative">
                                    <x-input-label value="File Ijazah" class="font-bold text-hitam mb-3 text-center block" />
                                    @if($peserta->file_ijazah)
                                        <div class="flex justify-center mb-2">
                                            <a href="{{ asset('storage/' . $peserta->file_ijazah) }}" target="_blank" class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full font-bold hover:bg-green-200">Lihat Ijazah</a>
                                        </div>
                                    @endif
                                    <input type="file" name="file_ijazah" class="block w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-2 file:rounded file:border-0 file:bg-oranye/10 file:text-oranye hover:file:bg-oranye hover:file:text-white" accept=".pdf,.jpg,.jpeg,.png">
                                </div>

                            </div>
                        </div>

                        <div class="flex items-center justify-end pt-4 border-t border-gray-200">
                            <button type="submit" class="bg-hitam hover:bg-gray-800 text-white font-bold py-3 px-8 rounded-lg shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
                                Perbarui Data Peserta
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>