<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

// ==========================================
// LANDING PAGE & REDIRECT DASHBOARD
// ==========================================
Route::get('/', function () {
    $pengaturan = Pengaturan::pluck('nilai', 'kunci')->toArray();
    $programs = \App\Models\ProgramPelatihan::latest()->take(3)->get();
    return view('welcome', compact('pengaturan', 'programs'));
});

// PENGARAH DASHBOARD AWAL
Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    if ($role === 'admin')
        return redirect()->route('admin.dashboard');
    if ($role === 'instruktur')
        return redirect()->route('instruktur.dashboard');
    return redirect()->route('peserta.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// ==========================================
// RUTE KHUSUS ADMIN
// ==========================================
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {

    // DASHBOARD ADMIN
    Route::get('/dashboard', function (Request $request) {
        $tahun = $request->input('tahun', date('Y'));

        $stats = [
            'peserta' => \App\Models\Peserta::count(),
            'instruktur' => \App\Models\Instruktur::count(),
            'kelas_berjalan' => \App\Models\Kelas::where('tanggal_mulai', '<=', now()->toDateString())->where('tanggal_selesai', '>=', now()->toDateString())->count(),
            // Ubah counter menunggu_verifikasi untuk menghitung biodata yang menunggu
            'menunggu_verifikasi' => \App\Models\Peserta::where('status_biodata', 'menunggu')->count(),
        ];
        $pendaftar_baru = \App\Models\Pendaftaran::with('peserta.user', 'kelas')->latest()->take(5)->get();

        $grafikBulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $grafikBulan[] = \App\Models\Pendaftaran::whereYear('tanggal_daftar', $tahun)->whereMonth('tanggal_daftar', $i)->count();
        }

        $kelasPopuler = \App\Models\Kelas::withCount([
            'pendaftaran' => function ($q) use ($tahun) {
                $q->whereYear('tanggal_daftar', $tahun);
            }
        ])->orderBy('pendaftaran_count', 'desc')->take(5)->get();

        $labelKelas = $kelasPopuler->pluck('nama_kelas')->toArray();
        $dataKelas = $kelasPopuler->pluck('pendaftaran_count')->toArray();

        return view('admin.dashboard', compact('stats', 'pendaftar_baru', 'tahun', 'grafikBulan', 'labelKelas', 'dataKelas'));
    })->name('dashboard');

    // Data Master (CRUD)
    Route::resource('program', \App\Http\Controllers\Admin\ProgramPelatihanController::class);
    Route::resource('instruktur', \App\Http\Controllers\Admin\InstrukturController::class);
    Route::resource('peserta', \App\Http\Controllers\Admin\PesertaController::class);
    Route::put('/peserta/{id}/reset-password', [\App\Http\Controllers\Admin\PesertaController::class, 'resetPassword'])->name('peserta.reset_password');
    Route::resource('kelas', \App\Http\Controllers\Admin\KelasController::class);
    Route::post('/kelas/{kelas_id}/pindah-peserta/{pendaftaran_id}', [\App\Http\Controllers\Admin\KelasController::class, 'pindahPeserta'])->name('kelas.pindah_peserta');
    
    // --- FITUR BARU 1: VERIFIKASI BIODATA (MENGGUNAKAN VerifikasiController) ---
    Route::get('/verifikasi', [\App\Http\Controllers\Admin\VerifikasiController::class, 'index'])->name('verifikasi.index');
    Route::get('/verifikasi/{id}', [\App\Http\Controllers\Admin\VerifikasiController::class, 'show'])->name('verifikasi.show');
    Route::put('/verifikasi/{id}', [\App\Http\Controllers\Admin\VerifikasiController::class, 'update'])->name('verifikasi.update');


    // --- FITUR BARU 2: VERIFIKASI PENDAFTARAN & PEMBAYARAN ---
    // (Akan dibuat controllernya nanti)
    Route::get('/verifikasi-pembayaran', [\App\Http\Controllers\Admin\VerifikasiPembayaranController::class, 'index'])->name('verifikasi_pembayaran.index');
    
    Route::get('/verifikasi-pembayaran/{id}/kelola', [\App\Http\Controllers\Admin\VerifikasiPembayaranController::class, 'show'])->name('verifikasi_pembayaran.show');
    
    // TAMBAHKAN BARIS INI TEPAT DI SINI:
    Route::get('/verifikasi-pembayaran/cetak-semua', [\App\Http\Controllers\Admin\VerifikasiPembayaranController::class, 'cetakSemua'])->name('verifikasi_pembayaran.cetak_semua');
    
    Route::put('/verifikasi-pembayaran/{id}', [\App\Http\Controllers\Admin\VerifikasiPembayaranController::class, 'update'])->name('verifikasi_pembayaran.update');
    Route::get('/verifikasi-pembayaran/{id}/cetak-kwitansi', [\App\Http\Controllers\Admin\VerifikasiPembayaranController::class, 'cetakKwitansi'])->name('verifikasi_pembayaran.cetak_kwitansi');
    Route::delete('/verifikasi-pembayaran/{id}', [\App\Http\Controllers\Admin\VerifikasiPembayaranController::class, 'destroy'])->name('verifikasi_pembayaran.destroy');

    // Laporan
    Route::get('/laporan', [\App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak', [\App\Http\Controllers\Admin\LaporanController::class, 'cetak'])->name('laporan.cetak');
    Route::get('/laporan/excel', [\App\Http\Controllers\Admin\LaporanController::class, 'excel'])->name('laporan.excel'); 

    // Akademik & Kelulusan (Nilai & Sertifikat)
    Route::get('/nilai', [App\Http\Controllers\Admin\AkademikController::class, 'nilaiIndex'])->name('nilai.index');
    Route::get('/sertifikat', [App\Http\Controllers\Admin\AkademikController::class, 'sertifikatIndex'])->name('sertifikat.index');
    Route::put('/sertifikat/{id}', [App\Http\Controllers\Admin\AkademikController::class, 'sertifikatUpdate'])->name('sertifikat.update');
    Route::get('/sertifikat/{id}/cetak', [App\Http\Controllers\Admin\AkademikController::class, 'sertifikatCetak'])->name('sertifikat.cetak');
    
    // Pengaturan Web
    Route::get('/pengaturan', [\App\Http\Controllers\Admin\PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::put('/pengaturan', [\App\Http\Controllers\Admin\PengaturanController::class, 'update'])->name('pengaturan.update');
});


// ==========================================
// RUTE KHUSUS INSTRUKTUR
// ==========================================
Route::middleware(['auth', 'verified'])->prefix('instruktur')->name('instruktur.')->group(function () {

    Route::get('/dashboard', function () {
        $instruktur = auth()->user()->instruktur;

        $kelasAktif = $instruktur ? \App\Models\Kelas::with(['programPelatihan'])
            ->withCount(['pendaftaran' => function($q) {
                $q->where('status_pendaftaran', 'disetujui');
            }])
            ->where('instruktur_id', $instruktur->id)
            ->whereDate('tanggal_selesai', '>=', now())
            ->get() : collect();

        $pertemuan = $instruktur ? \App\Models\Pertemuan::with('kelas.programPelatihan')
            ->whereHas('kelas', function ($q) use ($instruktur) {
                $q->where('instruktur_id', $instruktur->id);
            })
            ->whereBetween('tanggal', [now()->subDays(7), now()->addDays(7)])
            ->orderBy('tanggal', 'asc')
            ->get() : collect();

        $jadwalHariIni = $pertemuan->filter(fn($j) => \Carbon\Carbon::parse($j->tanggal)->isToday());
        $jadwalBesok = $pertemuan->filter(fn($j) => \Carbon\Carbon::parse($j->tanggal)->isTomorrow());

        $tugasTertunda = $pertemuan->filter(function($j) {
             return \Carbon\Carbon::parse($j->tanggal)->isPast() &&
                    !\Carbon\Carbon::parse($j->tanggal)->isToday() &&
                    \App\Models\Absensi::where('pertemuan_id', $j->id)->count() == 0;
        });

        return view('instruktur.dashboard', compact('kelasAktif', 'jadwalHariIni', 'jadwalBesok', 'tugasTertunda', 'instruktur'));
    })->name('dashboard');

    Route::get('/jadwal', [\App\Http\Controllers\Instruktur\JadwalController::class, 'index'])->name('jadwal.index');
    Route::get('/jadwal/{id}', [\App\Http\Controllers\Instruktur\JadwalController::class, 'show'])->name('jadwal.show');
    Route::put('/fase/{id}/nilai', [\App\Http\Controllers\Instruktur\FaseKelasController::class, 'simpanNilai'])->name('fase.simpan_nilai');
    Route::get('/jadwal/{id}/rapor', [\App\Http\Controllers\Instruktur\JadwalController::class, 'rapor'])->name('jadwal.rapor');
    Route::post('/jadwal/{id}/kunci-rapor', [\App\Http\Controllers\Instruktur\JadwalController::class, 'kunciRapor'])->name('jadwal.kunci_rapor');
    Route::get('/jadwal/{id}/cetak', [\App\Http\Controllers\Instruktur\JadwalController::class, 'cetak'])->name('jadwal.cetak');  

    Route::post('/kelas/{kelas_id}/fase', [\App\Http\Controllers\Instruktur\FaseKelasController::class, 'store'])->name('fase.store');
    Route::put('/fase/{id}', [\App\Http\Controllers\Instruktur\FaseKelasController::class, 'update'])->name('fase.update');
    Route::delete('/fase/{id}', [\App\Http\Controllers\Instruktur\FaseKelasController::class, 'destroy'])->name('fase.destroy');
    Route::post('/kelas/{kelas_id}/fase/reorder', [\App\Http\Controllers\Instruktur\FaseKelasController::class, 'reorder'])->name('fase.reorder');
    Route::put('/fase/{id}/status', [\App\Http\Controllers\Instruktur\FaseKelasController::class, 'updateStatus'])->name('fase.update_status');
    Route::put('/fase/{id}/kriteria', [\App\Http\Controllers\Instruktur\FaseKelasController::class, 'updateKriteria'])->name('fase.update_kriteria');

    Route::post('/kelas/{kelas_id}/pertemuan', [\App\Http\Controllers\Instruktur\PertemuanController::class, 'store'])->name('pertemuan.store');
    Route::get('/pertemuan/{id}', [\App\Http\Controllers\Instruktur\PertemuanController::class, 'show'])->name('pertemuan.show');
    Route::put('/pertemuan/{id}/absensi', [\App\Http\Controllers\Instruktur\PertemuanController::class, 'simpanAbsensi'])->name('pertemuan.absensi');
    Route::delete('/pertemuan/{id}', [\App\Http\Controllers\Instruktur\PertemuanController::class, 'destroy'])->name('pertemuan.destroy');
});


// ==========================================
// RUTE KHUSUS PESERTA
// ==========================================
Route::middleware(['auth', 'verified'])->prefix('peserta')->name('peserta.')->group(function () {

    Route::get('/dashboard', function () {
        $peserta = auth()->user()->peserta;
        $kelasAktif = null;
        if ($peserta) {
            $kelasAktif = \App\Models\Pendaftaran::with([
                'kelas.programPelatihan',
                'kelas.pertemuan' => function ($q) {
                    $q->orderBy('tanggal', 'asc');
                }
            ])
                ->where('peserta_id', $peserta->id)
                ->where('status_pendaftaran', 'disetujui')
                ->whereHas('kelas', function ($q) {
                    $q->where('tanggal_selesai', '>=', now()->toDateString());
                })
                ->latest()
                ->get();
        }
        return view('peserta.dashboard', compact('peserta', 'kelasAktif'));
    })->name('dashboard');

    Route::get('/biodata', [\App\Http\Controllers\Peserta\BiodataController::class, 'index'])->name('biodata.index');
    Route::put('/biodata', [\App\Http\Controllers\Peserta\BiodataController::class, 'update'])->name('biodata.update');

    // --- PENDAFTARAN 2 TAHAP ---
    Route::get('/pendaftaran', [\App\Http\Controllers\Peserta\PendaftaranController::class, 'index'])->name('pendaftaran.index'); 
    Route::get('/pendaftaran/program/{program_id}', [\App\Http\Controllers\Peserta\PendaftaranController::class, 'showProgram'])->name('pendaftaran.show_program'); 
    Route::get('/pendaftaran/{kelas_id}/daftar', [\App\Http\Controllers\Peserta\PendaftaranController::class, 'create'])->name('pendaftaran.create'); 
    Route::post('/pendaftaran/{kelas_id}/store', [\App\Http\Controllers\Peserta\PendaftaranController::class, 'store'])->name('pendaftaran.store');

    // Rute Pembayaran Midtrans
    Route::get('/pembayaran/{id}', [\App\Http\Controllers\PembayaranController::class, 'bayar'])->name('pembayaran.bayar');
    Route::post('/pembayaran/finish', [\App\Http\Controllers\PembayaranController::class, 'finish'])->name('pembayaran.finish');

    // --- FITUR RIWAYAT PENDAFTARAN & TAGIHAN PESERTA ---
    Route::get('/riwayat-pendaftaran', [\App\Http\Controllers\Peserta\PendaftaranController::class, 'riwayat'])->name('riwayat.index');
    Route::get('/riwayat-pendaftaran/{id}/detail', [\App\Http\Controllers\Peserta\PendaftaranController::class, 'showRiwayat'])->name('riwayat.show');
    Route::get('/riwayat-pendaftaran/{id}/cetak', [\App\Http\Controllers\Peserta\PendaftaranController::class, 'cetakKwitansi'])->name('riwayat.cetak');
    Route::delete('/riwayat-pendaftaran/{id}', [\App\Http\Controllers\Peserta\PendaftaranController::class, 'destroy'])->name('riwayat.destroy');
    
    Route::get('/materi', [\App\Http\Controllers\Peserta\MateriController::class, 'index'])->name('materi.index');
    Route::get('/sertifikat', [\App\Http\Controllers\Peserta\SertifikatController::class, 'index'])->name('sertifikat.index');
    Route::get('/sertifikat/{id}/cetak', [\App\Http\Controllers\Peserta\SertifikatController::class, 'cetak'])->name('sertifikat.cetak');
});


// ==========================================
// RUTE PROFIL & CALLBACK MIDTRANS
// ==========================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==========================================
// RUTE CHAT (AJAX & VIEW)
// ==========================================
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/chat', [\App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/messages/{user_id}', [\App\Http\Controllers\ChatController::class, 'getMessages']);
    Route::post('/chat/send', [\App\Http\Controllers\ChatController::class, 'sendMessage']);
});

// Rute Callback untuk menerima notifikasi dari Midtrans (Wajib di luar middleware auth)
Route::post('/midtrans/callback', [\App\Http\Controllers\PembayaranController::class, 'callback']);

require __DIR__ . '/auth.php';