<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Kelola Kelas Berbasis Fase') }}</h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <p class="font-bold text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm flex items-center">
                    <svg class="h-5 w-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="font-bold text-red-800">{{ session('error') }}</p>
                </div>
            @endif


            <!-- HEADER KELAS -->
            <div class="bg-hitam text-white rounded-xl p-8 flex flex-col md:flex-row justify-between items-start md:items-center border-b-4 border-oranye shadow-xl relative overflow-hidden">
                <div class="absolute -right-10 -top-10 opacity-10 pointer-events-none">
                    <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zm0 7l-10 5 10 5 10-5-10-5zm0 7l-10 5 10 5 10-5-10-5z"></path></svg>
                </div>
                <div class="relative z-10">
                    <h3 class="text-3xl font-black mb-1">{{ $kelas->nama_kelas }}</h3>
                    <p class="text-oranye font-bold tracking-widest uppercase text-sm mb-4">{{ $kelas->programPelatihan->nama_program }}</p>
                    <div class="flex items-center gap-4 text-xs text-gray-300 font-medium">
                        <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg> {{ $pesertaKelas->count() }} Peserta Aktif</span>
                    </div>
                </div>
                <div class="relative z-10 mt-6 md:mt-0">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('instruktur.jadwal.rapor', $kelas->id) }}" class="bg-hitam hover:bg-gray-800 text-white px-5 py-2.5 rounded-lg shadow-lg transition flex items-center gap-2 font-bold text-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            Rekap Rapor Akhir
                        </a>
                        <a href="{{ route('instruktur.jadwal.cetak', $kelas->id) }}" target="_blank" class="bg-oranye hover:bg-[#c24b22] text-white px-5 py-2.5 rounded-lg shadow-lg transition flex items-center gap-2 font-bold text-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Cetak Laporan
                        </a>
                    </div>
                </div>
            </div>

            <!-- TAB FASE -->
            <div x-data="{ activeTab: '{{ $kelas->fase->isNotEmpty() ? $kelas->fase->first()->id : 'new' }}' }" class="mt-8">
                
                <!-- KONTROL TAB -->
                <div class="flex flex-wrap items-center gap-2 mb-6 border-b-2 border-gray-200 pb-4 sortable-container" id="sortableFaseContainer">
                    @foreach($kelas->fase as $f)
                        <button data-id="{{ $f->id }}" @click="activeTab = '{{ $f->id }}'" 
                                :class="activeTab === '{{ $f->id }}' ? 'bg-hitam text-white border-hitam shadow-md scale-105' : 'bg-white text-gray-500 border-gray-200 hover:border-gray-400 hover:text-hitam'"
                                class="px-6 py-2.5 rounded-xl font-black text-sm uppercase tracking-wider border-2 transition-all duration-300 flex items-center gap-2 cursor-grab active:cursor-grabbing">
                            <svg class="w-4 h-4 text-gray-400 cursor-move" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path></svg>
                            Fase: {{ $f->nama_fase }}
                            @if($f->status == 'selesai')
                                <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            @endif
                        </button>
                    @endforeach

                    <!-- TOMBOL TAMBAH FASE BARU -->
                    <div x-data="{ openAddFase: false }" class="relative ml-auto">
                        <button @click="openAddFase = !openAddFase" class="px-5 py-2.5 rounded-xl bg-orange-50 text-oranye font-bold border-2 border-orange-200 hover:bg-oranye hover:text-white transition flex items-center gap-2 shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Fase Baru
                        </button>

                        <div x-show="openAddFase" @click.away="openAddFase = false" style="display: none;" class="absolute top-full right-0 mt-3 bg-white p-5 rounded-2xl shadow-2xl border border-gray-100 w-80 z-50 transform transition-all duration-300">
                            <h4 class="font-bold text-hitam mb-3 text-sm border-b pb-2">Buat Fase / Tingkatan Baru</h4>
                            <form action="{{ route('instruktur.fase.store', $kelas->id) }}" method="POST">
                                @csrf
                                <div class="space-y-3">
                                    <div>
                                        <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Nama Fase</label>
                                        <input type="text" name="nama_fase" placeholder="Misal: 1F, Modul A..." class="w-full text-sm rounded-lg border-gray-300 focus:border-oranye focus:ring-oranye font-bold" required>
                                    </div>
                                    <div class="flex gap-3">
                                        <div class="w-1/2">
                                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Urutan</label>
                                            <input type="number" name="urutan" value="{{ $kelas->fase->count() + 1 }}" class="w-full text-sm rounded-lg border-gray-300 focus:border-oranye" required>
                                        </div>
                                        <div class="w-1/2">
                                            <label class="block text-xs font-bold text-gray-700 mb-1">Estimasi Total Pertemuan (Target)</label>
                                            <input type="number" name="target_pertemuan" value="1" min="1" class="w-full text-sm rounded-lg border-gray-300 focus:border-oranye focus:ring-oranye" required>
                                        </div>
                                    </div>
                                    <button type="submit" class="w-full bg-hitam text-white text-xs font-bold py-3 rounded-lg hover:bg-oranye transition shadow-md mt-2">Simpan Fase</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @if($kelas->fase->isEmpty())
                    <div class="text-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-300 shadow-sm mt-8">
                        <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <h4 class="text-2xl font-black text-hitam">Sistem Kelas Belum Berjenjang</h4>
                        <p class="text-gray-500 mt-2 max-w-md mx-auto">Silakan buat "Fase Baru" (misalnya 1F atau Tingkat Dasar) terlebih dahulu untuk mulai menjadwalkan pertemuan dan memberikan penilaian.</p>
                    </div>
                @endif

                <!-- KONTEN MASING-MASING FASE -->
                @foreach($kelas->fase as $f)
                    <div x-show="activeTab === '{{ $f->id }}'" style="display: none;" class="space-y-8 animate-fade-in-up">
                        
                        <!-- HEADER STATUS FASE -->
                        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex items-center justify-between">
                            <div>
                                <h4 class="font-black text-hitam text-lg">Ruang Kerja: Fase {{ $f->nama_fase }}</h4>
                                <p class="text-xs text-gray-500 font-bold">Total Pertemuan Dibuat: {{ $f->pertemuan->count() }} / Target: {{ $f->target_pertemuan }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <div x-data="{ openEdit: false }">
                                    <button @click="openEdit = true" class="p-2 text-gray-500 hover:text-oranye hover:bg-orange-50 rounded-lg transition" title="Edit Fase">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                    <!-- Modal Edit Fase -->
                                    <div x-show="openEdit" style="display: none;" class="fixed inset-0 z-[60] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
                                        <div @click.away="openEdit = false" class="bg-white p-6 rounded-2xl shadow-2xl w-full max-w-sm">
                                            <h4 class="font-black text-hitam mb-4 text-lg border-b pb-2">Edit Fase</h4>
                                            <form action="{{ route('instruktur.fase.update', $f->id) }}" method="POST">
                                                @csrf @method('PUT')
                                                <div class="space-y-3 mb-4">
                                                    <div>
                                                        <label class="block text-xs font-bold text-gray-700 mb-1">Nama Fase</label>
                                                        <input type="text" name="nama_fase" value="{{ $f->nama_fase }}" class="w-full text-sm rounded-lg border-gray-300 focus:border-oranye focus:ring-oranye" required>
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs font-bold text-gray-700 mb-1">Estimasi Total Pertemuan</label>
                                                        <input type="number" name="target_pertemuan" value="{{ $f->target_pertemuan }}" min="1" class="w-full text-sm rounded-lg border-gray-300 focus:border-oranye focus:ring-oranye" required>
                                                    </div>
                                                </div>
                                                <div class="flex justify-end gap-2">
                                                    <button type="button" @click="openEdit = false" class="px-4 py-2 text-xs font-bold text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Batal</button>
                                                    <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-hitam rounded-lg hover:bg-oranye transition shadow-md">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <form action="{{ route('instruktur.fase.destroy', $f->id) }}" method="POST" onsubmit="return confirm('PERINGATAN! Menghapus fase ini akan menghapus seluruh data jadwal, absensi, dan nilai rapor peserta di dalamnya. Anda yakin?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-500 hover:text-red-500 hover:bg-red-50 rounded-lg transition" title="Hapus Fase">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>

                                <form action="{{ route('instruktur.fase.update_status', $f->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf @method('PUT')
                                    <select name="status" class="text-sm rounded-lg border-gray-300 font-bold {{ $f->status == 'selesai' ? 'text-green-600 bg-green-50' : 'text-oranye bg-orange-50' }}" onchange="this.form.submit()">
                                        <option value="belum_mulai" {{ $f->status == 'belum_mulai' ? 'selected' : '' }}>Belum Mulai</option>
                                        <option value="berjalan" {{ $f->status == 'berjalan' ? 'selected' : '' }}>Sedang Berjalan</option>
                                        <option value="selesai" {{ $f->status == 'selesai' ? 'selected' : '' }}>Fase Selesai</option>
                                    </select>
                                </form>
                            </div>
                        </div>

                        <!-- MANAJEMEN PERTEMUAN (ABSENSI) -->
                        <div id="absensi" class="bg-white overflow-hidden shadow-xl rounded-xl border border-gray-100 scroll-mt-24">
                            <div class="p-6 sm:p-8">
                                <h3 class="text-xl font-black text-hitam mb-6 flex items-center gap-2 border-b-2 border-oranye pb-2 inline-flex">
                                    <svg class="w-6 h-6 text-oranye" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Jadwal & Presensi (Fase {{ $f->nama_fase }})
                                </h3>
                                
                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-2">
                                    <!-- FORM TAMBAH JADWAL -->
                                    <div class="lg:col-span-1 bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-inner h-fit">
                                        <h4 class="font-black text-hitam border-b border-gray-200 pb-2 mb-4 text-sm">Buat Jadwal Baru</h4>
                                        <form action="{{ route('instruktur.pertemuan.store', $kelas->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                            @csrf
                                            <input type="hidden" name="fase_kelas_id" value="{{ $f->id }}">
                                            <div>
                                                <label class="font-bold text-gray-700 text-xs">Topik Pertemuan</label>
                                                <input class="block mt-1 w-full text-sm rounded-lg border-gray-300 focus:border-oranye focus:ring-oranye" type="text" name="judul_pertemuan" placeholder="Misal: Bab 1 - Kosakata Dasar" required />
                                            </div>
                                            <div>
                                                <label class="font-bold text-gray-700 text-xs">Tanggal Kelas</label>
                                                <input class="block mt-1 w-full text-sm rounded-lg border-gray-300 focus:border-oranye focus:ring-oranye" type="date" name="tanggal" required />
                                            </div>
                                            <div class="bg-white p-3 rounded-lg border border-dashed border-gray-300 hover:border-oranye transition relative mt-2">
                                                <label class="font-bold text-gray-700 text-[10px] mb-2 text-center block uppercase tracking-widest">Lampiran Materi (Opsional)</label>
                                                <input type="file" name="file_materi" accept=".pdf,.doc,.docx,.ppt,.pptx,.zip,.rar" class="block w-full text-[10px] text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-oranye/10 file:text-oranye hover:file:bg-oranye hover:file:text-white cursor-pointer" />
                                            </div>
                                            <button type="submit" class="w-full mt-4 bg-hitam text-white py-2.5 text-sm rounded-lg shadow hover:bg-oranye font-bold transition flex justify-center items-center gap-2">
                                                Tambah Jadwal
                                            </button>
                                        </form>
                                    </div>

                                    <!-- LIST JADWAL -->
                                    <div class="lg:col-span-2 space-y-3">
                                        @forelse($f->pertemuan as $index => $pertemuan)
                                            <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md transition duration-300 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 group">
                                                <div class="flex items-start gap-4">
                                                    <div class="bg-orange-50 text-oranye font-black text-lg w-10 h-10 flex items-center justify-center rounded-lg border border-orange-200 shrink-0">
                                                        #{{ $index + 1 }}
                                                    </div>
                                                    <div>
                                                        <h5 class="font-black text-hitam text-base group-hover:text-oranye transition">{{ $pertemuan->judul_pertemuan }}</h5>
                                                        <p class="text-xs text-gray-500 font-medium flex items-center gap-1 mt-0.5">
                                                            {{ \Carbon\Carbon::parse($pertemuan->tanggal)->translatedFormat('l, d F Y') }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-2 w-full sm:w-auto">
                                                    <a href="{{ route('instruktur.pertemuan.show', $pertemuan->id) }}" class="flex-1 sm:flex-none text-center bg-hitam text-white text-[11px] px-4 py-2 rounded-lg shadow hover:bg-oranye font-bold transition">
                                                        Isi Presensi
                                                    </a>
                                                    <form action="{{ route('instruktur.pertemuan.destroy', $pertemuan->id) }}" method="POST" onsubmit="return confirm('Hapus pertemuan ini?');" class="flex-none">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="bg-red-50 text-red-500 hover:bg-red-500 hover:text-white p-2 rounded-lg text-[11px] font-bold border border-red-200 transition">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-center py-10 bg-gray-50 border-2 border-dashed border-gray-300 rounded-xl">
                                                <p class="text-gray-400 font-bold text-sm">Belum ada jadwal pertemuan di fase ini.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- BUKU PENILAIAN & EVALUASI FASE INI -->
                        <div id="penilaian" class="bg-white overflow-hidden shadow-xl rounded-xl border border-gray-100 scroll-mt-24">
                            <div class="p-6 sm:p-8">
                                @php
                                    $parameters = $f->kriteria_penilaian ?? [];
                                                  
                                    $baseKriteria = [
                                        '1F', '2F', '3F', '1G', '2G', '3G', '4G', 
                                        'K3 Umum', 'Teori Dasar Las', 'Inspeksi Visual (VT)', 
                                        'Tata Bahasa', 'Kosakata (Goi)', 'Berbicara (Kaiwa)', 
                                        'Tugas / PR', 'Keaktifan', 'Ujian Lisan', 'Ujian Tulis'
                                    ];
                                    
                                    $allKriteria = array_unique(array_merge($baseKriteria, $parameters));
                                @endphp

                                <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-6 gap-4">
                                    <div class="flex items-center gap-4">
                                        <h3 class="text-xl font-black text-hitam border-b-2 border-oranye pb-2 inline-flex">Buku Rapor (Fase {{ $f->nama_fase }})</h3>
                                        <div x-data="{ openKriteria: false }" class="relative">
                                            <button type="button" @click="openKriteria = true" class="text-[10px] bg-gray-100 text-hitam border border-gray-300 font-bold px-3 py-1.5 rounded-lg hover:bg-gray-200 transition flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                                                Atur Kriteria
                                            </button>
                                            
                                            <div x-show="openKriteria" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
                                                <div @click.away="openKriteria = false" class="bg-white p-6 rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
                                                    <h4 class="font-black text-hitam mb-2 text-lg">Atur Kriteria Penilaian (Fase {{ $f->nama_fase }})</h4>
                                                    <p class="text-xs text-gray-500 mb-4">Pilih aspek apa saja yang relevan untuk dinilai pada kurikulum fase ini.</p>
                                                    <form action="{{ route('instruktur.fase.update_kriteria', $f->id) }}" method="POST">
                                                        @csrf @method('PUT')
                                                        <div class="grid grid-cols-2 gap-3 mb-4">
                                                            @foreach($allKriteria as $dk)
                                                            <label class="flex items-center gap-2 text-sm text-gray-700 bg-gray-50 p-3 rounded-lg border border-gray-200 cursor-pointer hover:bg-orange-50 transition">
                                                                <input type="checkbox" name="kriteria[]" value="{{ $dk }}" {{ in_array($dk, $parameters) ? 'checked' : '' }} class="rounded text-oranye focus:ring-oranye">
                                                                <span class="font-bold text-xs">{{ $dk }}</span>
                                                            </label>
                                                            @endforeach
                                                        </div>
                                                        <div class="mb-5 border-t border-gray-200 pt-4">
                                                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest block mb-1">Kriteria Tambahan (Opsional)</label>
                                                            @php
                                                                $customKriteria = array_diff($parameters, $baseKriteria);
                                                                $customKriteriaStr = implode(', ', $customKriteria);
                                                            @endphp
                                                            <input type="text" name="kriteria[]" value="{{ $customKriteriaStr }}" placeholder="Contoh: Praktik Lapangan..." class="w-full text-sm font-bold rounded-lg border-gray-300 focus:border-oranye">
                                                            <p class="text-[10px] text-gray-500 mt-1">Kriteria ini akan diubah menjadi checkbox setelah Anda menyimpannya.</p>
                                                        </div>
                                                        <div class="flex justify-end gap-2">
                                                            <button type="button" @click="openKriteria = false" class="px-5 py-2.5 text-xs font-bold text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Batal</button>
                                                            <button type="submit" class="px-5 py-2.5 text-xs font-bold text-white bg-hitam rounded-lg hover:bg-oranye transition shadow-md flex items-center gap-2">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Simpan Kriteria
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-[11px] text-gray-500 bg-blue-50 text-blue-800 px-3 py-1.5 rounded-lg border border-blue-200 font-bold">
                                        ℹ️ Syarat Lulus Fase: Rata-rata <strong>≥ 70</strong>
                                    </p>
                                </div>

                                <form action="{{ route('instruktur.fase.simpan_nilai', $f->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="overflow-x-auto rounded-xl border border-gray-200 pb-16">
                                        <table class="min-w-full w-full text-left border-collapse">
                                            <thead>
                                                <tr class="bg-gray-50 text-hitam uppercase text-[10px] font-black tracking-wider border-b-2 border-gray-200">
                                                    <th class="py-3 px-6 whitespace-nowrap sticky left-0 bg-gray-50 z-20 shadow-[1px_0_0_0_#e5e7eb]">Identitas Peserta</th>
                                                    <th class="py-3 px-4 text-center bg-orange-50 text-oranye" title="Persentase Kehadiran Fase Ini">Kehadiran</th>
                                                    
                                                    @if(empty($parameters))
                                                        <th class="py-3 px-4 text-center text-red-500">Kriteria Belum Diatur Admin</th>
                                                    @else
                                                        @foreach($parameters as $param)
                                                            <th class="py-3 px-4 text-center text-oranye">{{ $param }}</th>
                                                        @endforeach
                                                    @endif
                                                    
                                                    <th class="py-3 px-4 text-center bg-blue-50 text-blue-800">Rata-rata</th>
                                                    <th class="py-3 px-4 text-center text-hitam">Catatan Akhir</th>
                                                    <th class="py-3 px-4 text-center bg-gray-50 text-gray-600">Status Fase</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-gray-600 text-sm">
                                                @forelse($pesertaKelas as $pendaftaran)
                                                @php
                                                    // Ambil data nilaiFase khusus pendaftaran dan fase ini
                                                    $nilaiFasePeserta = $f->nilaiFase->where('pendaftaran_id', $pendaftaran->id)->first();
                                                    $detailNilaiFase = $nilaiFasePeserta->detail_nilai ?? [];
                                                    
                                                    // Hitung Persentase Kehadiran Khusus Fase Ini
                                                    $targetPertemuan = $f->target_pertemuan > 0 ? $f->target_pertemuan : max(1, $f->pertemuan->count());
                                                    $totalHadirFase = \App\Models\Absensi::where('pendaftaran_id', $pendaftaran->id)
                                                                        ->whereHas('pertemuan', function($q) use ($f) {
                                                                            $q->where('fase_kelas_id', $f->id);
                                                                        })->where('status', 'hadir')->count();
                                                    $persenHadir = round(($totalHadirFase / $targetPertemuan) * 100);
                                                    $persenHadir = $persenHadir > 100 ? 100 : $persenHadir;
                                                @endphp
                                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition duration-150">
                                                    <td class="py-3 px-6 sticky left-0 bg-white group-hover:bg-gray-50 z-10 shadow-[1px_0_0_0_#f3f4f6]">
                                                        <div class="font-bold text-hitam text-sm whitespace-nowrap">{{ $pendaftaran->peserta->user->name }}</div>
                                                    </td>

                                                    <td class="py-3 px-4 text-center align-middle">
                                                        <div class="inline-flex flex-col items-center justify-center bg-orange-50 px-2 py-1.5 rounded-lg border border-orange-100">
                                                            <span class="text-sm font-black {{ $persenHadir >= 80 ? 'text-green-600' : 'text-red-500' }}">{{ $persenHadir }}%</span>
                                                            <span class="text-[9px] font-bold text-gray-500">{{ $totalHadirFase }}/{{ $targetPertemuan }} Hadir</span>
                                                        </div>
                                                    </td>
                                                    
                                                    @if(empty($parameters))
                                                        <td class="py-3 px-4 text-center text-xs text-gray-400 italic">Hubungi Admin</td>
                                                    @else
                                                        @foreach($parameters as $param)
                                                            @php
                                                                $oldData = $detailNilaiFase[$param] ?? null;
                                                                $skor = is_array($oldData) ? ($oldData['skor'] ?? '') : (is_numeric($oldData) ? $oldData : '');
                                                                $catatan = is_array($oldData) ? ($oldData['catatan'] ?? '') : '';
                                                                $hasCatatan = !empty($catatan) ? 'true' : 'false';
                                                            @endphp
                                                            <td class="py-3 px-4 text-center align-top pt-4" x-data="{ openNote: {{ $hasCatatan }} }">
                                                                <div class="flex flex-col items-center gap-1 w-24 mx-auto">
                                                                    <div class="flex items-center gap-1 w-full justify-center">
                                                                        <input type="number" name="nilai[{{ $pendaftaran->id }}][detail][{{ $param }}][skor]" 
                                                                               value="{{ $skor }}" min="0" max="100" placeholder="Skor"
                                                                               class="w-14 text-center rounded-md border-gray-300 focus:border-oranye text-[11px] font-bold">
                                                                        
                                                                        <button type="button" @click="openNote = !openNote" 
                                                                                class="p-1 rounded-md transition duration-200"
                                                                                :class="openNote ? 'bg-oranye text-white' : 'bg-gray-100 text-gray-500 hover:bg-orange-50 hover:text-oranye'" title="Catatan">
                                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                                        </button>
                                                                    </div>
                                                                    
                                                                    <div x-show="openNote" style="display: none;" class="w-full mt-1">
                                                                        <input type="text" name="nilai[{{ $pendaftaran->id }}][detail][{{ $param }}][catatan]" 
                                                                               value="{{ $catatan }}" placeholder="Catatan..."
                                                                               class="w-full text-[9px] rounded border-gray-300 focus:border-oranye px-1 py-1 bg-yellow-50">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    @endif
                                                    
                                                    <td class="py-3 px-4 text-center bg-blue-50/30 align-top pt-5">
                                                        <span class="font-black text-blue-700 text-sm">{{ $nilaiFasePeserta->nilai_rata_rata ?? 0 }}</span>
                                                    </td>
                                                    
                                                    @php
                                                        $catatanAkhir = $nilaiFasePeserta->catatan_instruktur ?? '';
                                                        $hasCatatanAkhir = !empty($catatanAkhir) ? 'true' : 'false';
                                                    @endphp
                                                    <td class="py-3 px-4 text-center align-top pt-4" x-data="{ openFinal: {{ $hasCatatanAkhir }} }">
                                                        <button type="button" x-show="!openFinal" @click="openFinal = true" class="text-[10px] bg-gray-100 hover:bg-gray-200 text-gray-600 px-2 py-1.5 rounded-md font-bold transition flex items-center gap-1 mx-auto whitespace-nowrap">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg> Kesimpulan
                                                        </button>
                                                        
                                                        <div x-show="openFinal" style="display: none;" class="relative">
                                                            <textarea name="nilai[{{ $pendaftaran->id }}][catatan_akhir]" rows="2" 
                                                                      class="w-32 rounded-md border-gray-300 focus:border-oranye text-[9px] font-medium p-1.5 bg-yellow-50">{{ $catatanAkhir }}</textarea>
                                                            <button type="button" @click="openFinal = false" class="absolute -top-1.5 -right-1.5 bg-red-500 text-white rounded-full p-0.5 shadow-sm">
                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                            </button>
                                                        </div>
                                                    </td>

                                                    <td class="py-3 px-4 text-center bg-gray-50/50 align-top pt-5">
                                                        @if($nilaiFasePeserta && $nilaiFasePeserta->status_kelulusan == 'lulus')
                                                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-[9px] font-black uppercase shadow-sm border border-green-200">LULUS FASE INI</span>
                                                        @elseif($nilaiFasePeserta && $nilaiFasePeserta->status_kelulusan == 'tidak_lulus')
                                                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-[9px] font-black uppercase shadow-sm border border-red-200">GAGAL</span>
                                                        @else
                                                            <span class="text-gray-400 text-[10px] italic">Belum Dinilai</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="10" class="py-10 text-center text-gray-400 text-sm">
                                                        <span class="block italic">Belum ada peserta di kelas ini.</span>
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    @if(count($pesertaKelas) > 0 && !empty($parameters))
                                    <div class="mt-6 flex justify-end">
                                        <button type="submit" class="bg-hitam hover:bg-gray-800 text-white px-8 py-3 rounded-xl shadow-lg font-bold transition transform hover:-translate-y-1 flex items-center gap-2 text-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Simpan Evaluasi Fase {{ $f->nama_fase }}
                                        </button>
                                    </div>
                                    @endif
                                </form>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

        </div>
    </div>
    @push('scripts')
    <!-- SortableJS untuk Drag and Drop Fase -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var el = document.getElementById('sortableFaseContainer');
            if (el) {
                var sortable = Sortable.create(el, {
                    animation: 150,
                    handle: '.cursor-move',
                    ghostClass: 'opacity-50',
                    onEnd: function (evt) {
                        var itemEl = evt.item;
                        var orderArray = [];
                        
                        // Kumpulkan semua data-id dalam urutan baru
                        el.querySelectorAll('[data-id]').forEach(function(btn) {
                            orderArray.push(btn.getAttribute('data-id'));
                        });

                        // Kirim ke server
                        fetch("{{ route('instruktur.fase.reorder', $kelas->id) }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                "Accept": "application/json"
                            },
                            body: JSON.stringify({ order: orderArray })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if(data.success) {
                                // Tampilkan notifikasi kecil di pojok layar
                                let notif = document.createElement('div');
                                notif.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg font-bold text-sm z-50 animate-bounce';
                                notif.innerHTML = '✅ Urutan Fase Berhasil Disimpan!';
                                document.body.appendChild(notif);
                                setTimeout(() => notif.remove(), 3000);
                            }
                        })
                        .catch(error => console.error("Error reordering:", error));
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>