<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('peserta.pendaftaran.index') }}" class="text-gray-500 hover:text-oranye transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="font-bold text-xl text-hitam leading-tight">
                {{ __('Pilih Angkatan/Kelas') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if(!$peserta || empty($peserta->nik) || empty($peserta->file_ktp))
                <div
                    class="mb-6 bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-r-lg shadow-sm flex items-start gap-3">
                    <svg class="w-6 h-6 text-yellow-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                    <div>
                        <h4 class="font-bold text-yellow-800">Perhatian!</h4>
                        <p class="text-sm text-yellow-700 mt-1">Biodata dan berkas persyaratan Anda belum lengkap. Silakan
                            <a href="{{ route('peserta.biodata.index') }}"
                                class="font-bold underline hover:text-oranye">lengkapi biodata</a> terlebih dahulu agar
                            proses pendaftaran berjalan lancar.</p>
                    </div>
                </div>
            @endif

            <div class="bg-hitam rounded-2xl shadow-xl p-8 mb-8 text-white relative overflow-hidden">
                <div class="absolute -right-10 -top-10 opacity-10">
                    <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L2 7l10 5 10-5-10-5zm0 7l-10 5 10 5 10-5-10-5zm0 7l-10 5 10 5 10-5-10-5z"></path>
                    </svg>
                </div>
                <div class="relative z-10">
                    <span
                        class="bg-oranye text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-widest">Detail
                        Program</span>
                    <h3 class="text-3xl font-black mt-3 mb-2">{{ $program->nama_program }}</h3>
                    <p class="text-gray-300 max-w-2xl leading-relaxed">
                        {{ $program->deskripsi ?? 'Deskripsi program tidak tersedia.' }}</p>
                </div>
            </div>

            <div class="space-y-6">
                <h4 class="font-bold text-lg text-gray-700 flex items-center gap-2">
                    <svg class="w-5 h-5 text-oranye" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                    Daftar Kelas & Angkatan yang Tersedia
                </h4>

                @forelse($kelas as $k)
                    <div
                        class="bg-white rounded-xl shadow-md border border-gray-100 p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 hover:border-oranye transition duration-300 group">

                        <div class="flex-1 space-y-3">
                            <h5 class="text-xl font-black text-hitam">{{ $k->nama_kelas }}</h5>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-2 gap-x-4 text-sm text-gray-600">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-oranye" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span class="font-medium">Instruktur:</span>
                                    {{ $k->instruktur->user->name ?? 'Belum Ditentukan' }}
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-oranye" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                    <span class="font-medium">Kuota Maksimal:</span> {{ $k->kuota_peserta ?? '-' }} Orang
                                </div>
                                <div class="flex items-center gap-2 sm:col-span-2">
                                    <svg class="w-4 h-4 text-oranye" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span class="font-medium">Jadwal Mulai:</span>
                                    {{ $k->tanggal_mulai ? \Carbon\Carbon::parse($k->tanggal_mulai)->format('d M Y') : 'Menyusul' }}
                                    -
                                    {{ $k->tanggal_selesai ? \Carbon\Carbon::parse($k->tanggal_selesai)->format('d M Y') : 'Menyusul' }}
                                </div>
                            </div>
                        </div>

                        <div
                            class="w-full md:w-auto flex flex-col items-start md:items-end gap-3 border-t md:border-t-0 md:border-l border-gray-100 pt-4 md:pt-0 md:pl-6">
                            <div class="text-left md:text-right">
                                <span class="block text-xs text-gray-400 font-bold uppercase tracking-wider mb-1">Biaya
                                    Pelatihan</span>
                                <span class="text-2xl font-black text-hitam">Rp {{ number_format($k->programPelatihan->harga_pelatihan ?? 0, 0, ',', '.') }}</span>
                            </div>

                            <!-- CONTOH YANG BENAR -->
                            <a href="{{ route('peserta.pendaftaran.create', $k->id) }}"
                                class="bg-oranye text-white font-bold py-2 px-4 rounded hover:bg-hitam transition">
                                Daftar Sekarang
                            </a>
                        </div>

                    </div>
                @empty
                    <div class="bg-white p-10 rounded-2xl shadow-sm border border-gray-200 text-center">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h4 class="text-lg font-bold text-gray-500">Belum ada angkatan/kelas yang dibuka untuk program ini.
                        </h4>
                        <p class="text-sm text-gray-400 mt-2">Silakan cek kembali secara berkala atau pilih program unggulan
                            lainnya.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>