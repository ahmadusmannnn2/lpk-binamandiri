<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-hitam leading-tight">{{ __('Dashboard Administrator') }}</h2>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-hitam text-white rounded-2xl p-8 shadow-2xl relative overflow-hidden border-b-4 border-oranye">
                <div class="absolute top-0 right-0 opacity-10 pointer-events-none">
                    <svg class="w-64 h-64 transform translate-x-10 -translate-y-10" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                </div>
                <div class="relative z-10">
                    <h3 class="text-3xl font-black mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-gray-400 max-w-2xl">Pantau seluruh aktivitas pelatihan, pendaftaran peserta, dan manajemen kelas LPK Bina Mandiri dari *command center* ini.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <a href="{{ route('admin.peserta.index') }}" class="group bg-white p-6 rounded-2xl shadow-md hover:shadow-2xl border-l-4 border-blue-500 transition duration-300 transform hover:-translate-y-2 relative overflow-hidden cursor-pointer">
                    <div class="absolute -right-4 -top-4 opacity-5 group-hover:opacity-10 transition duration-300"><svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path></svg></div>
                    <p class="text-sm font-bold text-gray-500 uppercase tracking-wider group-hover:text-blue-500 transition">Total Peserta</p>
                    <p class="text-4xl font-black text-hitam mt-2">{{ $stats['peserta'] }}</p>
                </a>
                
                <a href="{{ route('admin.instruktur.index') }}" class="group bg-white p-6 rounded-2xl shadow-md hover:shadow-2xl border-l-4 border-green-500 transition duration-300 transform hover:-translate-y-2 relative overflow-hidden cursor-pointer">
                    <div class="absolute -right-4 -top-4 opacity-5 group-hover:opacity-10 transition duration-300"><svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path></svg></div>
                    <p class="text-sm font-bold text-gray-500 uppercase tracking-wider group-hover:text-green-500 transition">Instruktur Aktif</p>
                    <p class="text-4xl font-black text-hitam mt-2">{{ $stats['instruktur'] }}</p>
                </a>

                <a href="{{ route('admin.kelas.index') }}" class="group bg-white p-6 rounded-2xl shadow-md hover:shadow-2xl border-l-4 border-purple-500 transition duration-300 transform hover:-translate-y-2 relative overflow-hidden cursor-pointer">
                    <div class="absolute -right-4 -top-4 opacity-5 group-hover:opacity-10 transition duration-300"><svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg></div>
                    <p class="text-sm font-bold text-gray-500 uppercase tracking-wider group-hover:text-purple-500 transition">Kelas Berjalan</p>
                    <p class="text-4xl font-black text-hitam mt-2">{{ $stats['kelas_berjalan'] }}</p>
                </a>

                <a href="{{ route('admin.verifikasi.index') }}" class="group bg-white p-6 rounded-2xl shadow-md hover:shadow-2xl border-l-4 border-oranye transition duration-300 transform hover:-translate-y-2 relative overflow-hidden cursor-pointer">
                    <div class="absolute -right-4 -top-4 opacity-5 group-hover:opacity-10 transition duration-300"><svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path></svg></div>
                    <p class="text-sm font-bold text-gray-500 uppercase tracking-wider group-hover:text-oranye transition">Perlu Verifikasi</p>
                    <p class="text-4xl font-black text-oranye mt-2">{{ $stats['menunggu_verifikasi'] }}</p>
                    @if($stats['menunggu_verifikasi'] > 0)
                        <span class="absolute top-4 right-4 flex h-3 w-3"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-oranye opacity-75"></span><span class="relative inline-flex rounded-full h-3 w-3 bg-oranye"></span></span>
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
                    <a href="{{ route('admin.verifikasi.index') }}" class="text-sm text-white bg-hitam hover:bg-oranye px-4 py-1 rounded-full font-bold transition shadow">Kelola Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 uppercase text-xs">
                                <th class="p-3 rounded-l-lg">Peserta</th>
                                <th class="p-3">Kelas / Program</th>
                                <th class="p-3">Tanggal Daftar</th>
                                <th class="p-3 rounded-r-lg">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-hitam font-medium">
                            @forelse($pendaftar_baru as $item)
                            <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                                <td class="p-3">
                                    <p class="font-bold">{{ $item->peserta->user->name ?? '-' }}</p>
                                    <p class="text-xs text-gray-400">{{ $item->peserta->nik ?? '-' }}</p>
                                </td>
                                <td class="p-3">
                                    <p class="text-oranye font-bold">{{ $item->kelas->nama_kelas }}</p>
                                    <p class="text-xs text-gray-500">{{ $item->kelas->programPelatihan->nama_program }}</p>
                                </td>
                                <td class="p-3">{{ \Carbon\Carbon::parse($item->tanggal_daftar)->translatedFormat('d F Y') }}</td>
                                <td class="p-3">
                                    @if($item->status_pendaftaran == 'menunggu_verifikasi')
                                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold border border-yellow-200">Menunggu</span>
                                    @elseif($item->status_pendaftaran == 'disetujui')
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold border border-green-200">Disetujui</span>
                                    @else
                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold border border-red-200">Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="py-8 text-center text-gray-400 italic">Belum ada data pendaftaran terbaru.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Data dari Controller
            const dataBulan = @json($grafikBulan);
            const labelKelas = @json($labelKelas);
            const dataKelas = @json($dataKelas);

            // Konfigurasi Grafik 1: Line Chart Tren Bulanan
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
                        tension: 0.4 // Membuat garis melengkung halus (spline)
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
                }
            });

            // Konfigurasi Grafik 2: Doughnut Chart Kelas Terpopuler
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
                                label: function(context) {
                                    if(dataKelas.length === 0) return ' Tidak ada pendaftar';
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