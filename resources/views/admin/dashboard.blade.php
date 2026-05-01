<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Dashboard Administrator') }}</h2>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @php
        // Ambil data tagihan pending langsung di view agar tidak perlu merombak Controller
        $pendingPembayaran = \App\Models\Pendaftaran::where('status_pembayaran', 'pending')->count();
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="bg-hitam text-white rounded-2xl p-8 shadow-2xl relative overflow-hidden border-b-4 border-oranye">
                <div class="absolute top-0 right-0 opacity-10 pointer-events-none">
                    <svg class="w-64 h-64 transform translate-x-10 -translate-y-10" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="relative z-10">
                    <h3 class="text-3xl font-black mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-gray-400 max-w-2xl">Pantau seluruh aktivitas pelatihan, pendaftaran peserta, dan
                        manajemen kelas LPK Bina Mandiri dari command center ini.</p>
                </div>
            </div>

            <!-- UBAH GRID MENJADI 5 KOLOM (Atau responsif bertumpuk di layar kecil) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
                
                <a href="{{ route('admin.peserta.index') }}" class="group bg-white p-6 rounded-2xl shadow-md hover:shadow-2xl border-l-4 border-blue-500 transition duration-300 transform hover:-translate-y-2 relative overflow-hidden cursor-pointer">
                    <div class="absolute -right-4 -top-4 opacity-5 group-hover:opacity-10 transition duration-300"><svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path></svg></div>
                    <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider group-hover:text-blue-500 transition">Total Peserta</p>
                    <p class="text-4xl font-black text-hitam mt-2">{{ $stats['peserta'] }}</p>
                </a>

                <a href="{{ route('admin.instruktur.index') }}" class="group bg-white p-6 rounded-2xl shadow-md hover:shadow-2xl border-l-4 border-green-500 transition duration-300 transform hover:-translate-y-2 relative overflow-hidden cursor-pointer">
                    <div class="absolute -right-4 -top-4 opacity-5 group-hover:opacity-10 transition duration-300"><svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path></svg></div>
                    <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider group-hover:text-green-500 transition">Instruktur Aktif</p>
                    <p class="text-4xl font-black text-hitam mt-2">{{ $stats['instruktur'] }}</p>
                </a>

                <a href="{{ route('admin.kelas.index') }}" class="group bg-white p-6 rounded-2xl shadow-md hover:shadow-2xl border-l-4 border-purple-500 transition duration-300 transform hover:-translate-y-2 relative overflow-hidden cursor-pointer">
                    <div class="absolute -right-4 -top-4 opacity-5 group-hover:opacity-10 transition duration-300"><svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg></div>
                    <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider group-hover:text-purple-500 transition">Kelas Berjalan</p>
                    <p class="text-4xl font-black text-hitam mt-2">{{ $stats['kelas_berjalan'] }}</p>
                </a>

                <a href="{{ route('admin.verifikasi.index') }}" class="group bg-white p-6 rounded-2xl shadow-md hover:shadow-2xl border-l-4 border-oranye transition duration-300 transform hover:-translate-y-2 relative overflow-hidden cursor-pointer">
                    <div class="absolute -right-4 -top-4 opacity-5 group-hover:opacity-10 transition duration-300"><svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path></svg></div>
                    <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider group-hover:text-oranye transition">Biodata Pending</p>
                    <p class="text-4xl font-black text-oranye mt-2">{{ $stats['menunggu_verifikasi'] }}</p>
                    @if($stats['menunggu_verifikasi'] > 0)
                        <span class="absolute top-4 right-4 flex h-3 w-3"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-oranye opacity-75"></span><span class="relative inline-flex rounded-full h-3 w-3 bg-oranye"></span></span>
                    @endif
                </a>

                <!-- KARTU BARU: TAGIHAN PENDING -->
                <a href="{{ route('admin.verifikasi_pembayaran.index') }}" class="group bg-white p-6 rounded-2xl shadow-md hover:shadow-2xl border-l-4 border-red-500 transition duration-300 transform hover:-translate-y-2 relative overflow-hidden cursor-pointer">
                    <div class="absolute -right-4 -top-4 opacity-5 group-hover:opacity-10 transition duration-300"><svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path></svg></div>
                    <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider group-hover:text-red-500 transition">Tagihan Pending</p>
                    <p class="text-4xl font-black text-red-500 mt-2">{{ $pendingPembayaran }}</p>
                    @if($pendingPembayaran > 0)
                        <span class="absolute top-4 right-4 flex h-3 w-3"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span><span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span></span>
                    @endif
                </a>

            </div>

            <div class="bg-white rounded-2xl shadow-lg border-t border-gray-100 p-6">
                <div class="flex flex-col md:flex-row justify-between items-center mb-6 border-b pb-4">
                    <div>
                        <h4 class="font-bold text-xl text-hitam">Statistik Pendaftaran</h4>
                        <p class="text-sm text-gray-500">Analisis data pendaftar pelatihan berdasarkan bulan dan kelas.</p>
                    </div>
                    <form action="{{ route('admin.dashboard') }}" method="GET" class="mt-4 md:mt-0 flex items-center gap-2">
                        <label for="tahun" class="text-sm font-bold text-gray-600">Pilih Tahun:</label>
                        <select name="tahun" id="tahun" onchange="this.form.submit()" class="rounded-lg border-gray-300 text-sm focus:ring-oranye focus:border-oranye font-bold">
                            @for($y = date('Y'); $y >= date('Y') - 4; $y--)
                                <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </form>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 relative h-72">
                        <canvas id="chartTrendBulan"></canvas>
                    </div>
                    <div class="lg:col-span-1 relative h-72 flex flex-col items-center">
                        <h5 class="text-sm font-bold text-gray-600 mb-2 text-center">Top 5 Kelas Terpopuler</h5>
                        <canvas id="chartKelas"></canvas>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 border-t border-gray-100">
                <div class="flex justify-between items-center mb-4 border-b pb-2">
                    <h4 class="font-bold text-lg text-hitam">Pendaftaran Terbaru</h4>
                    <!-- Link diubah ke halaman transaksi utama -->
                    <a href="{{ route('admin.verifikasi_pembayaran.index') }}" class="text-sm text-white bg-hitam hover:bg-oranye px-4 py-1 rounded-full font-bold transition shadow">Semua Transaksi</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 uppercase text-xs">
                                <th class="p-3 rounded-tl-lg">Peserta</th>
                                <th class="p-3">Kelas / Program</th>
                                <th class="p-3">Tanggal Daftar</th>
                                <th class="p-3">Status Pendaftaran & Tagihan</th>
                                <th class="p-3 rounded-tr-lg text-center">Aksi Cepat</th>
                            </tr>
                        </thead>
                        <tbody class="text-hitam font-medium">
                            @forelse($pendaftar_baru as $item)
                                <tr class="border-b border-gray-100 hover:bg-orange-50/30 transition duration-200">
                                    <td class="p-3">
                                        <p class="font-bold text-base">{{ $item->peserta->user->name ?? 'Akun Terhapus' }}</p>
                                        <p class="text-[11px] text-gray-400">NIK: {{ $item->peserta->nik ?? '-' }}</p>
                                    </td>
                                    <td class="p-3">
                                        <p class="text-oranye font-bold">
                                            {{ $item->kelas?->nama_kelas ?? 'Kelas Telah Dihapus' }}</p>
                                        <p class="text-[11px] text-gray-500 font-bold">
                                            {{ $item->kelas?->programPelatihan?->nama_program ?? 'Program Tidak Ditemukan' }}
                                        </p>
                                    </td>
                                    <td class="p-3 text-[11px] text-gray-600 font-bold">
                                        {{ \Carbon\Carbon::parse($item->tanggal_daftar)->translatedFormat('d M Y') }}
                                        <div class="text-gray-400 font-normal">{{ \Carbon\Carbon::parse($item->tanggal_daftar)->format('H:i') }} WIB</div>
                                    </td>
                                    
                                    <!-- Menampilkan 2 Status Sekaligus (Biodata & Tagihan) -->
                                    <td class="p-3 space-y-1">
                                        <div>
                                            @if($item->status_pendaftaran == 'menunggu_verifikasi')
                                                <span class="bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded text-[9px] font-bold border border-yellow-200 uppercase tracking-wider shadow-sm">Berkas: Menunggu</span>
                                            @elseif($item->status_pendaftaran == 'disetujui')
                                                <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-[9px] font-bold border border-green-200 uppercase tracking-wider shadow-sm">Berkas: Disetujui</span>
                                            @else
                                                <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded text-[9px] font-bold border border-red-200 uppercase tracking-wider shadow-sm">Berkas: Ditolak</span>
                                            @endif
                                        </div>
                                        <div>
                                            @if($item->status_pembayaran == 'sukses')
                                                <span class="bg-green-100 text-green-800 px-2 py-0.5 rounded text-[9px] font-bold shadow-sm uppercase border border-green-200">Tagihan: Lunas</span>
                                            @elseif($item->status_pembayaran == 'pending')
                                                <span class="bg-red-100 text-red-800 px-2 py-0.5 rounded text-[9px] font-bold shadow-sm uppercase border border-red-200 animate-pulse">Tagihan: Pending</span>
                                            @else
                                                <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-[9px] font-bold shadow-sm uppercase border border-gray-200">Tagihan: Batal</span>
                                            @endif
                                        </div>
                                    </td>
                                    
                                    <td class="p-3 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <!-- Tombol Cek Biodata (Bug FIXED: menggunakan peserta_id) -->
                                            <a href="{{ route('admin.verifikasi.show', $item->peserta_id) }}" class="inline-flex items-center justify-center bg-gray-100 hover:bg-hitam text-gray-600 hover:text-white p-2 rounded-lg transition duration-200 shadow-sm" title="Cek Biodata Peserta">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                            </a>
                                            <!-- Tombol Cek Tagihan -->
                                            <a href="{{ route('admin.verifikasi_pembayaran.show', $item->id) }}" class="inline-flex items-center justify-center bg-gray-100 hover:bg-oranye text-gray-600 hover:text-white p-2 rounded-lg transition duration-200 shadow-sm" title="Kelola Tagihan Pembayaran">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-10 text-center text-gray-400 italic font-medium">Belum ada data pendaftaran terbaru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Script Chart JS Anda tetap sama dan tidak diubah -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const dataBulan = @json($grafikBulan);
            const labelKelas = @json($labelKelas);
            const dataKelas = @json($dataKelas);

            const ctxTrend = document.getElementById('chartTrendBulan').getContext('2d');
            new Chart(ctxTrend, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: [{
                        label: 'Total Pendaftar',
                        data: dataBulan,
                        borderColor: '#de5e2e',
                        backgroundColor: 'rgba(222, 94, 46, 0.2)',
                        borderWidth: 3,
                        pointBackgroundColor: '#201e1f',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: '#de5e2e',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
                }
            });

            const ctxKelas = document.getElementById('chartKelas').getContext('2d');
            new Chart(ctxKelas, {
                type: 'doughnut',
                data: {
                    labels: labelKelas.length > 0 ? labelKelas : ['Belum Ada Data'],
                    datasets: [{
                        data: dataKelas.length > 0 ? dataKelas : [1],
                        backgroundColor: ['#de5e2e', '#201e1f', '#4B5563', '#9CA3AF', '#D1D5DB'],
                        borderWidth: 2,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 10 } } },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    if (dataKelas.length === 0) return ' Tidak ada pendaftar';
                                    return ' ' + context.raw + ' Peserta';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>