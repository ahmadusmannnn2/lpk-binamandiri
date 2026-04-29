<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('instruktur.jadwal.show', $pertemuan->kelas_id) }}" class="text-gray-500 hover:text-oranye transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-xl text-hitam leading-tight">
                {{ __('Isi Presensi & Nilai Harian') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <p class="font-bold text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-hitam rounded-xl shadow-lg p-6 mb-6 text-white grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Materi / Topik Pembahasan</p>
                    <p class="font-black text-2xl text-oranye">{{ $pertemuan->judul_pertemuan }}</p>
                    <p class="text-sm mt-1 text-gray-300">{{ $pertemuan->kelas->nama_kelas }} ({{ $pertemuan->kelas->programPelatihan->nama_program }})</p>
                </div>
                <div class="text-left md:text-right flex flex-col justify-center">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Tanggal Pertemuan</p>
                    <p class="font-bold text-xl">{{ \Carbon\Carbon::parse($pertemuan->tanggal)->translatedFormat('d F Y') }}</p>
                    @if($pertemuan->file_materi)
                        <a href="{{ asset('storage/' . $pertemuan->file_materi) }}" target="_blank" class="inline-flex items-center gap-1 text-xs bg-blue-500 hover:bg-blue-400 text-white px-3 py-1 rounded-full mt-2 w-fit md:ml-auto transition">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Lihat Modul
                        </a>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-oranye">
                <div class="p-6">
                    <form action="{{ route('instruktur.pertemuan.absensi', $pertemuan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 text-hitam uppercase text-xs font-black tracking-wider border-b-2 border-gray-200">
                                        <th class="py-3 px-4">Nama Peserta</th>
                                        <th class="py-3 px-4 text-center">Status Kehadiran</th>
                                        <th class="py-3 px-4 text-center">Nilai Harian</th>
                                        <th class="py-3 px-4">Catatan / Evaluasi (Opsional)</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm">
                                    @foreach($absensi as $absen)
                                    <tr class="border-b border-gray-100 hover:bg-orange-50/30 transition duration-200">
                                        <td class="py-4 px-4">
                                            <div class="font-bold text-hitam">{{ $absen->pendaftaran->peserta->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $absen->pendaftaran->peserta->nomor_telepon }}</div>
                                        </td>
                                        
                                        <td class="py-4 px-4">
                                            <div class="flex justify-center space-x-3 bg-gray-100 p-2 rounded-lg border border-gray-200">
                                                <label class="flex items-center space-x-1 cursor-pointer group">
                                                    <input type="radio" name="absensi[{{ $absen->id }}][status]" value="hadir" {{ $absen->status == 'hadir' ? 'checked' : '' }} class="text-green-600 focus:ring-green-500 w-4 h-4">
                                                    <span class="text-xs font-bold text-gray-600 group-hover:text-green-700">Hadir</span>
                                                </label>
                                                <label class="flex items-center space-x-1 cursor-pointer group">
                                                    <input type="radio" name="absensi[{{ $absen->id }}][status]" value="izin" {{ $absen->status == 'izin' ? 'checked' : '' }} class="text-blue-600 focus:ring-blue-500 w-4 h-4">
                                                    <span class="text-xs font-bold text-gray-600 group-hover:text-blue-700">Izin</span>
                                                </label>
                                                <label class="flex items-center space-x-1 cursor-pointer group">
                                                    <input type="radio" name="absensi[{{ $absen->id }}][status]" value="sakit" {{ $absen->status == 'sakit' ? 'checked' : '' }} class="text-yellow-600 focus:ring-yellow-500 w-4 h-4">
                                                    <span class="text-xs font-bold text-gray-600 group-hover:text-yellow-700">Sakit</span>
                                                </label>
                                                <label class="flex items-center space-x-1 cursor-pointer group">
                                                    <input type="radio" name="absensi[{{ $absen->id }}][status]" value="alpa" {{ $absen->status == 'alpa' ? 'checked' : '' }} class="text-red-600 focus:ring-red-500 w-4 h-4">
                                                    <span class="text-xs font-bold text-gray-600 group-hover:text-red-700">Alpa</span>
                                                </label>
                                            </div>
                                        </td>
                                        
                                        <td class="py-4 px-4 text-center">
                                            <input type="number" name="absensi[{{ $absen->id }}][nilai]" value="{{ $absen->nilai }}" min="0" max="100" class="w-20 text-center border-gray-300 rounded-md shadow-sm focus:border-oranye focus:ring-oranye font-bold text-hitam" placeholder="0-100">
                                        </td>
                                        
                                        <td class="py-4 px-4">
                                            <textarea name="absensi[{{ $absen->id }}][catatan]" rows="1" class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-oranye focus:ring-oranye" placeholder="Ketikan catatan progres...">{{ $absen->catatan }}</textarea>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-8 flex justify-end pt-6 border-t border-gray-200">
                            <button type="submit" class="bg-hitam hover:bg-gray-800 text-white px-10 py-3 rounded-xl shadow-lg font-bold transition transform hover:-translate-y-1 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                Simpan Data Harian
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>