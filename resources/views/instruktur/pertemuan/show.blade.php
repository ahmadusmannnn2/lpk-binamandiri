<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('instruktur.jadwal.show', $pertemuan->kelas_id) }}" class="text-gray-500 hover:text-oranye transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-xl text-hitam leading-tight">
                {{ __('Isi Presensi Harian') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <p class="font-bold text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-hitam rounded-xl shadow-lg p-6 mb-6 text-white grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Topik Pembahasan</p>
                    <p class="font-black text-2xl text-oranye">{{ $pertemuan->judul_pertemuan }}</p>
                    <p class="text-sm mt-1 text-gray-300">{{ $pertemuan->kelas->nama_kelas }} ({{ $pertemuan->kelas->programPelatihan->nama_program }})</p>
                </div>
                <div class="text-left md:text-right flex flex-col justify-center">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Tanggal</p>
                    <p class="font-bold text-xl">{{ \Carbon\Carbon::parse($pertemuan->tanggal)->translatedFormat('d F Y') }}</p>
                    @if($pertemuan->file_materi)
                        <a href="{{ asset('storage/' . $pertemuan->file_materi) }}" target="_blank" class="inline-flex items-center gap-1 text-xs bg-blue-500 hover:bg-blue-400 text-white px-3 py-1 rounded-full mt-2 w-fit md:ml-auto transition">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Modul Terlampir
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
                                        <th class="py-3 px-4 w-1/3">Nama Peserta</th>
                                        <th class="py-3 px-4 text-center w-1/3">Status Kehadiran</th>
                                        <th class="py-3 px-4 text-center w-1/3">Penilaian & Catatan</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm">
                                    @foreach($absensi as $absen)
                                    <tr class="border-b border-gray-100 hover:bg-orange-50/30 transition duration-200">
                                        <td class="py-4 px-4">
                                            <div class="font-bold text-hitam">{{ $absen->pendaftaran->peserta->user->name }}</div>
                                            <div class="text-xs text-gray-500">NIK: {{ $absen->pendaftaran->peserta->nik }}</div>
                                        </td>
                                        
                                        <td class="py-4 px-4">
                                            <div class="flex justify-center gap-2">
                                                <label class="flex flex-col items-center gap-1 cursor-pointer p-2 rounded-lg border-2 transition-all duration-200 {{ $absen->status == 'hadir' ? 'bg-green-100 border-green-500 text-green-800' : 'bg-gray-50 border-gray-200 text-gray-500 hover:border-green-300' }}">
                                                    <input type="radio" name="absensi[{{ $absen->id }}][status]" value="hadir" {{ $absen->status == 'hadir' ? 'checked' : '' }} class="hidden" onchange="updateRadioUI(this, 'bg-green-100', 'border-green-500', 'text-green-800')">
                                                    <span class="text-xs font-bold">Hadir</span>
                                                </label>

                                                <label class="flex flex-col items-center gap-1 cursor-pointer p-2 rounded-lg border-2 transition-all duration-200 {{ $absen->status == 'izin' ? 'bg-blue-100 border-blue-500 text-blue-800' : 'bg-gray-50 border-gray-200 text-gray-500 hover:border-blue-300' }}">
                                                    <input type="radio" name="absensi[{{ $absen->id }}][status]" value="izin" {{ $absen->status == 'izin' ? 'checked' : '' }} class="hidden" onchange="updateRadioUI(this, 'bg-blue-100', 'border-blue-500', 'text-blue-800')">
                                                    <span class="text-xs font-bold">Izin</span>
                                                </label>

                                                <label class="flex flex-col items-center gap-1 cursor-pointer p-2 rounded-lg border-2 transition-all duration-200 {{ $absen->status == 'sakit' ? 'bg-yellow-100 border-yellow-500 text-yellow-800' : 'bg-gray-50 border-gray-200 text-gray-500 hover:border-yellow-300' }}">
                                                    <input type="radio" name="absensi[{{ $absen->id }}][status]" value="sakit" {{ $absen->status == 'sakit' ? 'checked' : '' }} class="hidden" onchange="updateRadioUI(this, 'bg-yellow-100', 'border-yellow-500', 'text-yellow-800')">
                                                    <span class="text-xs font-bold">Sakit</span>
                                                </label>

                                                <label class="flex flex-col items-center gap-1 cursor-pointer p-2 rounded-lg border-2 transition-all duration-200 {{ $absen->status == 'alpa' ? 'bg-red-100 border-red-500 text-red-800' : 'bg-gray-50 border-gray-200 text-gray-500 hover:border-red-300' }}">
                                                    <input type="radio" name="absensi[{{ $absen->id }}][status]" value="alpa" {{ $absen->status == 'alpa' ? 'checked' : '' }} class="hidden" onchange="updateRadioUI(this, 'bg-red-100', 'border-red-500', 'text-red-800')">
                                                    <span class="text-xs font-bold">Alpa</span>
                                                </label>
                                            </div>
                                        </td>
                                        
                                        <td class="py-4 px-4">
                                            <div class="flex flex-col gap-2">
                                                <input type="number" name="absensi[{{ $absen->id }}][nilai]" value="{{ $absen->nilai }}" placeholder="Nilai (0-100)" min="0" max="100" class="w-full text-xs rounded-lg border-gray-300 focus:border-oranye focus:ring-oranye">
                                                <input type="text" name="absensi[{{ $absen->id }}][catatan]" value="{{ $absen->catatan }}" placeholder="Catatan opsional..." class="w-full text-xs rounded-lg border-gray-300 focus:border-oranye focus:ring-oranye">
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-8 flex justify-end pt-6 border-t border-gray-200">
                            <button type="submit" class="bg-hitam hover:bg-gray-800 text-white px-10 py-3 rounded-xl shadow-lg font-bold transition transform hover:-translate-y-1 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Simpan Kehadiran
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- Script for handling radio UI changes elegantly -->
    <script>
        function updateRadioUI(radio, bgClass, borderClass, textClass) {
            // Reset all labels in this cell
            let td = radio.closest('td');
            let labels = td.querySelectorAll('label');
            
            labels.forEach(l => {
                // Remove all possible active classes
                l.classList.remove(
                    'bg-green-100', 'border-green-500', 'text-green-800',
                    'bg-blue-100', 'border-blue-500', 'text-blue-800',
                    'bg-yellow-100', 'border-yellow-500', 'text-yellow-800',
                    'bg-red-100', 'border-red-500', 'text-red-800'
                );
                // Add default inactive classes
                l.classList.add('bg-gray-50', 'border-gray-200', 'text-gray-500');
            });

            // Activate the selected label
            let activeLabel = radio.closest('label');
            activeLabel.classList.remove('bg-gray-50', 'border-gray-200', 'text-gray-500');
            activeLabel.classList.add(bgClass, borderClass, textClass);
        }
    </script>
</x-app-layout>