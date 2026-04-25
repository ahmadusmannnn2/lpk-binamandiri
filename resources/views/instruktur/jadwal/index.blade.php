<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Jadwal Mengajar Saya') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-oranye">
                <div class="p-6">
                    <p class="text-gray-500 mb-6">Berikut adalah daftar kelas pelatihan yang ditugaskan kepada Anda.
                        Pilih kelas untuk melihat peserta dan mengisi nilai.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($kelas as $item)
                            <div
                                class="bg-gray-50 border border-gray-200 rounded-lg p-5 shadow-sm hover:shadow-md transition">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-bold text-lg text-hitam">{{ $item->nama_kelas }}</h4>
                                    @if($item->status_kelas == 'menunggu')
                                        <span
                                            class="bg-yellow-200 text-yellow-800 py-1 px-2 rounded text-xs font-bold">Menunggu</span>
                                    @elseif($item->status_kelas == 'berjalan')
                                        <span
                                            class="bg-green-200 text-green-800 py-1 px-2 rounded text-xs font-bold">Berjalan</span>
                                    @else
                                        <span
                                            class="bg-gray-200 text-gray-800 py-1 px-2 rounded text-xs font-bold">Selesai</span>
                                    @endif
                                </div>
                                <p class="text-sm font-bold text-oranye">{{ $item->programPelatihan->nama_program }}</p>
                                <div class="mt-4 text-sm text-gray-600 space-y-1 border-t pt-3">
                                    <p><strong>Kuota:</strong> {{ $item->kuota_peserta }} Peserta</p>
                                    <p><strong>Periode:</strong>
                                        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M') }} -
                                        {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</p>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('instruktur.jadwal.show', $item->id) }}"
                                        class="text-center bg-hitam text-white px-3 py-2 rounded hover:bg-oranye transition w-full font-bold text-sm shadow">👥
                                        Absen & Nilai</a>
                                    <a href="{{ route('instruktur.materi.index', $item->id) }}"
                                        class="text-center bg-oranye text-white px-3 py-2 rounded hover:bg-[#c24b22] transition w-full font-bold text-sm shadow">📚
                                        Kelola Materi</a>
                                </div>
                            </div>
                        @empty
                            <div
                                class="col-span-3 text-center text-gray-500 py-8 italic border-2 border-dashed border-gray-300 rounded">
                                Anda belum ditugaskan untuk mengajar di kelas manapun saat ini.
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>