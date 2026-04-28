<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.kelas.index') }}" class="text-gray-500 hover:text-oranye transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-xl text-hitam leading-tight">
                {{ __('Detail Kelas: ') }} <span class="text-oranye">{{ $kelas->nama_kelas }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                    <p class="font-bold">Berhasil</p><p>{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
                    <p class="font-bold">Gagal</p><p>{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-hitam rounded-xl shadow-lg p-6 mb-6 text-white grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Program Pelatihan</p>
                    <p class="font-bold text-oranye">{{ $kelas->programPelatihan->nama_program }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Instruktur Pengajar</p>
                    <p class="font-bold">{{ $kelas->instruktur->user->name ?? 'Belum ada' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Jadwal Kelas</p>
                    <p class="font-bold text-sm">
                        {{ \Carbon\Carbon::parse($kelas->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($kelas->tanggal_selesai)->format('d M Y') }}
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Status & Kuota</p>
                    <p class="font-bold uppercase text-sm">
                        {{ $kelas->status_kelas }} ({{ $pendaftaran->count() }}/{{ $kelas->kuota_peserta }} Peserta)
                    </p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border-t-4 border-oranye">
                <div class="p-6">
                    <h3 class="text-lg font-black text-hitam mb-4 border-b pb-2">Daftar Peserta di Kelas Ini</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full w-full text-left border-collapse">
                            <thead class="bg-gray-50 text-hitam uppercase text-xs font-black tracking-wider border-b-2 border-gray-200">
                                <tr>
                                    <th class="py-3 px-6 text-left">Nama Peserta</th>
                                    <th class="py-3 px-6 text-left">Kontak & Pendidikan</th>
                                    <th class="py-3 px-6 text-center">Status Kelulusan</th>
                                    <th class="py-3 px-6 text-center bg-orange-50 text-oranye">Aksi Pemindahan</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm">
                                @forelse($pendaftaran as $item)
                                    <tr class="border-b border-gray-100 hover:bg-orange-50/30 transition duration-200">
                                        <td class="py-4 px-6 font-bold text-hitam text-base">
                                            {{ $item->peserta->user->name }}
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="font-bold text-gray-700 flex items-center gap-1 text-xs">
                                                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                                {{ $item->peserta->nomor_telepon }}
                                            </div>
                                            <div class="text-[10px] text-gray-500 mt-1 uppercase tracking-wider font-bold">
                                                Pend: {{ $item->peserta->pendidikan_terakhir ?? '-' }}
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            @if($item->status_kelulusan == 'lulus')
                                                <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-bold uppercase border border-green-200">Lulus</span>
                                            @elseif($item->status_kelulusan == 'tidak_lulus')
                                                <span class="bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full font-bold uppercase border border-red-200">Gagal</span>
                                            @else
                                                <span class="bg-gray-100 text-gray-800 text-xs px-3 py-1 rounded-full font-bold uppercase border border-gray-200">Belum Dinilai</span>
                                            @endif
                                        </td>
                                        
                                        <td class="py-4 px-6 text-center bg-orange-50/20">
                                            <form action="{{ route('admin.kelas.pindah_peserta', ['kelas_id' => $kelas->id, 'pendaftaran_id' => $item->id]) }}" method="POST" class="flex flex-col items-center justify-center gap-2">
                                                @csrf
                                                <select name="kelas_baru_id" class="text-xs border-gray-300 rounded-md shadow-sm focus:border-oranye focus:ring-oranye w-48 py-1.5" required>
                                                    <option value="" disabled selected>Pilih Kelas Tujuan...</option>
                                                    @foreach($kelasLain as $kl)
                                                        <option value="{{ $kl->id }}">{{ $kl->programPelatihan->nama_program }} - {{ $kl->nama_kelas }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" onclick="return confirm('Yakin pindahkan peserta ini ke kelas baru?');" class="bg-hitam hover:bg-oranye text-white px-3 py-1.5 rounded-md text-xs font-bold transition shadow-md hover:shadow-lg w-48 flex justify-center items-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                                                    Pindahkan
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-10 text-center text-gray-400">
                                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                            <span class="block italic">Belum ada peserta yang disetujui di kelas ini.</span>
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