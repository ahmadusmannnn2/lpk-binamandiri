<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    public function index($kelas_id)
    {
        $instruktur = Auth::user()->instruktur;
        // Pastikan kelas ini milik instruktur yang sedang login
        $kelas = Kelas::where('id', $kelas_id)->where('instruktur_id', $instruktur->id)->firstOrFail();
        $materi = Materi::where('kelas_id', $kelas_id)->latest()->get();

        return view('instruktur.materi.index', compact('kelas', 'materi'));
    }

    public function store(Request $request, $kelas_id)
    {
        $kelas = Kelas::findOrFail($kelas_id);
        if ($kelas->instruktur_id !== Auth::user()->instruktur->id) {
            abort(403, 'Akses Ditolak');
        }

        $request->validate([
            'judul_materi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file_materi' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,zip|max:5120', // Maksimal 5MB
        ]);

        $filePath = $request->file('file_materi')->store('materi_pelatihan', 'public');

        Materi::create([
            'kelas_id' => $kelas_id,
            'judul_materi' => $request->judul_materi,
            'deskripsi' => $request->deskripsi,
            'file_materi' => $filePath,
        ]);

        return back()->with('success', 'Materi berhasil diunggah!');
    }

    public function destroy($id)
    {
        $materi = Materi::findOrFail($id);
        if ($materi->kelas->instruktur_id !== Auth::user()->instruktur->id) {
            abort(403, 'Akses Ditolak');
        }
        
        // Hapus file fisik
        if (Storage::disk('public')->exists($materi->file_materi)) {
            Storage::disk('public')->delete($materi->file_materi);
        }
        
        $materi->delete();

        return back()->with('success', 'Materi berhasil dihapus!');
    }
}