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
                                
                                <!-- PAS FOTO -->
                                <div class="bg-gray-50 border border-gray-200 p-4 rounded-xl relative group hover:border-oranye transition duration-300 text-center flex flex-col items-center justify-between">
                                    <x-input-label value="Pas Foto Berwarna" class="font-bold text-hitam mb-3 text-center block" />
                                    
                                    <div class="mb-3 flex flex-col items-center justify-center min-h-[120px]">
                                        <img id="preview_pas_foto" 
                                             src="{{ (isset($peserta->pas_foto) && $peserta->pas_foto) ? asset('storage/' . $peserta->pas_foto) : '' }}" 
                                             alt="Preview Pas Foto" 
                                             class="h-24 w-24 object-cover rounded-full border-4 border-gray-300 shadow-md {{ (isset($peserta->pas_foto) && $peserta->pas_foto) ? '' : 'hidden' }}">
                                        
                                        @if(isset($peserta->pas_foto) && $peserta->pas_foto)
                                            <span id="badge_pas_foto" class="mt-2 text-xs font-bold text-green-600 bg-green-100 px-2 py-1 rounded-full flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                                Berkas Tersimpan
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <!-- name TETAP pas_foto -->
                                    <input type="file" name="pas_foto" id="pas_foto" onchange="previewImage(event, 'preview_pas_foto', 'badge_pas_foto')" class="block w-full text-xs text-gray-500 file:mr-2 file:py-2 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-oranye/10 file:text-oranye hover:file:bg-oranye hover:file:text-white cursor-pointer transition" accept=".jpg,.jpeg,.png">
                                    <p class="text-[10px] text-gray-400 mt-2 text-center">Format: JPG/PNG (Maks. 2MB)</p>
                                </div>

                                <!-- SCAN KTP -->
                                <div class="bg-gray-50 border border-gray-200 p-4 rounded-xl relative group hover:border-oranye transition duration-300 text-center flex flex-col items-center justify-between">
                                    <x-input-label value="Scan / Foto KTP Asli" class="font-bold text-hitam mb-3 text-center block" />
                                    
                                    <div class="mb-3 flex flex-col items-center justify-center min-h-[120px]">
                                        <img id="preview_ktp" 
                                             src="{{ ($peserta && $peserta->file_ktp) ? asset('storage/' . $peserta->file_ktp) : '' }}" 
                                             alt="Preview KTP" 
                                             class="h-16 w-24 object-cover rounded border-2 border-gray-300 shadow-sm {{ ($peserta && $peserta->file_ktp) ? '' : 'hidden' }}">
                                        
                                        <div id="icon_ktp" class="{{ ($peserta && $peserta->file_ktp) ? 'hidden' : 'h-16 w-24 bg-gray-100 rounded border-2 border-gray-300 flex items-center justify-center shadow-sm' }}">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                        </div>

                                        @if($peserta && $peserta->file_ktp)
                                            <span id="badge_ktp" class="mt-2 text-xs font-bold text-green-600 bg-green-100 px-2 py-1 rounded-full flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                                KTP Tersimpan
                                            </span>
                                            <a id="link_ktp" href="{{ asset('storage/' . $peserta->file_ktp) }}" target="_blank" class="text-[10px] text-blue-500 hover:underline mt-1">Lihat Berkas</a>
                                        @else
                                            <span id="badge_ktp" class="hidden"></span>
                                            <a id="link_ktp" class="hidden"></a>
                                        @endif
                                    </div>
                                    
                                    <input type="file" name="file_ktp" id="file_ktp" onchange="previewImage(event, 'preview_ktp', 'badge_ktp', 'icon_ktp', 'link_ktp')" class="block w-full text-xs text-gray-500 file:mr-2 file:py-2 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-oranye/10 file:text-oranye hover:file:bg-oranye hover:file:text-white cursor-pointer transition" accept=".jpg,.jpeg,.png">
                                    <p class="text-[10px] text-gray-400 mt-2 text-center">Format: JPG/PNG (Maks. 2MB)</p>
                                </div>

                                <!-- SCAN IJAZAH -->
                                <div class="bg-gray-50 border border-gray-200 p-4 rounded-xl relative group hover:border-oranye transition duration-300 text-center flex flex-col items-center justify-between">
                                    <x-input-label value="Scan Ijazah Terakhir" class="font-bold text-hitam mb-3 text-center block" />
                                    
                                    <div class="mb-3 flex flex-col items-center justify-center min-h-[120px]">
                                        <div id="preview_pdf_ijazah" class="{{ ($peserta && $peserta->file_ijazah && Str::endsWith($peserta->file_ijazah, '.pdf')) ? 'h-16 w-16 bg-red-100 rounded border-2 border-red-500 flex flex-col items-center justify-center shadow-sm' : 'hidden' }}">
                                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                            <span class="text-[8px] font-bold text-red-600 mt-1">PDF</span>
                                        </div>

                                        <img id="preview_ijazah" 
                                             src="{{ ($peserta && $peserta->file_ijazah && !Str::endsWith($peserta->file_ijazah, '.pdf')) ? asset('storage/' . $peserta->file_ijazah) : '' }}" 
                                             alt="Preview Ijazah" 
                                             class="h-16 w-20 object-cover rounded border-2 border-gray-300 shadow-sm {{ ($peserta && $peserta->file_ijazah && !Str::endsWith($peserta->file_ijazah, '.pdf')) ? '' : 'hidden' }}">
                                        
                                        <div id="icon_ijazah" class="{{ ($peserta && $peserta->file_ijazah) ? 'hidden' : 'h-16 w-16 bg-gray-100 rounded border-2 border-gray-300 flex items-center justify-center shadow-sm' }}">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        </div>

                                        @if($peserta && $peserta->file_ijazah)
                                            <span id="badge_ijazah" class="mt-2 text-xs font-bold text-green-600 bg-green-100 px-2 py-1 rounded-full flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                                Ijazah Tersimpan
                                            </span>
                                            <a id="link_ijazah" href="{{ asset('storage/' . $peserta->file_ijazah) }}" target="_blank" class="text-[10px] text-blue-500 hover:underline mt-1">Lihat Berkas</a>
                                        @else
                                            <span id="badge_ijazah" class="hidden"></span>
                                            <a id="link_ijazah" class="hidden"></a>
                                        @endif
                                    </div>
                                    
                                    <input type="file" name="file_ijazah" id="file_ijazah" onchange="previewImage(event, 'preview_ijazah', 'badge_ijazah', 'icon_ijazah', 'link_ijazah', 'preview_pdf_ijazah')" class="block w-full text-xs text-gray-500 file:mr-2 file:py-2 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-oranye/10 file:text-oranye hover:file:bg-oranye hover:file:text-white cursor-pointer transition" accept=".pdf,.jpg,.jpeg,.png">
                                    <p class="text-[10px] text-gray-400 mt-2 text-center">Format: PDF/JPG/PNG (Maks. 2MB)</p>
                                </div>

                                <!-- SERTIFIKAT PENDUKUNG (BARU) -->
                                <div class="bg-gray-50 border border-gray-200 p-4 rounded-xl relative group hover:border-oranye transition duration-300 text-center flex flex-col items-center justify-between">
                                    <x-input-label value="Sertifikat Pendukung" class="font-bold text-hitam mb-3 text-center block" />
                                    
                                    <div class="mb-3 flex flex-col items-center justify-center min-h-[120px]">
                                        <div id="preview_pdf_sertifikat" class="{{ ($peserta && $peserta->file_sertifikat_pendukung && Str::endsWith($peserta->file_sertifikat_pendukung, '.pdf')) ? 'h-16 w-16 bg-red-100 rounded border-2 border-red-500 flex flex-col items-center justify-center shadow-sm' : 'hidden' }}">
                                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                            <span class="text-[8px] font-bold text-red-600 mt-1">PDF</span>
                                        </div>
                                        <img id="preview_sertifikat" 
                                             src="{{ ($peserta && $peserta->file_sertifikat_pendukung && !Str::endsWith($peserta->file_sertifikat_pendukung, '.pdf')) ? asset('storage/' . $peserta->file_sertifikat_pendukung) : '' }}" 
                                             alt="Preview Sertifikat"
                                             class="h-16 w-20 object-cover rounded border-2 border-gray-300 shadow-sm {{ ($peserta && $peserta->file_sertifikat_pendukung && !Str::endsWith($peserta->file_sertifikat_pendukung, '.pdf')) ? '' : 'hidden' }}">
                                        <div id="icon_sertifikat" class="{{ ($peserta && $peserta->file_sertifikat_pendukung) ? 'hidden' : 'h-16 w-16 bg-gray-100 rounded border-2 border-gray-300 flex items-center justify-center shadow-sm' }}">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                                        </div>
                                        @if($peserta && $peserta->file_sertifikat_pendukung)
                                            <span id="badge_sertifikat" class="mt-2 text-xs font-bold text-green-600 bg-green-100 px-2 py-1 rounded-full flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                                Sertifikat Tersimpan
                                            </span>
                                            <a id="link_sertifikat" href="{{ asset('storage/' . $peserta->file_sertifikat_pendukung) }}" target="_blank" class="text-[10px] text-blue-500 hover:underline mt-1">Lihat Berkas</a>
                                        @else
                                            <span id="badge_sertifikat" class="hidden"></span>
                                            <a id="link_sertifikat" class="hidden"></a>
                                        @endif
                                    </div>
                                    <input type="file" name="file_sertifikat_pendukung" id="file_sertifikat_pendukung" onchange="previewImage(event, 'preview_sertifikat', 'badge_sertifikat', 'icon_sertifikat', 'link_sertifikat', 'preview_pdf_sertifikat')" class="block w-full text-xs text-gray-500 file:mr-2 file:py-2 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-oranye/10 file:text-oranye hover:file:bg-oranye hover:file:text-white cursor-pointer transition" accept=".pdf,.jpg,.jpeg,.png">
                                    <p class="text-[10px] text-gray-400 mt-2 text-center">Opsional. Format: PDF/JPG/PNG (Maks. 5MB)</p>
                                </div>

                            </div>
                            <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg text-xs text-blue-700 flex items-start gap-2">
                                <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p><strong>Penting:</strong> Jika Anda sudah pernah mengunggah berkas sebelumnya, Anda tidak perlu mengunggah ulang kecuali ingin mengganti berkas tersebut dengan yang baru.</p>
                            </div>
                        </div>

                        <!-- SECTION: DATA TAMBAHAN (BARU) -->
                        <div>
                            <h3 class="text-lg font-black text-hitam border-b border-gray-200 pb-2 mb-6 flex items-center gap-2">
                                <svg class="w-5 h-5 text-oranye" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                Data Tambahan & Keperluan
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                <div class="md:col-span-2">
                                    <x-input-label for="alamat_domisili" value="Alamat Domisili (jika berbeda dari KTP)" class="font-bold text-gray-700" />
                                    <textarea id="alamat_domisili" name="alamat_domisili" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-oranye focus:ring-oranye" placeholder="Kosongkan jika sama dengan alamat KTP">{{ old('alamat_domisili', $peserta->alamat_domisili ?? '') }}</textarea>
                                </div>

                                <div>
                                    <x-input-label for="status_perkawinan" value="Status Perkawinan" class="font-bold text-gray-700" />
                                    <select id="status_perkawinan" name="status_perkawinan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-oranye focus:ring-oranye">
                                        <option value="">-- Pilih Status --</option>
                                        @foreach(['Belum Menikah','Menikah','Cerai Hidup','Cerai Mati'] as $s)
                                            <option value="{{ $s }}" {{ old('status_perkawinan', $peserta->status_perkawinan ?? '') == $s ? 'selected' : '' }}>{{ $s }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <x-input-label for="perusahaan_terakhir" value="Perusahaan Terakhir Bekerja" class="font-bold text-gray-700" />
                                    <x-text-input id="perusahaan_terakhir" name="perusahaan_terakhir" type="text" class="mt-1 block w-full focus:border-oranye focus:ring-oranye" value="{{ old('perusahaan_terakhir', $peserta->perusahaan_terakhir ?? '') }}" placeholder="Nama perusahaan / Belum pernah bekerja" />
                                </div>

                                <div class="md:col-span-2">
                                    <x-input-label for="pengalaman_bekerja" value="Pengalaman Bekerja" class="font-bold text-gray-700" />
                                    <textarea id="pengalaman_bekerja" name="pengalaman_bekerja" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-oranye focus:ring-oranye" placeholder="Ceritakan pengalaman kerja Anda (posisi, bidang, lama bekerja), atau tulis 'Belum pernah bekerja'">{{ old('pengalaman_bekerja', $peserta->pengalaman_bekerja ?? '') }}</textarea>
                                </div>

                                <div class="md:col-span-2">
                                    <x-input-label for="keperluan_mendaftar" value="Keperluan / Tujuan Mendaftar" class="font-bold text-gray-700" />
                                    <textarea id="keperluan_mendaftar" name="keperluan_mendaftar" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-oranye focus:ring-oranye" placeholder="Contoh: Ingin meningkatkan skill dan mendapatkan pekerjaan di bidang otomotif...">{{ old('keperluan_mendaftar', $peserta->keperluan_mendaftar ?? '') }}</textarea>
                                </div>

                                <div class="md:col-span-2">
                                    <x-input-label for="rekomendasi_dari" value="Rekomendasi / Referensi Dari" class="font-bold text-gray-700" />
                                    <x-text-input id="rekomendasi_dari" name="rekomendasi_dari" type="text" class="mt-1 block w-full focus:border-oranye focus:ring-oranye" value="{{ old('rekomendasi_dari', $peserta->rekomendasi_dari ?? '') }}" placeholder="Contoh: Nama teman, media sosial, brosur, dll" />
                                </div>

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

    <!-- SCRIPT JAVASCRIPT UNTUK PREVIEW GAMBAR -->
    <script>
        function previewImage(event, previewId, badgeId, iconId = null, linkId = null, pdfPreviewId = null) {
            const input = event.target;
            const preview = document.getElementById(previewId);
            const badge = document.getElementById(badgeId);
            const icon = document.getElementById(iconId);
            const link = document.getElementById(linkId);
            const pdfPreview = document.getElementById(pdfPreviewId);

            if (input.files && input.files[0]) {
                const file = input.files[0];
                const fileType = file.type;

                // Sembunyikan badge & link yang lama agar user tahu ini adalah file baru
                if (badge) badge.classList.add('hidden');
                if (link) link.classList.add('hidden');
                if (icon) icon.classList.add('hidden');
                
                // Jika file adalah PDF
                if (fileType === 'application/pdf') {
                    if (preview) preview.classList.add('hidden'); // Sembunyikan image preview
                    if (pdfPreview) pdfPreview.classList.remove('hidden'); // Tampilkan icon PDF
                } else {
                    // Jika file adalah Gambar (JPG/PNG)
                    if (pdfPreview) pdfPreview.classList.add('hidden'); // Sembunyikan icon PDF
                    
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                        preview.classList.add('border-oranye'); // Ganti warna border jadi oranye saat file baru dipilih
                    }
                    reader.readAsDataURL(file);
                }
            } else {
                // Jika user membatalkan pilihan file, kembalikan ke kondisi semula
                if (preview) {
                    preview.src = '';
                    preview.classList.add('hidden');
                }
                if (pdfPreview) pdfPreview.classList.add('hidden');
                if (icon) icon.classList.remove('hidden');
            }
        }
    </script>
</x-app-layout>