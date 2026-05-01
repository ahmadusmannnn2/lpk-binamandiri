<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class VerifikasiPembayaranController extends Controller
{
    // 1. Tampilkan Semua Riwayat Transaksi / Pembayaran
    public function index()
    {
        // Ambil semua data pendaftaran yang sudah punya status pembayaran
        $pembayaran = Pendaftaran::with(['peserta.user', 'kelas.programPelatihan'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.verifikasi_pembayaran.index', compact('pembayaran'));
    }

    // 2. Update Status Manual (Opsional, buat jaga-jaga jika Admin perlu override manual)
    public function update(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        
        $pendaftaran->update([
            'status_pendaftaran' => $request->status_pendaftaran,
            // Admin bisa memaksa set lunas jika misalnya ada kendala di Midtrans
            'status_pembayaran' => $request->status_pembayaran 
        ]);

        return back()->with('success', 'Status Pendaftaran & Pembayaran berhasil diperbarui!');
    }

    // 3. Fitur Cetak Kwitansi Resmi
    public function cetakKwitansi($id)
    {
        $pendaftaran = Pendaftaran::with(['peserta.user', 'kelas.programPelatihan'])->findOrFail($id);
        
        // Pastikan hanya yang sudah sukses yang bisa dicetak
        if ($pendaftaran->status_pembayaran != 'sukses') {
            return back()->with('error', 'Kwitansi belum dapat dicetak karena pembayaran belum lunas.');
        }

        return view('admin.verifikasi_pembayaran.cetak', compact('pendaftaran'));
    }
    // Fungsi Baru: Tampilkan Detail Pembayaran (Halaman Kelola)
    public function show($id)
    {
        $pendaftaran = Pendaftaran::with(['peserta.user', 'kelas.programPelatihan'])->findOrFail($id);
        
        return view('admin.verifikasi_pembayaran.show', compact('pendaftaran'));
    }
}