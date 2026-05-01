<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.verifikasi_pembayaran.index') }}" class="text-gray-500 hover:text-oranye transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-xl text-hitam leading-tight">
                {{ __('Kelola Tagihan Pembayaran') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- KIRI: INFORMASI TAGIHAN -->
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white shadow-lg rounded-2xl p-8 border-t-4 border-hitam">
                    <h3 class="font-black text-lg text-hitam border-b pb-3 mb-6">Detail Tagihan Transaksi</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Nomor Order</p>
                            <p class="font-black text-hitam text-xl">LPK-{{ $pendaftaran->id }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Tanggal Dibuat</p>
                            <p class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($pendaftaran->tanggal_daftar)->format('d F Y, H:i') }} WIB</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 space-y-4">
                        <div class="flex justify-between items-center border-b pb-3">
                            <span class="font-bold text-gray-600">Nama Peserta</span>
                            <span class="font-black text-gray-800">{{ $pendaftaran->peserta->user->name }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b pb-3">
                            <span class="font-bold text-gray-600">NIK</span>
                            <span class="font-bold text-gray-800">{{ $pendaftaran->peserta->nik }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b pb-3">
                            <span class="font-bold text-gray-600">Program Pelatihan</span>
                            <span class="font-bold text-oranye">{{ $pendaftaran->kelas->programPelatihan->nama_program }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b pb-3">
                            <span class="font-bold text-gray-600">Metode Pembayaran</span>
                            <span class="font-bold text-blue-700 uppercase">{{ $pendaftaran->metode_pembayaran ?? 'Menunggu Pembayaran' }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-2">
                            <span class="font-black text-lg text-gray-800">Total Tagihan</span>
                            <span class="font-black text-2xl text-red-600">Rp {{ number_format($pendaftaran->kelas->programPelatihan->harga_pelatihan ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KANAN: PANEL AKSI (SESUAI STATUS) -->
            <div class="md:col-span-1">
                <div class="bg-white shadow-xl rounded-2xl p-6 sticky top-6">
                    <h3 class="font-black text-lg text-hitam border-b pb-3 mb-6">Aksi & Keputusan</h3>
                    
                    @if($pendaftaran->status_pembayaran == 'sukses')
                        <!-- JIKA SUDAH LUNAS: Hanya tampilkan tombol cetak -->
                        <div class="bg-green-50 border border-green-200 rounded-xl p-5 text-center mb-6">
                            <svg class="w-12 h-12 text-green-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <h4 class="font-black text-green-800 text-lg mb-1">Transaksi Lunas</h4>
                            <p class="text-xs text-green-700 font-bold mb-2">{{ \Carbon\Carbon::parse($pendaftaran->waktu_pembayaran)->format('d M Y - H:i') }} WIB</p>
                            <p class="text-xs text-green-600">Pembayaran telah terverifikasi secara otomatis oleh sistem.</p>
                        </div>

                        <a href="{{ route('admin.verifikasi_pembayaran.cetak_kwitansi', $pendaftaran->id) }}" target="_blank" class="w-full flex items-center justify-center gap-2 bg-[#de5e2e] hover:bg-[#c24b22] text-white py-3 rounded-xl font-bold shadow-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Cetak Kwitansi Resmi
                        </a>
                    @else
                        <!-- JIKA MASIH PENDING: Tampilkan form override manual -->
                        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5 text-center mb-6">
                            <svg class="w-12 h-12 text-yellow-500 mx-auto mb-3 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <h4 class="font-black text-yellow-800 text-lg mb-1">Status: Menunggu</h4>
                            <p class="text-xs text-yellow-700">Sistem Midtrans masih menunggu pembayaran dari peserta.</p>
                        </div>

                        <div class="border-t border-gray-200 pt-6">
                            <p class="text-xs font-bold text-gray-500 mb-4 uppercase tracking-wider">Verifikasi Manual Admin</p>
                            <form action="{{ route('admin.verifikasi_pembayaran.update', $pendaftaran->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status_pendaftaran" value="disetujui">
                                <input type="hidden" name="status_pembayaran" value="sukses">

                                <button type="submit" onclick="return confirm('PERINGATAN: Apakah Anda yakin ingin memaksakan status menjadi LUNAS secara manual? Lakukan ini HANYA JIKA uang peserta sudah benar-benar masuk ke rekening/kasir namun sistem Midtrans mengalami gangguan.');" class="w-full bg-hitam text-white py-3 rounded-xl font-bold hover:bg-gray-800 transition shadow flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Konfirmasi Lunas Manual
                                </button>
                            </form>
                            <p class="text-[10px] text-gray-400 mt-3 text-center italic">*Tombol cetak kwitansi akan muncul setelah status pembayaran menjadi LUNAS.</p>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>