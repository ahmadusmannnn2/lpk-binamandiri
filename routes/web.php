<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ==========================================
// LANDING PAGE & REDIRECT DASHBOARD
// ==========================================
Route::get('/', function () {
    return view('welcome');
});

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
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Data Master (CRUD)
    Route::resource('program', \App\Http\Controllers\Admin\ProgramPelatihanController::class);
    Route::resource('instruktur', \App\Http\Controllers\Admin\InstrukturController::class);
    Route::resource('peserta', \App\Http\Controllers\Admin\PesertaController::class);
    Route::resource('kelas', \App\Http\Controllers\Admin\KelasController::class);

    // Fitur Utama
    Route::get('/verifikasi', [\App\Http\Controllers\Admin\VerifikasiController::class, 'index'])->name('verifikasi.index');
    Route::get('/verifikasi/{id}', [\App\Http\Controllers\Admin\VerifikasiController::class, 'show'])->name('verifikasi.show');
    Route::put('/verifikasi/{id}', [\App\Http\Controllers\Admin\VerifikasiController::class, 'update'])->name('verifikasi.update');

    // Fitur Laporan Terakhir
    Route::get('/laporan', [\App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak', [\App\Http\Controllers\Admin\LaporanController::class, 'cetak'])->name('laporan.cetak');
});


// ==========================================
// RUTE KHUSUS INSTRUKTUR
// ==========================================
Route::middleware(['auth', 'verified'])->prefix('instruktur')->name('instruktur.')->group(function () {
    Route::get('/dashboard', function () {
        return view('instruktur.dashboard');
    })->name('dashboard');

    // Fitur Jadwal & Penilaian
    Route::get('/jadwal', [\App\Http\Controllers\Instruktur\JadwalController::class, 'index'])->name('jadwal.index');
    Route::get('/jadwal/{id}', [\App\Http\Controllers\Instruktur\JadwalController::class, 'show'])->name('jadwal.show');
    Route::put('/jadwal/{id}/nilai', [\App\Http\Controllers\Instruktur\JadwalController::class, 'simpanNilai'])->name('jadwal.simpan_nilai');

    Route::get('/kelas/{kelas_id}/materi', [\App\Http\Controllers\Instruktur\MateriController::class, 'index'])->name('materi.index');
    Route::post('/kelas/{kelas_id}/materi', [\App\Http\Controllers\Instruktur\MateriController::class, 'store'])->name('materi.store');
    Route::delete('/materi/{id}', [\App\Http\Controllers\Instruktur\MateriController::class, 'destroy'])->name('materi.destroy');

    // Fitur Pertemuan & Absensi Harian
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
        return view('peserta.dashboard');
    })->name('dashboard');


    // Biodata
    Route::get('/biodata', [\App\Http\Controllers\Peserta\BiodataController::class, 'index'])->name('biodata.index');
    Route::put('/biodata', [\App\Http\Controllers\Peserta\BiodataController::class, 'update'])->name('biodata.update');


    // Fitur Pendaftaran
    Route::get('/pendaftaran', [\App\Http\Controllers\Peserta\PendaftaranController::class, 'index'])->name('pendaftaran.index');
    Route::get('/pendaftaran/{kelas_id}/daftar', [\App\Http\Controllers\Peserta\PendaftaranController::class, 'create'])->name('pendaftaran.create');
    Route::post('/pendaftaran/{kelas_id}/store', [\App\Http\Controllers\Peserta\PendaftaranController::class, 'store'])->name('pendaftaran.store');

    // Fitur Materi
    Route::get('/materi', [\App\Http\Controllers\Peserta\MateriController::class, 'index'])->name('materi.index');

    // Fitur Sertifikat
    Route::get('/sertifikat', [\App\Http\Controllers\Peserta\SertifikatController::class, 'index'])->name('sertifikat.index');
    Route::get('/sertifikat/{id}/cetak', [\App\Http\Controllers\Peserta\SertifikatController::class, 'cetak'])->name('sertifikat.cetak');


});


// ==========================================
// RUTE PROFIL (BAWAAN BREEZE) -> INI YANG SEMPAT HILANG
// ==========================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';