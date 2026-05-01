<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    // 1. Menampilkan Daftar Biodata Peserta yang Perlu Diverifikasi
    public function index()
    {
        // Ambil peserta yang status biodatanya sedang 'menunggu'
        $pesertaMenunggu = Peserta::with('user')
            ->where('status_biodata', 'menunggu')
            ->latest()
            ->get();
        
        // Ambil riwayat verifikasi (yang sudah disetujui/ditolak)
        $pesertaRiwayat = Peserta::with('user')
            ->whereIn('status_biodata', ['disetujui', 'ditolak'])
            ->latest()
            ->get();

        return view('admin.verifikasi.index', compact('pesertaMenunggu', 'pesertaRiwayat'));
    }

    // 2. Menampilkan Detail Berkas (KTP, Ijazah, dll) untuk ditinjau
    public function show($id)
    {
        $peserta = Peserta::with('user')->findOrFail($id);
        return view('admin.verifikasi.show', compact('peserta'));
    }

    // 3. Memproses Keputusan (Setuju / Tolak)
    public function update(Request $request, $id)
    {
        $request->validate([
            'status_biodata' => 'required|in:disetujui,ditolak',
            'catatan_biodata' => 'required_if:status_biodata,ditolak', // Wajib diisi jika Admin menolak
        ]);

        $peserta = Peserta::findOrFail($id);

        $peserta->update([
            'status_biodata' => $request->status_biodata,
            // Jika ditolak simpan pesannya, jika disetujui kosongkan
            'catatan_biodata' => $request->status_biodata == 'ditolak' ? $request->catatan_biodata : null, 
        ]);

        $pesan = $request->status_biodata == 'disetujui' 
            ? 'Biodata peserta berhasil disetujui! Peserta sekarang dapat mendaftar kelas.' 
            : 'Biodata peserta ditolak. Peserta telah diminta untuk memperbaiki datanya.';

        // UBAH BARIS INI:
        return redirect()->route('admin.verifikasi.index')->with('success', $pesan);
    }
}