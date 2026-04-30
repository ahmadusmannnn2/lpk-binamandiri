<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Kelola & Cetak Sertifikat') }}</h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm font-bold text-green-800">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm font-bold text-red-800">{{ session('error') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-oranye">
                <div class="p-6">
                    <h3 class="font-black text-lg text-hitam mb-2">Daftar Peserta Lulus</h3>
                    <p class="text-sm text-gray-500 mb-6 border-b pb-4">Peserta yang tampil di sini adalah mereka yang sudah dinyatakan <strong>LULUS</strong> oleh instruktur. Masukkan nomor registrasi dan tanggal sebelum mencetak sertifikat.</p>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-hitam uppercase text-xs font-black tracking-wider border-b-2 border-gray-200">
                                    <th class="py-4 px-6">Identitas Peserta</th>
                                    <th class="py-4 px-6">Program Lulusan</th>
                                    <th class="py-4 px-6 text-center">Data Sertifikat</th>
                                    <th class="py-4 px-6 text-center">Aksi Cetak</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm">
                                @forelse($pendaftaran as $item)
                                @php
                                    $nomorSertifikat = $item->detail_nilai['nomor_sertifikat'] ?? '';
                                    $tanggalTerbit = $item->detail_nilai['tanggal_terbit'] ?? \Carbon\Carbon::now()->format('Y-m-d');
                                @endphp
                                <tr class="border-b border-gray-100 hover:bg-orange-50/30 transition duration-200">
                                    <td class="py-4 px-6 font-bold text-hitam">{{ $item->peserta->user->name }}</td>
                                    <td class="py-4 px-6 text-oranye font-bold">{{ $item->kelas->programPelatihan->nama_program }}</td>
                                    
                                    <!-- Form Input Nomor & Tanggal -->
                                    <td class="py-4 px-6">
                                        <form action="{{ route('admin.sertifikat.update', $item->id) }}" method="POST" class="flex flex-col gap-2">
                                            @csrf @method('PUT')
                                            <input type="text" name="nomor_sertifikat" value="{{ $nomorSertifikat }}" placeholder="No. Sertifikat (Cth: 12233579)" required class="w-full text-xs rounded-md border-gray-300 focus:border-oranye focus:ring-oranye font-medium">
                                            <div class="flex gap-2">
                                                <input type="date" name="tanggal_terbit" value="{{ $tanggalTerbit }}" required title="Tanggal Terbit" class="w-full text-xs rounded-md border-gray-300 focus:border-oranye focus:ring-oranye font-medium">
                                                <button type="submit" class="bg-gray-800 text-white px-3 py-1 rounded-md text-xs font-bold hover:bg-oranye transition shadow-sm">Simpan</button>
                                            </div>
                                        </form>
                                    </td>
                                    
                                    <td class="py-4 px-6 text-center">
                                        @if($nomorSertifikat)
                                            <a href="{{ route('admin.sertifikat.cetak', $item->id) }}" target="_blank" class="inline-flex items-center gap-1 bg-oranye text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-[#c24b22] transition shadow-md">
                                                🖨️ Cetak PDF
                                            </a>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Isi Data Dulu</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-12 text-center text-gray-400 italic">Belum ada peserta yang lulus.</td>
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