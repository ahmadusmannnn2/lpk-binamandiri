<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.verifikasi.index') }}" class="text-gray-500 hover:text-oranye transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-xl text-hitam leading-tight">
                {{ __('Detail Verifikasi Pendaftaran') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-oranye">
                <div class="p-6 sm:p-10">
                    
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-gray-200 pb-6 mb-6 gap-4">
                        <div class="flex items-center gap-4">
                            @if($pendaftaran->peserta->pas_foto)
                                <img src="{{ asset('storage/' . $pendaftaran->peserta->pas_foto) }}" alt="Foto Peserta" class="w-16 h-16 rounded-full object-cover border-2 border-oranye shadow-sm">
                            @else
                                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center border-2 border-dashed border-gray-300 font-bold text-gray-400">No Pic</div>
                            @endif
                            <div>
                                <h3 class="text-2xl font-black text-hitam">{{ $pendaftaran->peserta->user->name }}</h3>
                                <p class="text-gray-500 font-medium">{{ $pendaftaran->peserta->user->email }} | {{ $pendaftaran->peserta->nomor_telepon }}</p>
                            </div>
                        </div>
                        <div class="text-left md:text-right">
                            <p class="text-xs text-gray-400 uppercase tracking-wider font-bold mb-1">Status Saat Ini</p>
                            @if($pendaftaran->status_pendaftaran == 'menunggu_verifikasi')
                                <span class="bg-yellow-100 text-yellow-800 px-4 py-1.5 rounded-full text-sm font-bold border border-yellow-200 shadow-sm">Menunggu Verifikasi</span>
                            @elseif($pendaftaran->status_pendaftaran == 'disetujui')
                                <span class="bg-green-100 text-green-800 px-4 py-1.5 rounded-full text-sm font-bold border border-green-200 shadow-sm">Disetujui</span>
                            @else
                                <span class="bg-red-100 text-red-800 px-4 py-1.5 rounded-full text-sm font-bold border border-red-200 shadow-sm">Ditolak</span>
                            @endif
                        </div>
                    </div>

                    <div class="bg-hitam text-white p-6 rounded-xl shadow-md mb-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Program yang Diambil</p>
                            <p class="font-bold text-oranye text-lg">{{ $pendaftaran->kelas->programPelatihan->nama_program ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Angkatan / Kelas</p>
                            <p class="font-bold text-lg">{{ $pendaftaran->kelas->nama_kelas ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Waktu Mendaftar</p>
                            <p class="font-bold text-lg">{{ \Carbon\Carbon::parse($pendaftaran->tanggal_daftar)->format('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    <h4 class="font-black text-lg text-hitam mb-4 border-b pb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-oranye" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                        Pengecekan Berkas & Pembayaran
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                        <div class="border border-gray-200 rounded-xl p-4 text-center bg-gray-50 hover:border-oranye transition duration-300">
                            <p class="font-bold text-hitam mb-2">Bukti Pembayaran</p>
                            @if($pendaftaran->bukti_pembayaran)
                                <a href="{{ asset('storage/' . $pendaftaran->bukti_pembayaran) }}" target="_blank" class="block overflow-hidden rounded-lg shadow-sm border border-gray-300 h-48 group relative">
                                    <img src="{{ asset('storage/' . $pendaftaran->bukti_pembayaran) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition duration-300 text-white font-bold">Klik untuk Perbesar</div>
                                </a>
                            @else
                                <div class="h-48 flex items-center justify-center bg-gray-200 rounded-lg text-gray-500 text-sm italic">Belum diunggah</div>
                            @endif
                        </div>

                        <div class="border border-gray-200 rounded-xl p-4 text-center bg-gray-50 hover:border-oranye transition duration-300">
                            <p class="font-bold text-hitam mb-2">Scan KTP</p>
                            @if($pendaftaran->peserta->file_ktp)
                                <a href="{{ asset('storage/' . $pendaftaran->peserta->file_ktp) }}" target="_blank" class="block overflow-hidden rounded-lg shadow-sm border border-gray-300 h-48 group relative">
                                    <img src="{{ asset('storage/' . $pendaftaran->peserta->file_ktp) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition duration-300 text-white font-bold">Klik untuk Perbesar</div>
                                </a>
                            @else
                                <div class="h-48 flex items-center justify-center bg-gray-200 rounded-lg text-gray-500 text-sm italic">Belum diunggah</div>
                            @endif
                        </div>

                        <div class="border border-gray-200 rounded-xl p-4 text-center bg-gray-50 hover:border-oranye transition duration-300">
                            <p class="font-bold text-hitam mb-2">Scan Ijazah Terakhir</p>
                            @if($pendaftaran->peserta->file_ijazah)
                                <a href="{{ asset('storage/' . $pendaftaran->peserta->file_ijazah) }}" target="_blank" class="block overflow-hidden rounded-lg shadow-sm border border-gray-300 h-48 group relative bg-white">
                                    @if(pathinfo($pendaftaran->peserta->file_ijazah, PATHINFO_EXTENSION) == 'pdf')
                                        <div class="w-full h-full flex flex-col items-center justify-center text-red-500">
                                            <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.25 17.292l-4.5-4.364 1.857-1.857 2.643 2.506 5.643-5.784 1.857 1.857-7.5 7.642z"/></svg>
                                            <span class="mt-2 text-sm font-bold text-gray-700">Dokumen PDF</span>
                                        </div>
                                    @else
                                        <img src="{{ asset('storage/' . $pendaftaran->peserta->file_ijazah) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                    @endif
                                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition duration-300 text-white font-bold">Klik untuk Lihat Berkas</div>
                                </a>
                            @else
                                <div class="h-48 flex items-center justify-center bg-gray-200 rounded-lg text-gray-500 text-sm italic">Belum diunggah</div>
                            @endif
                        </div>
                    </div>

                    @if($pendaftaran->status_pendaftaran == 'menunggu_verifikasi')
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 text-center">
                            <h4 class="font-black text-blue-900 mb-2">Keputusan Verifikasi</h4>
                            <p class="text-sm text-blue-700 mb-6">Pastikan bukti pembayaran sesuai dengan tagihan, dan identitas KTP/Ijazah valid sebelum menyetujui pendaftaran ini.</p>
                            
                            <form action="{{ route('admin.verifikasi.update', $pendaftaran->id) }}" method="POST" class="flex justify-center gap-4">
                                @csrf
                                @method('PUT')
                                <button type="submit" name="status_pendaftaran" value="ditolak" class="bg-white border-2 border-red-500 text-red-600 hover:bg-red-500 hover:text-white px-8 py-3 rounded-xl font-bold shadow-sm transition duration-300" onclick="return confirm('Yakin ingin MENOLAK pendaftaran ini?');">Tolak Pendaftaran</button>
                                <button type="submit" name="status_pendaftaran" value="disetujui" class="bg-oranye hover:bg-[#c24b22] text-white border-2 border-oranye hover:border-[#c24b22] px-8 py-3 rounded-xl font-bold shadow-lg transition duration-300 transform hover:-translate-y-1" onclick="return confirm('Yakin ingin MENYETUJUI pendaftaran ini?');">Setujui & Masukkan ke Kelas</button>
                            </form>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>