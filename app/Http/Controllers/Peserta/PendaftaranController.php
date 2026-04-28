<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Pendaftaran;
use App\Models\ProgramPelatihan; // Pastikan ini di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    // TAHAP 1: Menampilkan Daftar Program Pelatihan
    public function index()
    {
        // Ambil semua program pelatihan (bisa ditambahkan paginate jika datanya banyak)
        $programs = ProgramPelatihan::all();
        
        // Cek status pendaftaran peserta (opsional, untuk notifikasi di atas form)
        $peserta = Auth::user()->peserta;
        $pendaftaranAktif = null;
        if ($peserta) {
            $pendaftaranAktif = Pendaftaran::where('peserta_id', $peserta->id)
                ->whereIn('status_pendaftaran', ['menunggu_verifikasi', 'disetujui'])
                ->first();
        }

        return view('peserta.pendaftaran.index', compact('programs', 'pendaftaranAktif'));
    }

    // TAHAP 2: Menampilkan Detail Program & Daftar Angkatan/Kelas
    public function showProgram($program_id)
    {
        $program = ProgramPelatihan::findOrFail($program_id);
        
        // Perbaikan: Ubah program_id menjadi program_pelatihan_id
        $kelas = Kelas::with('instruktur.user')
                    ->where('program_pelatihan_id', $program_id) 
                    ->where('status_kelas', 'menunggu') 
                    ->get();

        $peserta = Auth::user()->peserta;

        return view('peserta.pendaftaran.show_program', compact('program', 'kelas', 'peserta'));
    }

    public function create($kelas_id)
    {
        $kelas = Kelas::with('programPelatihan')->findOrFail($kelas_id);
        $peserta = Auth::user()->peserta;

        // Cek apakah sudah pernah daftar di kelas ini
        $sudahDaftar = Pendaftaran::where('peserta_id', $peserta->id)
                                  ->where('kelas_id', $kelas_id)
                                  ->exists();
        
        if ($sudahDaftar) {
            return redirect()->route('peserta.pendaftaran.index')->with('error', 'Anda sudah mendaftar di kelas ini.');
        }

        return view('peserta.pendaftaran.create', compact('kelas'));
    }

    public function store(Request $request, $kelas_id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $peserta = Auth::user()->peserta;

        // Upload Bukti
        $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

        Pendaftaran::create([
            'peserta_id' => $peserta->id,
            'kelas_id' => $kelas_id,
            'tanggal_daftar' => now(),
            'bukti_pembayaran' => $buktiPath,
            'status_pendaftaran' => 'menunggu_verifikasi',
        ]);

        return redirect()->route('peserta.pendaftaran.index')->with('success', 'Pendaftaran berhasil! Menunggu verifikasi Admin.');
    }
}