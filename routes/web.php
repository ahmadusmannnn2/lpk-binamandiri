<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Pengaturan;
use Illuminate\Http\Request; // Tambahan untuk grafik filter

// ==========================================
// LANDING PAGE & REDIRECT DASHBOARD
// ==========================================
Route::get('/', function () {
    $pengaturan = Pengaturan::pluck('nilai', 'kunci')->toArray();
    return view('welcome', compact('pengaturan'));
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

    // DASHBOARD ADMIN (DENGAN SUNTIKAN DATA GRAFIK)
    Route::get('/dashboard', function (Request $request) {
        $tahun = $request->input('tahun', date('Y'));

        $stats = [
            'peserta' => \App\Models\Peserta::count(),
            'instruktur' => \App\Models\Instruktur::count(),
            'kelas_berjalan' => \App\Models\Kelas::where('status_kelas', 'berjalan')->count(),
            'menunggu_verifikasi' => \App\Models\Pendaftaran::where('status_pendaftaran', 'menunggu_verifikasi')->count(),
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
    
    // --- DI SINI LETAK RUTE PESERTA & RESET PASSWORD YANG BENAR ---
    Route::resource('peserta', \App\Http\Controllers\Admin\PesertaController::class);
    Route::put('/peserta/{id}/reset-password', [\App\Http\Controllers\Admin\PesertaController::class, 'resetPassword'])->name('peserta.reset_password');
    
    Route::resource('kelas', \App\Http\Controllers\Admin\KelasController::class);
    // Tambahan fitur pindah kelas
    Route::post('/kelas/{kelas_id}/pindah-peserta/{pendaftaran_id}', [\App\Http\Controllers\Admin\KelasController::class, 'pindahPeserta'])->name('kelas.pindah_peserta');
    
    // Fitur Utama
    Route::get('/verifikasi', [\App\Http\Controllers\Admin\VerifikasiController::class, 'index'])->name('verifikasi.index');
    Route::get('/verifikasi/{id}', [\App\Http\Controllers\Admin\VerifikasiController::class, 'show'])->name('verifikasi.show');
    Route::put('/verifikasi/{id}', [\App\Http\Controllers\Admin\VerifikasiController::class, 'update'])->name('verifikasi.update');

    Route::get('/laporan', [\App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak', [\App\Http\Controllers\Admin\LaporanController::class, 'cetak'])->name('laporan.cetak');
    Route::get('/laporan/excel', [\App\Http\Controllers\Admin\LaporanController::class, 'excel'])->name('laporan.excel'); 

    Route::get('/pengaturan', [\App\Http\Controllers\Admin\PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::put('/pengaturan', [\App\Http\Controllers\Admin\PengaturanController::class, 'update'])->name('pengaturan.update');
});


// ==========================================
// RUTE KHUSUS INSTRUKTUR
// ==========================================
Route::middleware(['auth', 'verified'])->prefix('instruktur')->name('instruktur.')->group(function () {

    Route::get('/dashboard', function () {
        $instruktur = auth()->user()->instruktur;
        $stats = [
            'kelas_saya' => $instruktur ? \App\Models\Kelas::where('instruktur_id', $instruktur->id)->count() : 0,
            'kelas_aktif' => $instruktur ? \App\Models\Kelas::where('instruktur_id', $instruktur->id)->where('status_kelas', 'berjalan')->count() : 0,
        ];
        $jadwal = $instruktur ? \App\Models\Pertemuan::with('kelas')->whereHas('kelas', function ($q) use ($instruktur) {
            $q->where('instruktur_id', $instruktur->id)->where('status_kelas', 'berjalan');
        })->whereDate('tanggal', '>=', today())->orderBy('tanggal', 'asc')->take(5)->get() : collect();

        return view('instruktur.dashboard', compact('stats', 'jadwal'));
    })->name('dashboard');

    Route::get('/jadwal', [\App\Http\Controllers\Instruktur\JadwalController::class, 'index'])->name('jadwal.index');
    Route::get('/jadwal/{id}', [\App\Http\Controllers\Instruktur\JadwalController::class, 'show'])->name('jadwal.show');
    Route::put('/jadwal/{id}/nilai', [\App\Http\Controllers\Instruktur\JadwalController::class, 'simpanNilai'])->name('jadwal.simpan_nilai');
    Route::get('/jadwal/{id}/cetak', [\App\Http\Controllers\Instruktur\JadwalController::class, 'cetak'])->name('jadwal.cetak'); 

    Route::get('/kelas/{kelas_id}/materi', [\App\Http\Controllers\Instruktur\MateriController::class, 'index'])->name('materi.index');
    Route::post('/kelas/{kelas_id}/materi', [\App\Http\Controllers\Instruktur\MateriController::class, 'store'])->name('materi.store');
    Route::delete('/materi/{id}', [\App\Http\Controllers\Instruktur\MateriController::class, 'destroy'])->name('materi.destroy');

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
                    $q->whereIn('status_kelas', ['menunggu', 'berjalan']);
                })->first();
        }
        return view('peserta.dashboard', compact('peserta', 'kelasAktif'));
    })->name('dashboard');

    Route::get('/biodata', [\App\Http\Controllers\Peserta\BiodataController::class, 'index'])->name('biodata.index');
    Route::put('/biodata', [\App\Http\Controllers\Peserta\BiodataController::class, 'update'])->name('biodata.update');

    // --- PENDAFTARAN 2 TAHAP ---
    Route::get('/pendaftaran', [\App\Http\Controllers\Peserta\PendaftaranController::class, 'index'])->name('pendaftaran.index'); // TAHAP 1: Pilih Program
    Route::get('/pendaftaran/program/{program_id}', [\App\Http\Controllers\Peserta\PendaftaranController::class, 'showProgram'])->name('pendaftaran.show_program'); // TAHAP 2: Pilih Angkatan/Kelas
    Route::get('/pendaftaran/{kelas_id}/daftar', [\App\Http\Controllers\Peserta\PendaftaranController::class, 'create'])->name('pendaftaran.create'); // TAHAP 3: Form Daftar
    Route::post('/pendaftaran/{kelas_id}/store', [\App\Http\Controllers\Peserta\PendaftaranController::class, 'store'])->name('pendaftaran.store');

    Route::get('/materi', [\App\Http\Controllers\Peserta\MateriController::class, 'index'])->name('materi.index');
    Route::get('/sertifikat', [\App\Http\Controllers\Peserta\SertifikatController::class, 'index'])->name('sertifikat.index');
    Route::get('/sertifikat/{id}/cetak', [\App\Http\Controllers\Peserta\SertifikatController::class, 'cetak'])->name('sertifikat.cetak');
});


// ==========================================
// RUTE PROFIL (BAWAAN BREEZE)
// ==========================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';