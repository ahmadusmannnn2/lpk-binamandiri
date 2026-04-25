<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function index()
    {
        // Mengambil semua data pendaftaran lengkap dengan relasinya
        $pendaftaran = Pendaftaran::with(['peserta.user', 'kelas.programPelatihan'])->latest()->get();
        return view('admin.verifikasi.index', compact('pendaftaran'));
    }

    public function show($id)
    {
        // Mengambil detail 1 pendaftaran untuk diverifikasi
        $pendaftaran = Pendaftaran::with(['peserta.user', 'kelas.programPelatihan'])->findOrFail($id);
        return view('admin.verifikasi.show', compact('pendaftaran'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status_pendaftaran' => 'required|in:menunggu_verifikasi,disetujui,ditolak',
            'keterangan_admin' => 'nullable|string'
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);
        
        $pendaftaran->update([
            'status_pendaftaran' => $request->status_pendaftaran,
            'keterangan_admin' => $request->keterangan_admin,
        ]);

        return redirect()->route('admin.verifikasi.index')->with('success', 'Status pendaftaran peserta berhasil diperbarui!');
    }
}