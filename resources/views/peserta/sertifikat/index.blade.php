<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Sertifikat Kelulusan') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-oranye">
                <div class="p-8">
                    <p class="text-gray-500 mb-6 pb-4 border-b">Berikut adalah daftar sertifikat dari kelas pelatihan yang telah berhasil Anda selesaikan dengan status <strong class="text-green-600">LULUS</strong>.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($sertifikat as $item)
                            <div class="relative bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-300 rounded-xl p-6 shadow hover:shadow-lg transition">
                                <div class="absolute -top-3 -right-3 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">LULUS</div>
                                
                                <div class="text-center mb-4">
                                    <div class="w-16 h-16 mx-auto bg-oranye rounded-full flex items-center justify-center text-white mb-2 shadow">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <h4 class="font-extrabold text-hitam text-lg leading-tight">{{ $item->kelas->programPelatihan->nama_program }}</h4>
                                    <p class="text-xs text-oranye font-bold mt-1">{{ $item->kelas->nama_kelas }}</p>
                                </div>
                                
                                <div class="text-sm text-gray-600 space-y-1 mb-6 text-center border-t border-b py-3">
                                    <p><strong>Nilai Teori:</strong> {{ $item->nilai_teori }}</p>
                                    <p><strong>Nilai Praktik:</strong> {{ $item->nilai_praktik }}</p>
                                    <p><strong>Tgl Lulus:</strong> {{ \Carbon\Carbon::parse($item->updated_at)->format('d F Y') }}</p>
                                </div>
                                
                                <a href="{{ route('peserta.sertifikat.cetak', $item->id) }}" target="_blank" class="block w-full text-center bg-hitam text-white px-4 py-2 rounded-lg hover:bg-oranye transition font-bold shadow-md">
                                    Lihat & Cetak PDF
                                </a>
                            </div>
                        @empty
                            <div class="col-span-3 text-center py-10">
                                <div class="inline-block p-4 rounded-full bg-gray-100 mb-4">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </div>
                                <p class="text-gray-500 italic">Belum ada sertifikat. Selesaikan kelas Anda dengan nilai yang memenuhi standar kelulusan.</p>
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>