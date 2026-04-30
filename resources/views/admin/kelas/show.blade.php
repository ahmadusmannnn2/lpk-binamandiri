<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.kelas.index') }}" class="bg-gray-200 hover:bg-hitam text-gray-600 hover:text-white p-2.5 rounded-xl transition duration-300 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-hitam leading-tight">
                    {{ __('Detail Kelas: ') }} <span class="text-oranye">{{ $kelas->nama_kelas }}</span>
                </h2>
                <p class="text-sm text-gray-500 mt-1">Kelola data peserta yang terdaftar di kelas ini atau pindahkan peserta ke kelas lain.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl shadow-sm flex items-center">
                    <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <p class="font-bold text-green-800">Berhasil</p>
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm flex items-center">
                    <svg class="w-6 h-6 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <div>
                        <p class="font-bold text-red-800">Gagal Memproses</p>
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- KARTU INFORMASI HEADER -->
            <div class="bg-hitam rounded-2xl shadow-xl p-8 mb-8 text-white flex flex-col md:flex-row justify-between items-start md:items-center relative overflow-hidden border-b-4 border-oranye">
                <div class="absolute -right-10 -top-10 opacity-10 pointer-events-none">
                    <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"></path><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 w-full relative z-10">
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Program Pelatihan</p>
                        <p class="font-black text-oranye text-lg leading-tight">{{ $kelas->programPelatihan->nama_program }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Instruktur Pengajar</p>
                        <p class="font-bold text-lg leading-tight flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            {{ $kelas->instruktur->user->name ?? 'Belum ada' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Jadwal Kelas</p>
                        <p class="font-bold text-sm bg-gray-800 border border-gray-700 inline-block px-3 py-1.5 rounded-lg mt-1">
                            {{ \Carbon\Carbon::parse($kelas->tanggal_mulai)->format('d M y') }} <span class="text-gray-500 mx-1">-</span> {{ \Carbon\Carbon::parse($kelas->tanggal_selesai)->format('d M y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Status & Kuota</p>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="bg-oranye/20 text-oranye border border-oranye/30 px-2 py-1 rounded text-xs font-black uppercase">{{ $kelas->status_kelas }}</span>
                            <span class="font-bold text-sm">{{ $pendaftaran->count() }} / {{ $kelas->kuota_peserta }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABEL PESERTA -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-gray-200">
                <div class="p-6">
                    <h3 class="text-xl font-black text-hitam mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-oranye" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Daftar Peserta Kelas Ini
                    </h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full w-full text-left border-collapse">
                            <thead class="bg-gray-50 text-hitam uppercase text-xs font-black tracking-wider border-b-2 border-gray-200">
                                <tr>
                                    <th class="py-4 px-6 rounded-tl-lg text-left">Nama Peserta</th>
                                    <th class="py-4 px-6 text-left">Kontak & Pendidikan</th>
                                    <th class="py-4 px-6 text-center">Status Kelulusan</th>
                                    <th class="py-4 px-6 text-center rounded-tr-lg w-72">Aksi Pemindahan Kelas</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-medium">
                                @forelse($pendaftaran as $item)
                                    <tr class="border-b border-gray-100 hover:bg-orange-50/50 transition duration-150">
                                        <td class="py-4 px-6">
                                            <div class="font-black text-hitam text-base">{{ $item->peserta->user->name }}</div>
                                            <div class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mt-0.5">NIK: {{ $item->peserta->nik ?? '-' }}</div>
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="font-bold text-gray-700 flex items-center gap-1 text-sm">
                                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                                {{ $item->peserta->nomor_telepon }}
                                            </div>
                                            <div class="text-[10px] text-gray-500 mt-1 uppercase tracking-wider font-bold">
                                                Pend: {{ $item->peserta->pendidikan_terakhir ?? '-' }}
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            @if($item->status_kelulusan == 'lulus')
                                                <span class="bg-green-100 text-green-800 text-[10px] px-3 py-1 rounded-full font-black uppercase tracking-wider border border-green-200">Lulus</span>
                                            @elseif($item->status_kelulusan == 'tidak_lulus')
                                                <span class="bg-red-100 text-red-800 text-[10px] px-3 py-1 rounded-full font-black uppercase tracking-wider border border-red-200">Gagal</span>
                                            @else
                                                <span class="bg-gray-100 text-gray-800 text-[10px] px-3 py-1 rounded-full font-black uppercase tracking-wider border border-gray-200">Belum Dinilai</span>
                                            @endif
                                        </td>
                                        
                                        <td class="py-4 px-6 text-center">
                                            <form action="{{ route('admin.kelas.pindah_peserta', ['kelas_id' => $kelas->id, 'pendaftaran_id' => $item->id]) }}" method="POST" class="flex flex-col sm:flex-row items-center justify-center gap-2">
                                                @csrf
                                                <select name="kelas_baru_id" class="text-xs border-gray-300 rounded-lg shadow-sm focus:border-oranye focus:ring-oranye w-full sm:w-48 py-2 font-bold text-gray-600" required>
                                                    <option value="" disabled selected>Pilih Kelas Tujuan...</option>
                                                    @foreach($kelasLain as $kl)
                                                        <option value="{{ $kl->id }}">{{ $kl->programPelatihan->nama_program }} - {{ $kl->nama_kelas }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" onclick="return confirm('Peringatan: Memindahkan peserta akan mereset data absensi dan nilai yang ada di kelas ini. Yakin memindahkan peserta?');" class="bg-hitam hover:bg-oranye text-white p-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg w-full sm:w-auto flex justify-center items-center" title="Pindahkan Peserta">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-12 px-6 text-center">
                                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4 border-2 border-dashed border-gray-300">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                            </div>
                                            <p class="text-gray-500 font-bold text-lg">Belum ada peserta di kelas ini.</p>
                                            <p class="text-gray-400 text-sm mt-1">Peserta yang disetujui pendaftarannya akan otomatis masuk ke daftar ini.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>