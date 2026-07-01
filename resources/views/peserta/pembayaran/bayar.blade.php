<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">
            {{ __('Selesaikan Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl border-t-4 border-oranye relative">
                <!-- Ornamen Background -->
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-oranye opacity-10 rounded-full blur-2xl pointer-events-none"></div>
                
                <div class="p-8 sm:p-12 relative z-10">
                    <div class="text-center mb-10">
                        <div class="w-20 h-20 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-4 border-2 border-orange-100 shadow-sm">
                            <svg class="w-10 h-10 text-oranye" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-black text-hitam">Detail Tagihan Pelatihan</h3>
                        <p class="text-gray-500 mt-2">Selesaikan pembayaran untuk mengamankan kursi Anda di kelas ini.</p>
                    </div>

                    <div class="bg-gray-50 rounded-2xl border border-gray-200 p-6 mb-8">
                        <div class="space-y-4">
                            <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                                <span class="text-gray-500 font-medium">Program Pelatihan</span>
                                <span class="font-bold text-hitam text-right">{{ $pendaftaran->kelas->programPelatihan->nama_program ?? 'Program LPK' }}</span>
                            </div>
                            <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                                <span class="text-gray-500 font-medium">Pilihan Kelas</span>
                                <span class="font-bold text-hitam">{{ $pendaftaran->kelas->nama_kelas ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                                <span class="text-gray-500 font-medium">Nama Peserta</span>
                                <span class="font-bold text-hitam">{{ Auth::user()->name }}</span>
                            </div>
                            <div class="flex justify-between items-center pt-2 text-lg">
                                <span class="text-hitam font-black">Total Tagihan</span>
                                <span class="font-black text-oranye text-2xl">Rp {{ number_format($pendaftaran->kelas->programPelatihan->harga_pelatihan ?? 500000, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button id="pay-button" class="w-full sm:w-auto px-12 py-4 bg-hitam text-white hover:bg-oranye font-black rounded-xl shadow-lg transition transform hover:-translate-y-1 text-lg flex items-center justify-center gap-3 mx-auto">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            BAYAR SEKARANG
                        </button>
                        <p class="text-xs text-gray-400 mt-4 flex items-center justify-center gap-1 font-bold">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Pembayaran Aman Terenkripsi oleh Midtrans
                        </p>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <!-- SCRIPT WAJIB DARI MIDTRANS -->
    <script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script type="text/javascript">
        const pendaftaranId = {{ $pendaftaran->id }};
        const csrfToken = document.querySelector('meta[name="csrf-token"]')
            ? document.querySelector('meta[name="csrf-token"]').content
            : '{{ csrf_token() }}';

        document.getElementById('pay-button').onclick = function () {
            snap.pay('{{ $pendaftaran->snap_token }}', {
                onSuccess: function(result) {
                    // Kirim ke server untuk verifikasi & update status DB
                    fetch('{{ route("peserta.pembayaran.finish") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({ pendaftaran_id: pendaftaranId })
                    })
                    .then(res => res.json())
                    .then(data => {
                        console.log('Finish response:', data);
                        window.location.href = "{{ route('peserta.riwayat.index') }}?bayar=sukses";
                    })
                    .catch(err => {
                        console.error('Finish error:', err);
                        // Tetap redirect meski ada error fetch
                        window.location.href = "{{ route('peserta.riwayat.index') }}?bayar=sukses";
                    });
                },
                onPending: function(result) {
                    alert("Silakan selesaikan pembayaran sesuai instruksi. Status akan diperbarui otomatis.");
                    window.location.href = "{{ route('peserta.riwayat.index') }}";
                },
                onError: function(result) {
                    alert("Pembayaran gagal. Silakan coba lagi.");
                },
                onClose: function() {
                    // Tidak perlu alert, biarkan user bisa coba lagi
                }
            });
        };
    </script>
</x-app-layout>