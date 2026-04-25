<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Absensi: ') }} {{ $pertemuan->judul_pertemuan }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm"><p class="font-bold">Berhasil</p><p>{{ session('success') }}</p></div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-hitam">
                <div class="p-6">
                    <div class="mb-6 flex justify-between items-center border-b pb-4">
                        <div>
                            <h3 class="text-xl font-bold text-oranye">{{ $pertemuan->kelas->nama_kelas }}</h3>
                            <p class="text-gray-600">Tanggal: {{ \Carbon\Carbon::parse($pertemuan->tanggal)->translatedFormat('d F Y') }}</p>
                        </div>
                        <a href="{{ route('instruktur.jadwal.show', $pertemuan->kelas_id) }}" class="text-gray-500 hover:text-hitam font-bold text-sm">Kembali ke Kelas</a>
                    </div>

                    <form action="{{ route('instruktur.pertemuan.absensi', $pertemuan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="overflow-x-auto">
                            <table class="min-w-full w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-100 text-hitam uppercase text-xs">
                                        <th class="py-3 px-4">Nama Peserta</th>
                                        <th class="py-3 px-4 text-center">Status Kehadiran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($absensi as $absen)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-3 px-4">
                                            <div class="font-bold text-hitam">{{ $absen->pendaftaran->peserta->user->name }}</div>
                                        </td>
                                        <td class="py-3 px-4 flex justify-center space-x-4">
                                            <label class="flex items-center space-x-1 cursor-pointer">
                                                <input type="radio" name="absensi[{{ $absen->id }}][status]" value="hadir" {{ $absen->status == 'hadir' ? 'checked' : '' }} class="text-green-600 focus:ring-green-500">
                                                <span class="text-sm font-bold text-green-700">Hadir</span>
                                            </label>
                                            <label class="flex items-center space-x-1 cursor-pointer">
                                                <input type="radio" name="absensi[{{ $absen->id }}][status]" value="izin" {{ $absen->status == 'izin' ? 'checked' : '' }} class="text-blue-600 focus:ring-blue-500">
                                                <span class="text-sm text-blue-700">Izin</span>
                                            </label>
                                            <label class="flex items-center space-x-1 cursor-pointer">
                                                <input type="radio" name="absensi[{{ $absen->id }}][status]" value="sakit" {{ $absen->status == 'sakit' ? 'checked' : '' }} class="text-yellow-600 focus:ring-yellow-500">
                                                <span class="text-sm text-yellow-700">Sakit</span>
                                            </label>
                                            <label class="flex items-center space-x-1 cursor-pointer">
                                                <input type="radio" name="absensi[{{ $absen->id }}][status]" value="alpa" {{ $absen->status == 'alpa' ? 'checked' : '' }} class="text-red-600 focus:ring-red-500">
                                                <span class="text-sm font-bold text-red-700">Alpa</span>
                                            </label>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button type="submit" class="bg-oranye hover:bg-[#c24b22] text-white px-8 py-3 rounded shadow-lg font-bold transition transform hover:-translate-y-1">
                                Simpan Absensi Harian
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>