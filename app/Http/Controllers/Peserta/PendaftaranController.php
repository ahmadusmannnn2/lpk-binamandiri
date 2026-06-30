<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Pendaftaran;
use App\Models\ProgramPelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    // Fungsi Bantuan Pribadi (Gembok Sakti) untuk mengecek status biodata
    private function cekStatusBiodata()
    {
        $peserta = Auth::user()->peserta;

        if (!$peserta || $peserta->status_biodata !== 'disetujui') {
            // Tentukan pesan spesifik berdasarkan status
            if ($peserta && $peserta->status_biodata === 'menunggu') {
                $pesan = 'Sabar ya! Biodata Anda sedang diverifikasi oleh Admin. Anda bisa mendaftar kelas setelah disetujui.';
            } elseif ($peserta && $peserta->status_biodata === 'ditolak') {
                $pesan = 'Biodata Anda ditolak oleh Admin. Silakan perbaiki data Anda terlebih dahulu untuk bisa mendaftar kelas.';
            } else {
                $pesan = 'Silakan lengkapi biodata dan berkas Anda terlebih dahulu sebelum mendaftar kelas.';
            }

            return redirect()->route('peserta.biodata.index')->with('error', $pesan);
        }

        return null; // Lolos pengecekan
    }


    // TAHAP 1: Menampilkan Daftar Program Pelatihan
    public function index()
    {
        // 🔒 CEK GEMBOK SAKTI
        $gembok = $this->cekStatusBiodata();
        if ($gembok) return $gembok;

        $programs = ProgramPelatihan::all();
        
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
        // 🔒 CEK GEMBOK SAKTI (Mencegah user iseng ketik URL manual)
        $gembok = $this->cekStatusBiodata();
        if ($gembok) return $gembok;

        $program = ProgramPelatihan::findOrFail($program_id);
        
        $kelas = Kelas::with('instruktur.user')
                    ->where('program_pelatihan_id', $program_id) 
                    ->where(function ($query) {
                        $query->where('status_kelas', 'menunggu')
                              ->orWhereNull('tanggal_mulai')
                              ->orWhere('tanggal_mulai', '>=', now()->toDateString());
                    })
                    ->get();

        $peserta = Auth::user()->peserta;

        return view('peserta.pendaftaran.show_program', compact('program', 'kelas', 'peserta'));
    }

    // TAHAP 3: Menampilkan halaman konfirmasi pendaftaran
    public function create($kelas_id)
    {
        // 🔒 CEK GEMBOK SAKTI
        $gembok = $this->cekStatusBiodata();
        if ($gembok) return $gembok;

        $peserta = Auth::user()->peserta;
        $kelas = Kelas::with('programPelatihan')->findOrFail($kelas_id);

        // CEK APAKAH SUDAH PERNAH DAFTAR KELAS INI
        $sudahDaftar = Pendaftaran::where('peserta_id', $peserta->id)
            ->where('kelas_id', $kelas->id)
            ->first();

        if ($sudahDaftar) {
            if ($sudahDaftar->status_pembayaran == 'pending') {
                return redirect()->route('peserta.pembayaran.bayar', $sudahDaftar->id)
                    ->with('info', 'Anda memiliki tagihan yang belum dibayar untuk kelas ini.');
            }
            return redirect()->route('peserta.dashboard')
                ->with('error', 'Anda sudah terdaftar dan lunas di kelas ini.');
        }

        return view('peserta.pendaftaran.create', compact('kelas'));
    }

    // PROSES SIMPAN PENDAFTARAN LALU LEMPAR KE MIDTRANS
    public function store(Request $request, $kelas_id)
    {
        // 🔒 CEK GEMBOK SAKTI
        $gembok = $this->cekStatusBiodata();
        if ($gembok) return $gembok;

        $peserta = Auth::user()->peserta;
        $kelas = Kelas::findOrFail($kelas_id);

        $sudahDaftar = Pendaftaran::where('peserta_id', $peserta->id)
            ->where('kelas_id', $kelas->id)
            ->first();

        if ($sudahDaftar) {
            return redirect()->route('peserta.pembayaran.bayar', $sudahDaftar->id);
        }

        $pendaftaran = Pendaftaran::create([
            'peserta_id' => $peserta->id,
            'kelas_id' => $kelas->id,
            'tanggal_daftar' => now(),
            'status_pendaftaran' => 'menunggu_verifikasi', // Status otomatis berubah nanti setelah bayar
            'status_pembayaran' => 'pending', 
        ]);

        // FITUR BARU: Otomatis kirim pesan dari Admin ke Peserta
        $admin = \App\Models\User::where('role', 'admin')->first();
        if ($admin) {
            \App\Models\Pesan::create([
                'pengirim_id' => $admin->id,
                'penerima_id' => Auth::id(),
                'pesan' => 'Halo kak ' . Auth::user()->name . '! 👋 Terima kasih telah mendaftar di program pelatihan kami. Silakan selesaikan pembayaran agar kelas Anda bisa segera kami proses. Jika ada pertanyaan, jangan ragu untuk membalas pesan ini ya!',
                'kelas_id' => $kelas->id,
            ]);
        }

        return redirect()->route('peserta.pembayaran.bayar', $pendaftaran->id);
    }
    // FITUR BARU: Menampilkan Riwayat Pendaftaran & Pembayaran Peserta
    public function riwayat()
    {
        $peserta = Auth::user()->peserta;

        // Jika belum punya data peserta, lempar ke biodata
        if (!$peserta) {
            return redirect()->route('peserta.biodata.index')->with('error', 'Silakan lengkapi biodata terlebih dahulu.');
        }

        // Ambil semua riwayat dari yang terbaru
        $riwayat = Pendaftaran::with(['kelas.programPelatihan'])
            ->where('peserta_id', $peserta->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('peserta.riwayat.index', compact('riwayat'));
    }
    // Menampilkan Detail Riwayat Peserta
    public function showRiwayat($id)
    {
        $peserta = Auth::user()->peserta;

        if (!$peserta) {
            return redirect()->route('peserta.biodata.index')->with('error', 'Silakan lengkapi biodata terlebih dahulu.');
        }

        // Ambil data pendaftaran (Hanya milik peserta yang sedang login!)
        $pendaftaran = Pendaftaran::with(['kelas.programPelatihan'])
            ->where('id', $id)
            ->where('peserta_id', $peserta->id)
            ->firstOrFail();

        return view('peserta.riwayat.show', compact('pendaftaran'));
    }

    // Mencetak Kwitansi Peserta
    public function cetakKwitansi($id)
    {
        $peserta = Auth::user()->peserta;

        if (!$peserta) {
            return redirect()->route('peserta.biodata.index')->with('error', 'Silakan lengkapi biodata terlebih dahulu.');
        }

        // Ambil data (Keamanan ekstra: pastikan ini milik peserta yang login)
        $pendaftaran = Pendaftaran::with(['kelas.programPelatihan', 'peserta.user'])
            ->where('id', $id)
            ->where('peserta_id', $peserta->id)
            ->firstOrFail();

        if ($pendaftaran->status_pembayaran != 'sukses') {
            return back()->with('error', 'Kwitansi belum dapat dicetak karena tagihan belum lunas.');
        }

        return view('peserta.riwayat.cetak', compact('pendaftaran'));
    }

    // FITUR BARU: Menghapus pendaftaran yang belum lunas (Peserta)
    public function destroy($id)
    {
        $peserta = Auth::user()->peserta;

        if (!$peserta) {
            return redirect()->route('peserta.biodata.index')->with('error', 'Silakan lengkapi biodata terlebih dahulu.');
        }

        $pendaftaran = Pendaftaran::where('id', $id)
            ->where('peserta_id', $peserta->id)
            ->firstOrFail();

        // Peserta tidak boleh menghapus yang sudah lunas
        if ($pendaftaran->status_pembayaran === 'sukses') {
            return back()->with('error', 'Gagal! Pendaftaran yang sudah lunas tidak dapat dibatalkan.');
        }

        $pendaftaran->delete();

        return redirect()->route('peserta.riwayat.index')->with('success', 'Pendaftaran kelas berhasil dibatalkan dan dihapus.');
    }
}