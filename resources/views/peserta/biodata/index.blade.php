<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">
            {{ __('Lengkapi Biodata Diri') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-bold text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
                    <div class="flex items-center mb-2">
                        <svg class="h-5 w-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        <span class="font-bold text-red-800">Terdapat kesalahan pengisian:</span>
                    </div>
                    <ul class="list-disc list-inside text-sm text-red-700 ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- FITUR BARU: BANNER STATUS VERIFIKASI -->
            @if(isset($peserta) && $peserta->status_biodata != 'belum_isi')
                <div class="mb-8 rounded-2xl shadow-sm border-l-8 p-6 
                    {{ $peserta->status_biodata == 'disetujui' ? 'bg-green-50 border-green-500' : '' }}
                    {{ $peserta->status_biodata == 'menunggu' ? 'bg-yellow-50 border-yellow-400' : '' }}
                    {{ $peserta->status_biodata == 'ditolak' ? 'bg-red-50 border-red-500' : '' }}
                ">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 mt-1">
                            @if($peserta->status_biodata == 'disetujui')
                                <div class="bg-green-100 p-2 rounded-full">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                            @elseif($peserta->status_biodata == 'menunggu')
                                <div class="bg-yellow-100 p-2 rounded-full animate-pulse">
                                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                            @else
                                <div class="bg-red-100 p-2 rounded-full">
                                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-lg font-black uppercase tracking-wider
                                {{ $peserta->status_biodata == 'disetujui' ? 'text-green-800' : '' }}
                                {{ $peserta->status_biodata == 'menunggu' ? 'text-yellow-800' : '' }}
                                {{ $peserta->status_biodata == 'ditolak' ? 'text-red-800' : '' }}
                            ">
                                Status Berkas: {{ $peserta->status_biodata }}
                            </h3>
                            <div class="mt-2 text-sm font-medium
                                {{ $peserta->status_biodata == 'disetujui' ? 'text-green-700' : '' }}
                                {{ $peserta->status_biodata == 'menunggu' ? 'text-yellow-700' : '' }}
                                {{ $peserta->status_biodata == 'ditolak' ? 'text-red-700' : '' }}
                            ">
                                @if($peserta->status_biodata == 'disetujui')
                                    <p>Selamat! Biodata dan berkas Anda telah diverifikasi dan disetujui. Anda sekarang dapat melanjutkan ke menu <strong>Pendaftaran</strong> untuk memilih kelas pelatihan.</p>
                                @elseif($peserta->status_biodata == 'menunggu')
                                    <p>Biodata dan berkas Anda sedang dalam antrean pengecekan oleh Admin kami. Mohon menunggu maksimal 1x24 jam kerja.</p>
                                @elseif($peserta->status_biodata == 'ditolak')
                                    <p>Mohon maaf, pengajuan Anda dikembalikan. <strong>Catatan Admin:</strong> <span class="italic font-bold">"{{ $peserta->catatan_biodata }}"</span></p>
                                    <p class="mt-2 text-red-800 font-bold bg-red-100 py-2 px-3 rounded-lg inline-block">Silakan perbaiki data/berkas di bawah ini lalu tekan tombol simpan kembali.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border-t-4 border-oranye">
                <div class="p-6 sm:p-10">
                    <form action="{{ route('peserta.biodata.update') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                        @csrf
                        @method('PUT')

                        <div>
                            <h3 class="text-lg font-black text-hitam border-b border-gray-200 pb-2 mb-6 flex items-center gap-2">
                                <svg class="w-5 h-5 text-oranye" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Informasi Pribadi
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="nama" value="Nama Lengkap (Sesuai KTP)" class="font-bold text-gray-700" />
                                    <x-text-input id="nama" type="text" class="mt-1 block w-full bg-gray-100 text-gray-500 cursor-not-allowed" value="{{ Auth::user()->name }}" disabled />
                                    <p class="text-[10px] text-gray-400 mt-1">*Nama diambil dari data pendaftaran akun.</p>
                                </div>

                                <div>
                                    <x-input-label for="email" value="Email Aktif" class="font-bold text-gray-700" />
                                    <x-text-input id="email" type="email" class="mt-1 block w-full bg-gray-100 text-gray-500 cursor-not-allowed" value="{{ Auth::user()->email }}" disabled />
                                </div>

                                <div>
                                    <x-input-label for="nik" value="Nomor Induk Kependudukan (NIK)" class="font-bold text-gray-700" />
                                    <x-text-input id="nik" name="nik" type="text" class="mt-1 block w-full focus:border-oranye focus:ring-oranye" value="{{ old('nik', $peserta->nik ?? '') }}" required placeholder="Masukkan 16 digit NIK" maxlength="16" />
                                </div>

                                <div>
                                    <x-input-label for="nomor_telepon" value="Nomor WhatsApp" class="font-bold text-gray-700" />
                                    <x-text-input id="nomor_telepon" name="nomor_telepon" type="text" class="mt-1 block w-full focus:border-oranye focus:ring-oranye" value="{{ old('nomor_telepon', $peserta->nomor_telepon ?? '') }}" required placeholder="Contoh: 081234567890" />
                                </div>

                                <div>
                                    <x-input-label for="tempat_lahir" value="Tempat Lahir" class="font-bold text-gray-700" />
                                    <x-text-input id="tempat_lahir" name="tempat_lahir" type="text" class="mt-1 block w-full focus:border-oranye focus:ring-oranye" value="{{ old('tempat_lahir', $peserta->tempat_lahir ?? '') }}" required placeholder="Contoh: Wonosobo" />
                                </div>

                                <div>
                                    <x-input-label for="tanggal_lahir" value="Tanggal Lahir" class="font-bold text-gray-700" />
                                    <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date" class="mt-1 block w-full focus:border-oranye focus:ring-oranye" value="{{ old('tanggal_lahir', $peserta->tanggal_lahir ?? '') }}" required />
                                </div>

                                <div>
                                    <x-input-label for="jenis_kelamin" value="Jenis Kelamin" class="font-bold text-gray-700" />
                                    <select id="jenis_kelamin" name="jenis_kelamin" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-oranye focus:ring-oranye" required>
                                        <option value="" disabled {{ empty($peserta->jenis_kelamin) ? 'selected' : '' }}>-- Pilih Jenis Kelamin --</option>
                                        <option value="Laki-laki" {{ old('jenis_kelamin', $peserta->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin', $peserta->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>

                                <div>
                                    <x-input-label for="pendidikan_terakhir" value="Pendidikan Terakhir" class="font-bold text-gray-700" />
                                    <select id="pendidikan_terakhir" name="pendidikan_terakhir" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-oranye focus:ring-oranye" required>
                                        <option value="" disabled {{ empty($peserta->pendidikan_terakhir) ? 'selected' : '' }}>-- Pilih Pendidikan Terakhir --</option>
                                        <option value="SD/Sederajat" {{ old('pendidikan_terakhir', $peserta->pendidikan_terakhir ?? '') == 'SD/Sederajat' ? 'selected' : '' }}>SD / Sederajat</option>
                                        <option value="SMP/Sederajat" {{ old('pendidikan_terakhir', $peserta->pendidikan_terakhir ?? '') == 'SMP/Sederajat' ? 'selected' : '' }}>SMP / Sederajat</option>
                                        <option value="SMA/SMK/Sederajat" {{ old('pendidikan_terakhir', $peserta->pendidikan_terakhir ?? '') == 'SMA/SMK/Sederajat' ? 'selected' : '' }}>SMA / SMK / Sederajat</option>
                                        <option value="D3 / Diploma" {{ old('pendidikan_terakhir', $peserta->pendidikan_terakhir ?? '') == 'D3 / Diploma' ? 'selected' : '' }}>D3 / Diploma</option>
                                        <option value="S1 / Sarjana" {{ old('pendidikan_terakhir', $peserta->pendidikan_terakhir ?? '') == 'S1 / Sarjana' ? 'selected' : '' }}>S1 / Sarjana</option>
                                    </select>
                                </div>

                                <div class="md:col-span-2">
                                    <x-input-label for="alamat" value="Alamat Lengkap KTP" class="font-bold text-gray-700" />
                                    <textarea id="alamat" name="alamat" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-oranye focus:ring-oranye" required placeholder="Tuliskan alamat lengkap beserta RT/RW, Kelurahan, Kecamatan...">{{ old('alamat', $peserta->alamat ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-black text-hitam border-b border-gray-200 pb-2 mb-6 flex items-center gap-2">
                                <svg class="w-5 h-5 text-oranye" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                Berkas & Dokumen Persyaratan
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                
                                <div class="bg-gray-50 border border-gray-200 p-4 rounded-xl relative group hover:border-oranye transition duration-300">
                                    <x-input-label value="Pas Foto Berwarna" class="font-bold text-hitam mb-3 text-center block" />
                                    
                                    @if(isset($peserta->pas_foto) && $peserta->pas_foto)
                                        <div class="mb-3 flex flex-col items-center">
                                            <img src="{{ asset('storage/' . $peserta->pas_foto) }}" alt="Pas Foto" class="h-24 w-24 object-cover rounded-full border-4 border-green-500 shadow-md">
                                            <span class="mt-2 text-xs font-bold text-green-600 bg-green-100 px-2 py-1 rounded-full flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                                Berkas Tersimpan
                                            </span>
                                        </div>
                                    @endif
                                    
                                    <input type="file" name="pas_foto" id="pas_foto" class="block w-full text-xs text-gray-500 file:mr-2 file:py-2 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-oranye/10 file:text-oranye hover:file:bg-oranye hover:file:text-white cursor-pointer transition" accept=".jpg,.jpeg,.png">
                                    <p class="text-[10px] text-gray-400 mt-2 text-center">Format: JPG/PNG (Maks. 2MB)</p>
                                </div>

                                <div class="bg-gray-50 border border-gray-200 p-4 rounded-xl relative group hover:border-oranye transition duration-300">
                                    <x-input-label value="Scan / Foto KTP Asli" class="font-bold text-hitam mb-3 text-center block" />
                                    
                                    @if(isset($peserta->file_ktp) && $peserta->file_ktp)
                                        <div class="mb-3 flex flex-col items-center">
                                            <div class="h-16 w-24 bg-green-100 rounded border-2 border-green-500 flex items-center justify-center shadow-sm">
                                                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                            </div>
                                            <span class="mt-2 text-xs font-bold text-green-600 bg-green-100 px-2 py-1 rounded-full flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                                KTP Tersimpan
                                            </span>
                                            <a href="{{ asset('storage/' . $peserta->file_ktp) }}" target="_blank" class="text-[10px] text-blue-500 hover:underline mt-1">Lihat Berkas</a>
                                        </div>
                                    @endif
                                    
                                    <input type="file" name="file_ktp" id="file_ktp" class="block w-full text-xs text-gray-500 file:mr-2 file:py-2 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-oranye/10 file:text-oranye hover:file:bg-oranye hover:file:text-white cursor-pointer transition" accept=".jpg,.jpeg,.png">
                                    <p class="text-[10px] text-gray-400 mt-2 text-center">Format: JPG/PNG (Maks. 2MB)</p>
                                </div>

                                <div class="bg-gray-50 border border-gray-200 p-4 rounded-xl relative group hover:border-oranye transition duration-300">
                                    <x-input-label value="Scan Ijazah Terakhir" class="font-bold text-hitam mb-3 text-center block" />
                                    
                                    @if(isset($peserta->file_ijazah) && $peserta->file_ijazah)
                                        <div class="mb-3 flex flex-col items-center">
                                            <div class="h-16 w-16 bg-green-100 rounded border-2 border-green-500 flex items-center justify-center shadow-sm">
                                                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                            </div>
                                            <span class="mt-2 text-xs font-bold text-green-600 bg-green-100 px-2 py-1 rounded-full flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                                Ijazah Tersimpan
                                            </span>
                                            <a href="{{ asset('storage/' . $peserta->file_ijazah) }}" target="_blank" class="text-[10px] text-blue-500 hover:underline mt-1">Lihat Berkas</a>
                                        </div>
                                    @endif
                                    
                                    <input type="file" name="file_ijazah" id="file_ijazah" class="block w-full text-xs text-gray-500 file:mr-2 file:py-2 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-oranye/10 file:text-oranye hover:file:bg-oranye hover:file:text-white cursor-pointer transition" accept=".pdf,.jpg,.jpeg,.png">
                                    <p class="text-[10px] text-gray-400 mt-2 text-center">Format: PDF/JPG/PNG (Maks. 2MB)</p>
                                </div>

                            </div>
                            <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg text-xs text-blue-700 flex items-start gap-2">
                                <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p><strong>Penting:</strong> Jika Anda sudah pernah mengunggah berkas sebelumnya, Anda tidak perlu mengunggah ulang kecuali ingin mengganti berkas tersebut dengan yang baru.</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-end pt-4 border-t border-gray-200">
                            <button type="submit" class="bg-hitam hover:bg-gray-800 text-white font-bold py-3 px-8 rounded-lg shadow-lg hover:shadow-xl transition transform hover:-translate-y-1 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                Simpan Biodata & Berkas
                            </button>
                        </div>
                        
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>