<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">
            {{ __('Laporan Pendaftaran & Keuangan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- KARTU RINGKASAN -->
            <div class="mb-6 bg-white p-6 rounded-2xl shadow-sm border-t-4 border-oranye flex flex-col sm:flex-row justify-between items-center gap-4">
                <div>
                    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Total Pemasukan (Sesuai Filter)</h3>
                    <p class="text-3xl font-black text-green-600 mt-1">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
                    <p class="text-[11px] text-gray-400 mt-1">*Hanya menghitung pendaftaran dengan status Lunas (Sukses).</p>
                </div>
                <div class="flex gap-2 w-full sm:w-auto">
                    <!-- Tombol Export membawa query string agar hasil cetaknya sesuai filter -->
                    <a href="{{ route('admin.laporan.cetak', request()->query()) }}" target="_blank" class="flex-1 sm:flex-none flex justify-center items-center gap-2 bg-red-50 text-red-600 px-4 py-3 rounded-xl font-bold hover:bg-red-100 transition border border-red-100 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Cetak PDF
                    </a>
                    <a href="{{ route('admin.laporan.excel', request()->query()) }}" class="flex-1 sm:flex-none flex justify-center items-center gap-2 bg-green-50 text-green-700 px-4 py-3 rounded-xl font-bold hover:bg-green-100 transition border border-green-100 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Export Excel
                    </a>
                </div>
            </div>

            <!-- FILTER: COMPACT TOOLBAR -->
            <form action="{{ route('admin.laporan.index') }}" method="GET" class="mb-5 bg-white p-3 rounded-xl shadow-sm border border-gray-200 flex flex-col md:flex-row gap-3 items-center">
                
                <!-- Tanggal Mulai -->
                <div class="w-full md:w-1/6">
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full border-gray-300 rounded-lg focus:border-oranye focus:ring-oranye text-sm transition py-2" title="Tanggal Mulai">
                </div>
                
                <!-- Tanggal Selesai -->
                <div class="w-full md:w-1/6">
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full border-gray-300 rounded-lg focus:border-oranye focus:ring-oranye text-sm transition py-2" title="Tanggal Selesai">
                </div>
                
                <!-- Filter Status -->
                <div class="w-full md:w-1/4">
                    <select name="status" class="w-full border-gray-300 rounded-lg focus:border-oranye focus:ring-oranye text-sm cursor-pointer transition py-2">
                        <option value="">Semua Status Pembayaran</option>
                        <option value="sukses" {{ request('status') == 'sukses' ? 'selected' : '' }}>🟢 Lunas</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>🟡 Pending</option>
                        <option value="batal" {{ request('status') == 'batal' ? 'selected' : '' }}>🔴 Batal</option>
                    </select>
                </div>
                
                <!-- Filter Program -->
                <div class="w-full md:w-1/4">
                    <select name="program" class="w-full border-gray-300 rounded-lg focus:border-oranye focus:ring-oranye text-sm cursor-pointer transition py-2">
                        <option value="">Semua Program Pelatihan</option>
                        @foreach($programs as $prog)
                            <option value="{{ $prog->id }}" {{ request('program') == $prog->id ? 'selected' : '' }}>{{ \Illuminate\Support\Str::limit($prog->nama_program, 20) }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Tombol Aksi -->
                <div class="w-full md:w-auto flex flex-1 gap-2 justify-end">
                    <button type="submit" class="w-full md:w-auto bg-hitam text-white px-5 py-2 rounded-lg text-sm font-bold hover:bg-gray-800 transition shadow">
                        Filter
                    </button>
                    @if(request()->hasAny(['start_date', 'end_date', 'status', 'program']) && (request('start_date') != '' || request('end_date') != '' || request('status') != '' || request('program') != ''))
                        <a href="{{ route('admin.laporan.index') }}" title="Reset Filter" class="flex items-center justify-center px-3 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 border border-red-100 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </a>
                    @endif
                </div>

            </form>

            <!-- TABEL UTAMA -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-hitam">
                <div class="p-6 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-xs font-black tracking-wider border-b-2 border-gray-200">
                                <th class="py-4 px-4 rounded-tl-lg">Tgl Daftar</th>
                                <th class="py-4 px-4">Identitas Peserta</th>
                                <th class="py-4 px-4">Program & Kelas</th>
                                <th class="py-4 px-4 text-center">Status & Metode</th>
                                <th class="py-4 px-4 text-right rounded-tr-lg">Nominal (Rp)</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm divide-y divide-gray-100">
                            @forelse($laporan as $item)
                            <tr class="hover:bg-orange-50/50 transition">
                                <td class="py-4 px-4 font-medium text-gray-700">
                                    {{ \Carbon\Carbon::parse($item->tanggal_daftar)->format('d/m/Y') }}
                                </td>
                                
                                <td class="py-4 px-4">
                                    <div class="font-bold text-hitam">{{ $item->peserta->user->name ?? '-' }}</div>
                                    <div class="text-[11px] text-gray-500 mt-0.5">NIK: {{ $item->peserta->nik ?? '-' }}</div>
                                    <div class="text-[11px] text-blue-600 font-bold mt-0.5">WA: {{ $item->peserta->nomor_telepon ?? '-' }}</div>
                                </td>
                                
                                <td class="py-4 px-4">
                                    <div class="font-bold text-oranye">{{ $item->kelas->programPelatihan->nama_program ?? '-' }}</div>
                                    <div class="text-[11px] text-gray-500">{{ $item->kelas->nama_kelas ?? '-' }}</div>
                                </td>
                                
                                <td class="py-4 px-4 text-center">
                                    @if($item->status_pembayaran == 'sukses')
                                        <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-[10px] font-bold shadow-sm uppercase border border-green-200">Lunas</span>
                                    @elseif($item->status_pembayaran == 'pending')
                                        <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-[10px] font-bold shadow-sm uppercase border border-yellow-200">Pending</span>
                                    @else
                                        <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-[10px] font-bold shadow-sm uppercase">Batal</span>
                                    @endif
                                    <div class="text-[10px] text-gray-500 font-bold uppercase mt-1">
                                        {{ $item->metode_pembayaran ?? 'Otomatis' }}
                                    </div>
                                </td>

                                <td class="py-4 px-4 text-right font-black text-gray-800">
                                    {{ number_format($item->kelas->programPelatihan->harga_pelatihan ?? 0, 0, ',', '.') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-16 text-center text-gray-400">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <span class="block italic font-medium">Tidak ada data pendaftaran dalam rentang waktu atau filter ini.</span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Link Pagination -->
                @if($laporan->hasPages())
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                        {{ $laporan->links() }}
                    </div>
                @endif
                
            </div>
            
        </div>
    </div>
</x-app-layout>