<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    // 1. Tampilkan Daftar Peserta dengan Filter & Pencarian
    public function index(Request $request)
    {
        // Mulai Query Dasar: Hanya ambil yang sudah mengisi biodata minimal (bukan 'belum_isi')
        $query = Peserta::with('user')
            ->where('status_biodata', '!=', 'belum_isi')
            ->orderByRaw("FIELD(status_biodata, 'menunggu', 'ditolak', 'disetujui')") // Prioritaskan yang menunggu di atas
            ->orderBy('updated_at', 'desc');

        // --- LOGIKA PENCARIAN (SEARCH) ---
        $query->when($request->search, function ($q, $search) {
            $q->where(function ($subQ) use ($search) {
                $subQ->where('nik', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($userQ) use ($search) {
                        $userQ->where('name', 'like', '%' . $search . '%')
                              ->orWhere('email', 'like', '%' . $search . '%');
                    });
            });
        });

        // --- LOGIKA FILTER STATUS BIODATA ---
        $query->when($request->status, function ($q, $status) {
            $q->where('status_biodata', $status);
        });

        // Eksekusi Query dengan Pagination (15 data per halaman)
        $peserta = $query->paginate(15)->withQueryString();

        return view('admin.verifikasi.index', compact('peserta'));
    }

    // 2. Tampilkan Detail Biodata
    public function show($id)
    {
        $peserta = Peserta::with('user')->findOrFail($id);
        return view('admin.verifikasi.show', compact('peserta'));
    }

    // 3. Update Status Biodata
    public function update(Request $request, $id)
    {
        $request->validate([
            'status_biodata' => 'required|in:disetujui,ditolak',
            'catatan_biodata' => 'nullable|string'
        ]);

        $peserta = Peserta::findOrFail($id);
        $peserta->update([
            'status_biodata' => $request->status_biodata,
            'catatan_biodata' => $request->status_biodata === 'ditolak' ? $request->catatan_biodata : null,
        ]);

        $pesan = $request->status_biodata === 'disetujui' 
            ? 'Biodata peserta berhasil disetujui!' 
            : 'Biodata peserta ditolak dan dikembalikan untuk diperbaiki.';

        return redirect()->route('admin.verifikasi.index')->with('success', $pesan);
    }
}