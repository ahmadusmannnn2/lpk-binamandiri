<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Kelola Kelas & Absensi Peserta') }}</h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <p class="font-bold text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-hitam text-white rounded-t-xl p-8 flex flex-col md:flex-row justify-between items-start md:items-center border-b-4 border-oranye shadow-xl relative overflow-hidden">
                <div class="absolute -right-10 -top-10 opacity-10">
                    <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zm0 7l-10 5 10 5 10-5-10-5zm0 7l-10 5 10 5 10-5-10-5z"></path></svg>
                </div>
                <div class="relative z-10">
                    <h3 class="text-3xl font-black mb-1">{{ $kelas->nama_kelas }}</h3>
                    <p class="text-oranye font-bold tracking-widest uppercase text-sm mb-4">{{ $kelas->programPelatihan->nama_program }}</p>
                    <div class="flex items-center gap-4 text-xs text-gray-300 font-medium">
                        <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> {{ \Carbon\Carbon::parse($kelas->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($kelas->tanggal_selesai)->format('d M Y') }}</span>
                        <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg> {{ $pesertaKelas->count() }} Peserta</span>
                    </div>
                </div>
                <div class="relative z-10 mt-6 md:mt-0 flex flex-col items-start md:items-end gap-3 w-full md:w-auto">
                    @if($kelas->status_kelas == 'berjalan')
                        <span class="bg-green-500/20 text-green-400 border border-green-500/30 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider animate-pulse">Sedang Berjalan</span>
                    @else
                        <span class="bg-gray-500/20 text-gray-400 border border-gray-500/30 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">{{ $kelas->status_kelas }}</span>
                    @endif
                    <a href="{{ route('instruktur.jadwal.cetak', $kelas->id) }}" target="_blank" class="bg-oranye hover:bg-[#c24b22] text-white px-5 py-2.5 rounded-lg shadow-lg transition transform hover:-translate-y-1 flex items-center justify-center gap-2 font-bold text-sm w-full md:w-auto">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Cetak Laporan Kelas
                    </a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl rounded-b-xl border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-black text-hitam border-b-2 border-oranye pb-1 inline-block">Rekapitulasi Nilai Akhir</h3>
                    </div>

                    <form action="{{ route('instruktur.jadwal.simpan_nilai', $kelas->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="overflow-x-auto rounded-xl border border-gray-200">
                            <table class="min-w-full w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 text-hitam uppercase text-xs font-black tracking-wider border-b-2 border-gray-200">
                                        <th class="py-3 px-6">Identitas Peserta</th>
                                        <th class="py-3 px-6 text-center">Total Hadir (%)</th>
                                        <th class="py-3 px-6 text-center">Nilai Ujian Teori</th>
                                        <th class="py-3 px-6 text-center">Nilai Ujian Praktik</th>
                                        <th class="py-3 px-6 text-center bg-orange-50 text-oranye">Keputusan Lulus</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm">
                                    @forelse($pesertaKelas as $pendaftaran)
                                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition duration-150">
                                        <td class="py-3 px-6">
                                            <div class="font-bold text-hitam text-base">{{ $pendaftaran->peserta->user->name }}</div>
                                            <div class="text-[10px] text-gray-500 font-bold tracking-wider mt-0.5">NIK: {{ $pendaftaran->peserta->nik }}</div>
                                        </td>
                                        
                                        <td class="py-3 px-6 text-center">
                                            <input type="number" name="nilai[{{ $pendaftaran->id }}][kehadiran]" value="{{ old('nilai.'.$pendaftaran->id.'.kehadiran', $pendaftaran->kehadiran) }}" min="0" max="100" class="w-16 text-center rounded-md border-gray-300 focus:border-oranye focus:ring-oranye text-sm font-bold bg-gray-100 cursor-not-allowed" readonly title="Dihitung otomatis dari absensi harian">
                                        </td>
                                        
                                        <td class="py-3 px-6 text-center">
                                            <input type="number" name="nilai[{{ $pendaftaran->id }}][nilai_teori]" value="{{ old('nilai.'.$pendaftaran->id.'.nilai_teori', $pendaftaran->nilai_teori) }}" min="0" max="100" class="w-20 text-center rounded-md border-gray-300 focus:border-oranye focus:ring-oranye text-sm font-bold">
                                        </td>
                                        
                                        <td class="py-3 px-6 text-center">
                                            <input type="number" name="nilai[{{ $pendaftaran->id }}][nilai_praktik]" value="{{ old('nilai.'.$pendaftaran->id.'.nilai_praktik', $pendaftaran->nilai_praktik) }}" min="0" max="100" class="w-20 text-center rounded-md border-gray-300 focus:border-oranye focus:ring-oranye text-sm font-bold text-oranye">
                                        </td>
                                        
                                        <td class="py-3 px-6 text-center bg-orange-50/30">
                                            <select name="nilai[{{ $pendaftaran->id }}][status_kelulusan]" class="rounded-md border-gray-300 focus:border-oranye focus:ring-oranye text-sm font-bold w-36 shadow-sm cursor-pointer">
                                                <option value="belum_dinilai" {{ $pendaftaran->status_kelulusan == 'belum_dinilai' ? 'selected' : '' }} class="text-gray-500">⏱ Belum Dinilai</option>
                                                <option value="lulus" {{ $pendaftaran->status_kelulusan == 'lulus' ? 'selected' : '' }} class="text-green-600">✅ LULUS</option>
                                                <option value="tidak_lulus" {{ $pendaftaran->status_kelulusan == 'tidak_lulus' ? 'selected' : '' }} class="text-red-600">❌ TIDAK LULUS</option>
                                            </select>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="py-10 text-center text-gray-400">
                                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                            <span class="block italic">Belum ada peserta yang masuk ke kelas ini.</span>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if(count($pesertaKelas) > 0)
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="bg-hitam hover:bg-gray-800 text-white px-8 py-3 rounded-xl shadow-lg font-bold transition transform hover:-translate-y-1 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                Simpan Nilai & Kelulusan Akhir
                            </button>
                        </div>
                        @endif
                    </form>
                </div>
            </div>

            <div class="mt-10 bg-white overflow-hidden shadow-xl rounded-xl border border-gray-100">
                <div class="p-6 sm:p-8">
                    <h3 class="text-xl font-black text-hitam mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-oranye" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Manajemen Jadwal Pertemuan Harian
                    </h3>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        
                        <div class="lg:col-span-1 bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-inner h-fit">
                            <h4 class="font-black text-hitam border-b border-gray-200 pb-2 mb-4">Buat Jadwal Baru</h4>
                            
                            <form action="{{ route('instruktur.pertemuan.store', $kelas->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                
                                <div>
                                    <x-input-label for="judul_pertemuan" value="Topik Pertemuan" class="font-bold text-gray-700" />
                                    <x-text-input id="judul_pertemuan" class="block mt-1 w-full text-sm focus:border-oranye focus:ring-oranye" type="text" name="judul_pertemuan" placeholder="Misal: Pertemuan 1 - Teori Las" required />
                                </div>
                                
                                <div>
                                    <x-input-label for="tanggal" value="Tanggal Kelas" class="font-bold text-gray-700" />
                                    <x-text-input id="tanggal" class="block mt-1 w-full text-sm focus:border-oranye focus:ring-oranye" type="date" name="tanggal" required />
                                </div>

                                <div class="bg-white p-3 rounded-lg border border-dashed border-gray-300 hover:border-oranye transition relative mt-2">
                                    <x-input-label for="file_materi" value="Upload Materi / Modul (Opsional)" class="font-bold text-gray-700 text-xs mb-2 text-center block" />
                                    <input id="file_materi" type="file" name="file_materi" accept=".pdf,.doc,.docx,.ppt,.pptx,.zip,.rar" class="block w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-oranye/10 file:text-oranye hover:file:bg-oranye hover:file:text-white cursor-pointer" />
                                    <p class="text-[9px] text-gray-400 mt-2 text-center uppercase tracking-widest font-bold">Maksimal 5MB (PDF/Doc/PPT/ZIP)</p>
                                </div>

                                <button type="submit" class="w-full mt-4 bg-hitam text-white py-3 rounded-lg shadow hover:bg-oranye font-bold transition flex justify-center items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Tambah Jadwal
                                </button>
                            </form>
                        </div>

                        <div class="lg:col-span-2 space-y-4">
                            @forelse($kelas->pertemuan as $index => $pertemuan)
                                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition duration-300 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 group">
                                    
                                    <div class="flex items-start gap-4">
                                        <div class="bg-orange-50 text-oranye font-black text-xl w-12 h-12 flex items-center justify-center rounded-lg border border-orange-200 shrink-0">
                                            #{{ $index + 1 }}
                                        </div>
                                        <div>
                                            <h5 class="font-black text-hitam text-lg group-hover:text-oranye transition">{{ $pertemuan->judul_pertemuan }}</h5>
                                            <p class="text-sm text-gray-500 font-medium flex items-center gap-1 mt-0.5">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                {{ \Carbon\Carbon::parse($pertemuan->tanggal)->translatedFormat('l, d F Y') }}
                                            </p>
                                            
                                            @if($pertemuan->file_materi)
                                                <div class="mt-2 inline-flex items-center gap-1 bg-blue-50 border border-blue-200 text-blue-700 text-xs px-2 py-1 rounded font-bold">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                    Materi Tersedia
                                                </div>
                                            @else
                                                <div class="mt-2 inline-flex items-center gap-1 bg-gray-100 border border-gray-200 text-gray-500 text-[10px] px-2 py-1 rounded uppercase tracking-wider font-bold">
                                                    Tidak Ada Materi
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2 w-full sm:w-auto">
                                        <a href="{{ route('instruktur.pertemuan.show', $pertemuan->id) }}" class="flex-1 sm:flex-none text-center bg-hitam text-white text-xs px-4 py-2.5 rounded-lg shadow hover:bg-oranye font-bold transition">
                                            Isi Presensi & Nilai
                                        </a>
                                        <form action="{{ route('instruktur.pertemuan.destroy', $pertemuan->id) }}" method="POST" onsubmit="return confirm('Hapus pertemuan ini? Semua data absensi dan materi di dalamnya akan hilang permanen!');" class="flex-none">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="bg-red-50 text-red-500 hover:bg-red-500 hover:text-white p-2.5 rounded-lg font-bold border border-red-200 transition" title="Hapus Jadwal">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>

                                </div>
                            @empty
                                <div class="text-center py-16 bg-gray-50 border-2 border-dashed border-gray-300 rounded-xl flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <h5 class="text-gray-500 font-bold">Jadwal Kelas Belum Dibuat</h5>
                                    <p class="text-xs text-gray-400 mt-1">Gunakan form di sebelah kiri untuk menambah jadwal pertemuan.</p>
                                </div>
                            @endforelse
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>