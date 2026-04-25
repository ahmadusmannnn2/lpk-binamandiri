<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Ruang Belajar Saya') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(!$peserta || !$peserta->nik || !$peserta->pas_foto)
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm flex justify-between items-center">
                <div>
                    <p class="font-bold">Perhatian!</p>
                    <p class="text-sm">Biodata Anda belum lengkap. Anda tidak bisa mendaftar kelas sebelum melengkapinya.</p>
                </div>
                <a href="{{ route('peserta.biodata.index') }}" class="bg-red-500 text-white px-4 py-2 rounded text-sm font-bold shadow hover:bg-red-600">Lengkapi Sekarang</a>
            </div>
            @endif

            <div class="bg-hitam text-white rounded-xl p-8 shadow-lg border-b-4 border-oranye flex items-center justify-between">
                <div>
                    <h3 class="text-3xl font-black mb-1">Semangat Belajar, {{ Auth::user()->name }}! 🚀</h3>
                    <p class="text-gray-400">Konsistensi adalah kunci menjadi welder ahli. Mari periksa kemajuan kelas Anda.</p>
                </div>
            </div>

            @if($kelasAktif)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-white p-6 rounded-xl shadow border-t-4 border-oranye">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Kelas Aktif Saat Ini</p>
                            <h4 class="font-black text-xl text-hitam">{{ $kelasAktif->kelas->nama_kelas }}</h4>
                            <p class="text-sm text-oranye font-bold mb-4">{{ $kelasAktif->kelas->programPelatihan->nama_program }}</p>
                            
                            <div class="space-y-3 pt-4 border-t border-gray-100">
                                <div>
                                    <div class="flex justify-between text-xs font-bold mb-1">
                                        <span>Kehadiran</span>
                                        <span class="{{ $kelasAktif->kehadiran >= 80 ? 'text-green-500' : 'text-oranye' }}">{{ $kelasAktif->kehadiran }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-oranye h-2.5 rounded-full" style="width: {{ $kelasAktif->kehadiran }}%"></div>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Pastikan kehadiran Anda di atas 80% untuk memenuhi syarat kelulusan.</p>
                            </div>
                            
                            <a href="{{ route('peserta.materi.index') }}" class="mt-6 block w-full text-center bg-hitam hover:bg-gray-800 text-white py-2 rounded font-bold shadow transition">📚 Buka Materi Pelatihan</a>
                        </div>
                    </div>

                    <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow border-t border-gray-100">
                        <h4 class="font-bold text-lg text-hitam mb-6">Timeline Perjalanan Kelas</h4>
                        
                        @if($kelasAktif->kelas->pertemuan->count() > 0)
                            <div class="relative border-l-4 border-oranye ml-3 space-y-8 pb-4">
                                @foreach($kelasAktif->kelas->pertemuan as $pertemuan)
                                    @php
                                        // Cek apakah tanggal sudah lewat
                                        $sudahSelesai = \Carbon\Carbon::parse($pertemuan->tanggal)->isPast();
                                        $hariIni = \Carbon\Carbon::parse($pertemuan->tanggal)->isToday();
                                    @endphp
                                    <div class="relative pl-8">
                                        <div class="absolute -left-[14px] {{ $sudahSelesai ? 'bg-oranye' : ($hariIni ? 'bg-green-500 animate-pulse' : 'bg-gray-300') }} w-6 h-6 rounded-full border-4 border-white shadow"></div>
                                        
                                        <div class="{{ $sudahSelesai ? 'opacity-75' : ($hariIni ? 'bg-green-50 border border-green-200 p-3 rounded-lg -mt-3' : '') }}">
                                            <h5 class="font-bold {{ $hariIni ? 'text-green-700' : 'text-hitam' }} text-lg">{{ $pertemuan->judul_pertemuan }}</h5>
                                            <p class="text-sm font-semibold {{ $sudahSelesai ? 'text-gray-500' : 'text-oranye' }}">
                                                {{ \Carbon\Carbon::parse($pertemuan->tanggal)->translatedFormat('l, d F Y') }}
                                                @if($hariIni) <span class="bg-green-500 text-white text-[10px] px-2 py-0.5 rounded-full ml-2 uppercase">Hari Ini</span> @endif
                                                @if($sudahSelesai) <span class="text-gray-400 text-[10px] px-2 py-0.5 border rounded-full ml-2">Selesai</span> @endif
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="relative pl-8 pt-4">
                                    <div class="absolute -left-[14px] bg-hitam w-6 h-6 rounded-full border-4 border-white shadow flex items-center justify-center">
                                        <div class="w-2 h-2 bg-white rounded-full"></div>
                                    </div>
                                    <h5 class="font-bold text-gray-500">Evaluasi & Sertifikasi</h5>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-10 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                                <p class="text-gray-500">Instruktur belum menyusun jadwal pertemuan untuk kelas ini.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="bg-white p-10 rounded-xl shadow text-center border border-gray-100 mt-6">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-hitam mb-2">Belum Ada Kelas Aktif</h4>
                    <p class="text-gray-500 max-w-md mx-auto mb-6">Anda belum mendaftar kelas, atau pendaftaran Anda masih menunggu verifikasi admin.</p>
                    <a href="{{ route('peserta.pendaftaran.index') }}" class="inline-block bg-oranye text-white px-6 py-2 rounded-full font-bold shadow hover:bg-[#c24b22] transition transform hover:-translate-y-1">Daftar Kelas Pelatihan</a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>