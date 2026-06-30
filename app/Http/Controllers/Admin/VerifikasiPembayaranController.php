<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\ProgramPelatihan;
use Illuminate\Http\Request;

class VerifikasiPembayaranController extends Controller
{
    // --- FUNGSI PINTAR UNTUK LOGIKA FILTER ---
    private function filterData(Request $request)
    {
        $query = Pendaftaran::with(['peserta.user', 'kelas.programPelatihan'])
            ->orderBy('created_at', 'desc');

        $query->when($request->search, function ($q, $search) {
            $q->where(function ($subQ) use ($search) {
                // Ekstrak ID jika formatnya mirip Order ID Midtrans (misal LPK-1-123456 jadi 1)
                $orderId = null;
                if (preg_match('/^(?:LPK-|lpk-)?(\d+)/', $search, $matches)) {
                    $orderId = $matches[1];
                }

                if ($orderId) {
                    $subQ->where('id', $orderId);
                }

                $subQ->orWhereHas('peserta.user', function ($userQ) use ($search) {
                    $userQ->where('name', 'like', '%' . $search . '%'); 
                })
                ->orWhereHas('peserta', function ($pesertaQ) use ($search) {
                    $pesertaQ->where('nik', 'like', '%' . $search . '%'); 
                });
            });
        });

        $query->when($request->status, function ($q, $status) {
            $q->where('status_pembayaran', $status);
        });

        $query->when($request->program, function ($q, $program) {
            $q->whereHas('kelas', function ($kelasQ) use ($program) {
                $kelasQ->where('program_pelatihan_id', $program);
            });
        });

        return $query;
    }

    // 1. Tampilkan Halaman Utama
    public function index(Request $request)
    {
        $programs = ProgramPelatihan::all();
        $query = $this->filterData($request);
        
        $pembayaran = $query->paginate(15)->withQueryString();

        return view('admin.verifikasi_pembayaran.index', compact('pembayaran', 'programs'));
    }

    // --- FITUR BARU: CETAK SEMUA DATA TRANSAKSI BERDASARKAN FILTER ---
    public function cetakSemua(Request $request)
    {
        $query = $this->filterData($request);
        
        // Ambil SEMUA data yang lolos filter (tanpa pagination)
        $pembayaran = $query->get();

        return view('admin.verifikasi_pembayaran.cetak_semua', compact('pembayaran'));
    }

    // 2. Tampilkan Detail Pembayaran (Halaman Kelola)
    public function show($id)
    {
        $pendaftaran = Pendaftaran::with(['peserta.user', 'kelas.programPelatihan'])->findOrFail($id);
        return view('admin.verifikasi_pembayaran.show', compact('pendaftaran'));
    }

    // 3. Update Status Manual
    public function update(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update([
            'status_pendaftaran' => $request->status_pendaftaran,
            'status_pembayaran' => $request->status_pembayaran 
        ]);
        return back()->with('success', 'Status Pendaftaran & Pembayaran berhasil diperbarui!');
    }

    // 4. Fitur Cetak Kwitansi Resmi Individu
    public function cetakKwitansi($id)
    {
        $pendaftaran = Pendaftaran::with(['peserta.user', 'kelas.programPelatihan'])->findOrFail($id);
        if ($pendaftaran->status_pembayaran != 'sukses') {
            return back()->with('error', 'Kwitansi belum dapat dicetak karena pembayaran belum lunas.');
        }
        return view('admin.verifikasi_pembayaran.cetak', compact('pendaftaran'));
    }

    // 5. Fitur Hapus Pendaftaran (Admin Darurat)
    public function destroy($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->delete();

        return redirect()->route('admin.verifikasi_pembayaran.index')->with('success', 'Data pendaftaran peserta berhasil dihapus dari sistem.');
    }
}