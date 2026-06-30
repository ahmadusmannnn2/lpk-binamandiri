<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('peserta.riwayat.index') }}" class="text-gray-500 hover:text-oranye transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-xl text-hitam leading-tight">
                {{ __('Detail Pendaftaran & Tagihan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white shadow-lg rounded-2xl p-8 border-t-4 border-oranye">
                    <h3 class="font-black text-lg text-hitam border-b pb-3 mb-6">Informasi Transaksi</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Nomor Order</p>
                            <p class="font-black text-hitam text-xl">LPK-{{ $pendaftaran->id }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Waktu Pemesanan</p>
                            <p class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($pendaftaran->tanggal_daftar)->format('d F Y, H:i') }} WIB</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 space-y-4">
                        <div class="flex justify-between items-center border-b pb-3">
                            <span class="font-bold text-gray-600">Program Pelatihan</span>
                            <span class="font-bold text-oranye">{{ $pendaftaran->kelas->programPelatihan->nama_program }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b pb-3">
                            <span class="font-bold text-gray-600">Kelas / Angkatan</span>
                            <span class="font-bold text-gray-800">{{ $pendaftaran->kelas->nama_kelas }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b pb-3">
                            <span class="font-bold text-gray-600">Metode Pembayaran</span>
                            <span class="font-bold text-blue-700 uppercase">{{ $pendaftaran->metode_pembayaran ?? 'Pilih Saat Bayar' }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-2">
                            <span class="font-black text-lg text-gray-800">Total Tagihan</span>
                            <span class="font-black text-2xl text-red-600">Rp {{ number_format($pendaftaran->kelas->programPelatihan->harga_pelatihan ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PANEL KANAN: TOMBOL AKSI -->
            <div class="md:col-span-1">
                <div class="bg-white shadow-xl rounded-2xl p-6 sticky top-6">
                    <h3 class="font-black text-lg text-hitam border-b pb-3 mb-6">Status Pembayaran</h3>
                    
                    @if($pendaftaran->status_pembayaran == 'sukses')
                        <div class="bg-green-50 border border-green-200 rounded-xl p-5 text-center mb-6">
                            <svg class="w-12 h-12 text-green-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <h4 class="font-black text-green-800 text-lg mb-1">LUNAS</h4>
                            <p class="text-xs text-green-700 font-bold mb-2">{{ \Carbon\Carbon::parse($pendaftaran->waktu_pembayaran)->format('d M Y - H:i') }} WIB</p>
                        </div>
                        <a href="{{ route('peserta.riwayat.cetak', $pendaftaran->id) }}" target="_blank" class="w-full flex items-center justify-center gap-2 bg-[#de5e2e] hover:bg-[#c24b22] text-white py-3 rounded-xl font-bold shadow-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Download Kwitansi
                        </a>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5 text-center mb-6">
                            <h4 class="font-black text-yellow-800 text-lg mb-1">BELUM DIBAYAR</h4>
                            <p class="text-xs text-yellow-700">Selesaikan pembayaran untuk mulai belajar.</p>
                        </div>
                        <a href="{{ route('peserta.pembayaran.bayar', $pendaftaran->id) }}" class="w-full flex items-center justify-center gap-2 bg-hitam hover:bg-gray-800 text-white py-3 rounded-xl font-bold shadow-lg transition mb-3">
                            Lanjutkan Pembayaran
                        </a>
                        <form action="{{ route('peserta.riwayat.destroy', $pendaftaran->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin membatalkan dan menghapus pendaftaran ini? Tindakan ini tidak dapat dibatalkan.')" class="w-full flex items-center justify-center gap-2 bg-red-50 hover:bg-red-100 border border-red-200 text-red-600 py-3 rounded-xl font-bold transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Batalkan Pendaftaran
                            </button>
                        </form>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>