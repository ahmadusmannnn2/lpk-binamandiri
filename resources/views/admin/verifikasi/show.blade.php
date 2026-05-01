<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.verifikasi.index') }}" class="text-gray-500 hover:text-oranye transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-xl text-hitam leading-tight">
                {{ __('Pengecekan Biodata & Berkas') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- KIRI: DATA DIRI & FOTO -->
            <div class="md:col-span-2 space-y-6">
                <!-- PANEL BIODATA LENGKAP -->
                <div class="bg-white shadow-lg rounded-2xl p-8 border-t-4 border-oranye">
                    <h3 class="font-black text-lg text-hitam border-b pb-3 mb-6">Informasi Biodata Lengkap</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Nama Lengkap</p>
                            <p class="font-bold text-hitam text-lg">{{ $peserta->user->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">NIK</p>
                            <p class="font-bold text-hitam text-lg">{{ $peserta->nik ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Tempat, Tanggal Lahir</p>
                            <p class="font-medium text-gray-800">
                                {{ $peserta->tempat_lahir ?? '-' }}, 
                                {{ $peserta->tanggal_lahir ? \Carbon\Carbon::parse($peserta->tanggal_lahir)->format('d M Y') : '-' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Jenis Kelamin</p>
                            <p class="font-medium text-gray-800">{{ $peserta->jenis_kelamin ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Nomor HP/WhatsApp</p>
                            <p class="font-medium text-gray-800">{{ $peserta->nomor_telepon ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Pendidikan Terakhir</p>
                            <p class="font-medium text-gray-800">{{ $peserta->pendidikan_terakhir ?? '-' }}</p>
                        </div>
                        <div class="sm:col-span-2">
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Alamat Lengkap</p>
                            <p class="font-medium text-gray-800">{{ $peserta->alamat ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- PANEL LAMPIRAN 3 BERKAS -->
                <div class="bg-white shadow-lg rounded-2xl p-8">
                    <h3 class="font-black text-lg text-hitam border-b pb-3 mb-6">Lampiran Dokumen</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        
                        <!-- Pas Foto -->
                        <div class="border rounded-xl p-3 text-center bg-gray-50 hover:border-oranye transition duration-300">
                            <p class="text-sm font-bold text-hitam mb-2">Pas Foto</p>
                            @if($peserta->pas_foto)
                                <a href="{{ asset('storage/'.$peserta->pas_foto) }}" target="_blank" class="block overflow-hidden rounded-lg shadow-sm border border-gray-300 h-48 group relative">
                                    <img src="{{ asset('storage/'.$peserta->pas_foto) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition duration-300 text-white text-xs font-bold">Perbesar</div>
                                </a>
                            @else
                                <div class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400 text-sm italic">Belum diunggah</div>
                            @endif
                        </div>

                        <!-- KTP -->
                        <div class="border rounded-xl p-3 text-center bg-gray-50 hover:border-oranye transition duration-300">
                            <p class="text-sm font-bold text-hitam mb-2">Scan KTP</p>
                            @if($peserta->file_ktp)
                                <a href="{{ asset('storage/'.$peserta->file_ktp) }}" target="_blank" class="block overflow-hidden rounded-lg shadow-sm border border-gray-300 h-48 group relative">
                                    <img src="{{ asset('storage/'.$peserta->file_ktp) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition duration-300 text-white text-xs font-bold">Perbesar</div>
                                </a>
                            @else
                                <div class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400 text-sm italic">Belum diunggah</div>
                            @endif
                        </div>

                        <!-- Ijazah -->
                        <div class="border rounded-xl p-3 text-center bg-gray-50 hover:border-oranye transition duration-300">
                            <p class="text-sm font-bold text-hitam mb-2">Scan Ijazah</p>
                            @if($peserta->file_ijazah)
                                <a href="{{ asset('storage/'.$peserta->file_ijazah) }}" target="_blank" class="block overflow-hidden rounded-lg shadow-sm border border-gray-300 h-48 group relative bg-white">
                                    @if(pathinfo($peserta->file_ijazah, PATHINFO_EXTENSION) == 'pdf')
                                        <div class="w-full h-full flex flex-col items-center justify-center text-red-500">
                                            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.25 17.292l-4.5-4.364 1.857-1.857 2.643 2.506 5.643-5.784 1.857 1.857-7.5 7.642z"/></svg>
                                            <span class="mt-2 text-xs font-bold text-gray-700">File PDF</span>
                                        </div>
                                    @else
                                        <img src="{{ asset('storage/'.$peserta->file_ijazah) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                    @endif
                                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition duration-300 text-white text-xs font-bold">Buka Berkas</div>
                                </a>
                            @else
                                <div class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400 text-sm italic">Belum diunggah</div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

            <!-- KANAN: PANEL KEPUTUSAN ADMIN -->
            <div class="md:col-span-1">
                <div class="bg-white shadow-xl rounded-2xl p-6 sticky top-6">
                    <h3 class="font-black text-lg text-hitam border-b pb-3 mb-4">Keputusan Verifikasi</h3>
                    
                    <form action="{{ route('admin.verifikasi.update', $peserta->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4 mb-6">
                            <label class="flex items-center p-4 border rounded-xl cursor-pointer hover:bg-green-50 hover:border-green-400 transition {{ $peserta->status_biodata == 'disetujui' ? 'bg-green-50 border-green-500' : '' }}">
                                <input type="radio" name="status_biodata" value="disetujui" class="w-5 h-5 text-green-600 focus:ring-green-500" onchange="toggleCatatan()" {{ $peserta->status_biodata == 'disetujui' ? 'checked' : '' }} required>
                                <div class="ml-3">
                                    <span class="block font-bold text-green-700">Setujui Berkas</span>
                                    <span class="block text-xs text-gray-500">Peserta diizinkan daftar kelas.</span>
                                </div>
                            </label>

                            <label class="flex items-center p-4 border rounded-xl cursor-pointer hover:bg-red-50 hover:border-red-400 transition {{ $peserta->status_biodata == 'ditolak' ? 'bg-red-50 border-red-500' : '' }}">
                                <input type="radio" name="status_biodata" value="ditolak" class="w-5 h-5 text-red-600 focus:ring-red-500" onchange="toggleCatatan()" {{ $peserta->status_biodata == 'ditolak' ? 'checked' : '' }} required>
                                <div class="ml-3">
                                    <span class="block font-bold text-red-700">Tolak Berkas</span>
                                    <span class="block text-xs text-gray-500">Berkas tidak valid / buram.</span>
                                </div>
                            </label>
                        </div>

                        <!-- Form Catatan (Muncul Otomatis Jika Ditolak) -->
                        <div id="catatan_box" class="mb-6 {{ $peserta->status_biodata == 'ditolak' ? 'block' : 'hidden' }}">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Alasan Penolakan <span class="text-red-500">*</span></label>
                            <textarea name="catatan_biodata" id="catatan_input" rows="3" class="w-full border-gray-300 focus:ring-oranye focus:border-oranye rounded-lg shadow-sm" placeholder="Contoh: Scan KTP terlalu buram, mohon foto ulang...">{{ $peserta->catatan_biodata }}</textarea>
                        </div>

                        <button type="submit" class="w-full bg-hitam text-white py-3 rounded-xl font-bold hover:bg-oranye transition shadow-lg flex justify-center items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            Simpan Keputusan
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- Script pemuncul catatan -->
    <script>
        function toggleCatatan() {
            var tolakRadio = document.querySelector('input[name="status_biodata"][value="ditolak"]');
            var catatanBox = document.getElementById('catatan_box');
            var catatanInput = document.getElementById('catatan_input');
            
            if (tolakRadio.checked) {
                catatanBox.classList.remove('hidden');
                catatanInput.required = true;
            } else {
                catatanBox.classList.add('hidden');
                catatanInput.required = false;
                catatanInput.value = ''; // Kosongkan catatan jika diubah ke setuju
            }
        }
    </script>
</x-app-layout>