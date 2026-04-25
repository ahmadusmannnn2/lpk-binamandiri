<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Dashboard Instruktur') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white text-hitam rounded-xl p-8 shadow border-l-8 border-oranye flex justify-between items-center">
                <div>
                    <h3 class="text-2xl font-black mb-1">Halo, {{ Auth::user()->name }}!</h3>
                    <p class="text-gray-500">Siap mencetak *welder* profesional hari ini? Berikut ringkasan jadwal Anda.</p>
                </div>
                <div class="hidden md:block">
                    <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-1 space-y-6">
                    <div class="bg-white p-6 rounded-xl shadow text-center border-t border-gray-100">
                        <p class="text-sm font-bold text-gray-500 uppercase">Total Kelas Saya</p>
                        <p class="text-5xl font-black text-hitam mt-2">{{ $stats['kelas_saya'] }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow text-center border-t border-gray-100">
                        <p class="text-sm font-bold text-gray-500 uppercase">Kelas Berjalan Saat Ini</p>
                        <p class="text-5xl font-black text-oranye mt-2">{{ $stats['kelas_aktif'] }}</p>
                        <a href="{{ route('instruktur.jadwal.index') }}" class="mt-4 block text-sm font-bold bg-hitam text-white py-2 rounded hover:bg-oranye transition">Lihat Kelas</a>
                    </div>
                </div>

                <div class="md:col-span-2 bg-white rounded-xl shadow p-6 border-t border-gray-100">
                    <h4 class="font-bold text-lg text-hitam border-b pb-2 mb-4">Agenda Mengajar Terdekat</h4>
                    <div class="space-y-4">
                        @forelse($jadwal as $agenda)
                            <div class="flex items-start p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-oranye transition">
                                <div class="bg-oranye text-white rounded text-center min-w-[60px] p-2 mr-4 shadow-sm">
                                    <p class="text-xs font-bold uppercase">{{ \Carbon\Carbon::parse($agenda->tanggal)->format('M') }}</p>
                                    <p class="text-xl font-black">{{ \Carbon\Carbon::parse($agenda->tanggal)->format('d') }}</p>
                                </div>
                                <div>
                                    <h5 class="font-bold text-hitam text-lg">{{ $agenda->judul_pertemuan }}</h5>
                                    <p class="text-sm text-oranye font-bold">{{ $agenda->kelas->nama_kelas }}</p>
                                    <a href="{{ route('instruktur.pertemuan.show', $agenda->id) }}" class="inline-block mt-2 text-xs font-bold bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded text-hitam">Isi Absen</a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-400 italic">
                                Belum ada agenda pertemuan terdekat. Pastikan Anda telah membuat jadwal di menu Kelola Kelas.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>