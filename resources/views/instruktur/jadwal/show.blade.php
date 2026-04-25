<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Input Kehadiran & Nilai Peserta') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                    <p class="font-bold">Berhasil</p><p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-hitam text-white rounded-t-lg p-6 flex flex-col md:flex-row justify-between items-center border-b-4 border-oranye">
                <div>
                    <h3 class="text-2xl font-bold">{{ $kelas->nama_kelas }}</h3>
                    <p class="text-oranye font-semibold">{{ $kelas->programPelatihan->nama_program }}</p>
                </div>
                <div class="text-right mt-4 md:mt-0 text-sm opacity-80">
                    <p>Periode: {{ \Carbon\Carbon::parse($kelas->tanggal_mulai)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($kelas->tanggal_selesai)->format('d M Y') }}</p>
                    <p>Status Kelas: <span class="uppercase font-bold">{{ $kelas->status_kelas }}</span></p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl rounded-b-lg">
                <div class="p-6">
                    <form action="{{ route('instruktur.jadwal.simpan_nilai', $kelas->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-100 text-hitam uppercase text-xs">
                                        <th class="py-3 px-4">Peserta</th>
                                        <th class="py-3 px-4 text-center">Kehadiran (%)</th>
                                        <th class="py-3 px-4 text-center">Nilai Teori</th>
                                        <th class="py-3 px-4 text-center">Nilai Praktik</th>
                                        <th class="py-3 px-4 text-center">Status Lulus</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm">
                                    @forelse($pesertaKelas as $pendaftaran)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-3 px-4">
                                            <div class="font-bold text-hitam">{{ $pendaftaran->peserta->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $pendaftaran->peserta->nik }}</div>
                                        </td>
                                        
                                        <td class="py-3 px-4 text-center">
                                            <input type="number" name="nilai[{{ $pendaftaran->id }}][kehadiran]" value="{{ old('nilai.'.$pendaftaran->id.'.kehadiran', $pendaftaran->kehadiran) }}" min="0" max="100" class="w-20 text-center rounded border-gray-300 focus:border-oranye focus:ring-oranye text-sm">
                                        </td>
                                        
                                        <td class="py-3 px-4 text-center">
                                            <input type="number" name="nilai[{{ $pendaftaran->id }}][nilai_teori]" value="{{ old('nilai.'.$pendaftaran->id.'.nilai_teori', $pendaftaran->nilai_teori) }}" min="0" max="100" class="w-20 text-center rounded border-gray-300 focus:border-oranye focus:ring-oranye text-sm">
                                        </td>
                                        
                                        <td class="py-3 px-4 text-center">
                                            <input type="number" name="nilai[{{ $pendaftaran->id }}][nilai_praktik]" value="{{ old('nilai.'.$pendaftaran->id.'.nilai_praktik', $pendaftaran->nilai_praktik) }}" min="0" max="100" class="w-20 text-center rounded border-gray-300 focus:border-oranye focus:ring-oranye text-sm">
                                        </td>
                                        
                                        <td class="py-3 px-4 text-center">
                                            <select name="nilai[{{ $pendaftaran->id }}][status_kelulusan]" class="rounded border-gray-300 focus:border-oranye focus:ring-oranye text-sm font-bold w-32">
                                                <option value="belum_dinilai" {{ $pendaftaran->status_kelulusan == 'belum_dinilai' ? 'selected' : '' }} class="text-gray-500">Belum Dinilai</option>
                                                <option value="lulus" {{ $pendaftaran->status_kelulusan == 'lulus' ? 'selected' : '' }} class="text-green-600">LULUS</option>
                                                <option value="tidak_lulus" {{ $pendaftaran->status_kelulusan == 'tidak_lulus' ? 'selected' : '' }} class="text-red-600">TIDAK LULUS</option>
                                            </select>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="py-8 text-center text-gray-500 italic">Belum ada peserta yang disetujui (divalidasi) Admin di kelas ini.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if(count($pesertaKelas) > 0)
                        <div class="mt-8 flex justify-end items-center space-x-4 border-t pt-4">
                            <a href="{{ route('instruktur.jadwal.index') }}" class="text-gray-500 font-bold hover:text-hitam">Kembali</a>
                            <button type="submit" class="bg-oranye hover:bg-[#c24b22] text-white px-8 py-3 rounded shadow-lg font-bold transition transform hover:-translate-y-1">
                                Simpan Seluruh Nilai
                            </button>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
            <div class="mt-12 bg-white overflow-hidden shadow-xl rounded-lg border-t-4 border-blue-600">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-hitam mb-4 border-b pb-2">Manajemen Pertemuan & Absensi Harian</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="md:col-span-1 bg-blue-50 p-4 rounded-lg border border-blue-200">
                            <h4 class="font-bold text-blue-800 mb-4">Buat Jadwal Pertemuan Baru</h4>
                            <form action="{{ route('instruktur.pertemuan.store', $kelas->id) }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <x-input-label for="judul_pertemuan" :value="__('Judul (Misal: Pertemuan 1 - Teori Dasar)')" />
                                    <x-text-input id="judul_pertemuan" class="block mt-1 w-full text-sm" type="text" name="judul_pertemuan" required />
                                </div>
                                <div>
                                    <x-input-label for="tanggal" :value="__('Tanggal Pertemuan')" />
                                    <x-text-input id="tanggal" class="block mt-1 w-full text-sm" type="date" name="tanggal" required />
                                </div>
                                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded shadow hover:bg-blue-700 font-bold transition">Buat Pertemuan</button>
                            </form>
                            <p class="text-xs text-gray-500 mt-4 italic">*Membuat pertemuan baru otomatis akan membuat draf absen bagi semua peserta.</p>
                        </div>

                        <div class="md:col-span-2 space-y-3">
                            <h4 class="font-bold text-gray-800">Daftar Pertemuan Kelas Ini</h4>
                            @forelse($kelas->pertemuan as $pertemuan)
                                <div class="flex items-center justify-between bg-white border rounded-lg p-4 shadow-sm hover:shadow transition">
                                    <div>
                                        <h5 class="font-bold text-oranye">{{ $pertemuan->judul_pertemuan }}</h5>
                                        <p class="text-xs text-gray-500">Tanggal: {{ \Carbon\Carbon::parse($pertemuan->tanggal)->translatedFormat('l, d F Y') }}</p>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('instruktur.pertemuan.show', $pertemuan->id) }}" class="bg-hitam text-white text-xs px-4 py-2 rounded shadow hover:bg-oranye font-bold transition">📋 Isi Absensi</a>
                                        <form action="{{ route('instruktur.pertemuan.destroy', $pertemuan->id) }}" method="POST" onsubmit="return confirm('Hapus pertemuan ini? Data absensinya akan hilang.');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-sm">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-6 border-2 border-dashed rounded text-gray-400">Belum ada pertemuan yang dibuat.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>