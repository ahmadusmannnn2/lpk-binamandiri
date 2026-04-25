<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Detail Verifikasi Pendaftaran') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-oranye">
                <div class="p-8">
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
                                <h3 class="font-bold text-lg text-hitam border-b pb-2 mb-3">Informasi Peserta</h3>
                                <div class="flex items-center space-x-4 mb-4">
                                    @if($pendaftaran->peserta->pas_foto)
                                        <img src="{{ asset('storage/' . $pendaftaran->peserta->pas_foto) }}" class="w-16 h-16 rounded-full object-cover border-2 border-oranye">
                                    @else
                                        <div class="w-16 h-16 rounded-full bg-gray-300 flex items-center justify-center">No Pic</div>
                                    @endif
                                    <div>
                                        <p class="font-bold text-xl">{{ $pendaftaran->peserta->user->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $pendaftaran->peserta->user->email }}</p>
                                    </div>
                                </div>
                                <div class="text-sm space-y-1">
                                    <p><strong>NIK:</strong> {{ $pendaftaran->peserta->nik }}</p>
                                    <p><strong>No. HP/WA:</strong> {{ $pendaftaran->peserta->nomor_telepon }}</p>
                                    <p><strong>Alamat:</strong> {{ $pendaftaran->peserta->alamat }}</p>
                                </div>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
                                <h3 class="font-bold text-lg text-oranye border-b pb-2 mb-3">Informasi Kelas & Tagihan</h3>
                                <div class="text-sm space-y-2">
                                    <p><strong>Kelas:</strong> {{ $pendaftaran->kelas->nama_kelas }}</p>
                                    <p><strong>Program:</strong> {{ $pendaftaran->kelas->programPelatihan->nama_program }}</p>
                                    <p><strong>Tgl Daftar:</strong> {{ \Carbon\Carbon::parse($pendaftaran->tanggal_daftar)->format('d M Y') }}</p>
                                    <div class="mt-4 p-3 bg-yellow-100 rounded border border-yellow-300">
                                        <p class="text-gray-700 font-bold">Total yang harus dibayar:</p>
                                        <p class="text-2xl text-hitam font-extrabold">Rp {{ number_format($pendaftaran->kelas->programPelatihan->harga_pelatihan, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                                <h3 class="font-bold text-lg text-hitam border-b pb-2 mb-3">Bukti Pembayaran</h3>
                                @if($pendaftaran->bukti_pembayaran)
                                    <div class="border-2 border-dashed border-gray-300 p-2 rounded flex justify-center bg-gray-50">
                                        <a href="{{ asset('storage/' . $pendaftaran->bukti_pembayaran) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $pendaftaran->bukti_pembayaran) }}" alt="Bukti Transfer" class="max-h-64 object-contain hover:scale-105 transition transform cursor-pointer">
                                        </a>
                                    </div>
                                    <p class="text-xs text-center text-gray-500 mt-2">*Klik gambar untuk memperbesar</p>
                                @else
                                    <p class="text-red-500 italic">Peserta belum / gagal mengunggah bukti pembayaran.</p>
                                @endif
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg border border-oranye shadow-sm">
                                <h3 class="font-bold text-lg text-hitam border-b pb-2 mb-3">Aksi Verifikasi Admin</h3>
                                <form action="{{ route('admin.verifikasi.update', $pendaftaran->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="mb-4">
                                        <x-input-label for="status_pendaftaran" :value="__('Ubah Status Pendaftaran')" class="font-bold text-hitam" />
                                        <select name="status_pendaftaran" id="status_pendaftaran" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-oranye focus:ring-oranye font-bold">
                                            <option value="menunggu_verifikasi" {{ $pendaftaran->status_pendaftaran == 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi (Pending)</option>
                                            <option value="disetujui" {{ $pendaftaran->status_pendaftaran == 'disetujui' ? 'selected' : '' }}>DISETUJUI (Pembayaran Valid)</option>
                                            <option value="ditolak" {{ $pendaftaran->status_pendaftaran == 'ditolak' ? 'selected' : '' }}>DITOLAK (Bukti Tidak Valid / Kurang)</option>
                                        </select>
                                    </div>

                                    <div class="mb-6">
                                        <x-input-label for="keterangan_admin" :value="__('Catatan Admin (Opsional, wajib jika ditolak)')" class="font-bold text-hitam" />
                                        <textarea id="keterangan_admin" name="keterangan_admin" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-oranye focus:ring-oranye text-sm" placeholder="Misal: Bukti transfer buram, mohon upload ulang...">{{ old('keterangan_admin', $pendaftaran->keterangan_admin) }}</textarea>
                                    </div>

                                    <div class="flex justify-between items-center">
                                        <a href="{{ route('admin.verifikasi.index') }}" class="text-gray-500 hover:text-hitam font-bold">Kembali</a>
                                        <button type="submit" class="bg-hitam hover:bg-oranye text-white px-6 py-2 rounded shadow-lg transition transform hover:-translate-y-1 font-bold">
                                            Simpan Keputusan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>