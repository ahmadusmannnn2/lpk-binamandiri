<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Form Pendaftaran & Pembayaran') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-oranye">
                <div class="p-8">
                    
                    <div class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h3 class="font-bold text-lg text-hitam mb-2">Detail Tagihan</h3>
                        <div class="text-sm space-y-2">
                            <p><strong>Kelas:</strong> {{ $kelas->nama_kelas }}</p>
                            <p><strong>Program:</strong> {{ $kelas->programPelatihan->nama_program }}</p>
                            <p class="text-lg mt-2"><strong>Total Pembayaran:</strong> <span class="text-oranye font-bold text-xl">Rp {{ number_format($kelas->programPelatihan->harga_pelatihan, 0, ',', '.') }}</span></p>
                            <p class="text-red-500 italic mt-2">*Silakan transfer ke Rekening LPK Bina Mandiri: <strong>BCA 123456789 a.n LPK Bina Mandiri</strong></p>
                        </div>
                    </div>

                    <form action="{{ route('peserta.pendaftaran.store', $kelas->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-6">
                            <x-input-label for="bukti_pembayaran" :value="__('Upload Bukti Transfer / Pembayaran (Max 2MB, JPG/PNG)')" class="text-hitam font-bold" />
                            <input id="bukti_pembayaran" type="file" name="bukti_pembayaran" accept="image/*" class="block w-full text-sm text-gray-500 mt-2 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-oranye file:text-white hover:file:bg-[#c24b22] transition" required />
                            <x-input-error :messages="$errors->get('bukti_pembayaran')" class="mt-2" />
                        </div>

                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('peserta.pendaftaran.index') }}" class="text-gray-500 hover:text-hitam font-bold py-2 px-4">Batal</a>
                            <button type="submit" class="bg-hitam text-white px-6 py-2 rounded hover:bg-oranye transition shadow-lg font-bold">Kirim Bukti & Daftar</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>