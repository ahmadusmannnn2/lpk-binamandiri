<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Pendaftaran;
use App\Models\Pertemuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // WAJIB TAMBAH INI UNTUK UPLOAD MATERI

class PertemuanController extends Controller
{
    // 1. Menyimpan Pertemuan Baru (Ditambah Upload Materi)
    public function store(Request $request, $kelas_id)
    {
        $kelas = Kelas::findOrFail($kelas_id);
        if ($kelas->instruktur_id !== \Illuminate\Support\Facades\Auth::user()->instruktur->id) {
            abort(403, 'Anda tidak memiliki akses ke kelas ini.');
        }
        $request->validate([
            'judul_pertemuan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'fase_kelas_id' => 'required|exists:fase_kelas,id',
            'file_materi' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar|max:5120', // Maks 5MB
        ]);

        // CEK BATAS TARGET PERTEMUAN
        $fase = \App\Models\FaseKelas::findOrFail($request->fase_kelas_id);
        $jumlahPertemuanSaatIni = \App\Models\Pertemuan::where('fase_kelas_id', $fase->id)->count();
        if ($jumlahPertemuanSaatIni >= $fase->target_pertemuan) {
            return back()->with('error', "Gagal! Anda tidak bisa menambah jadwal lagi. Target maksimal untuk fase {$fase->nama_fase} adalah {$fase->target_pertemuan} pertemuan.");
        }

        $materiPath = null;
        if ($request->hasFile('file_materi')) {
            $materiPath = $request->file('file_materi')->store('materi_pertemuan', 'public');
        }

        $pertemuan = Pertemuan::create([
            'kelas_id' => $kelas_id,
            'fase_kelas_id' => $request->fase_kelas_id,
            'judul_pertemuan' => $request->judul_pertemuan,
            'tanggal' => $request->tanggal,
            'file_materi' => $materiPath, // Simpan path materi
        ]);

        // Otomatis buatkan draf absen "Alpa" untuk semua peserta yang disetujui di kelas ini
        $pesertaKelas = Pendaftaran::where('kelas_id', $kelas_id)->where('status_pendaftaran', 'disetujui')->get();
        foreach ($pesertaKelas as $peserta) {
            Absensi::create([
                'pertemuan_id' => $pertemuan->id,
                'pendaftaran_id' => $peserta->id,
                'status' => 'alpa'
            ]);
        }

        $this->updatePersentaseKehadiran($kelas_id);

        return back()->with('success', 'Pertemuan & Materi berhasil ditambahkan!');
    }

    // 2. Menampilkan Form Absensi
    public function show($id)
    {
        $pertemuan = Pertemuan::with('kelas.programPelatihan')->findOrFail($id);
        if ($pertemuan->kelas->instruktur_id !== \Illuminate\Support\Facades\Auth::user()->instruktur->id) {
            abort(403, 'Anda tidak memiliki akses ke jadwal ini.');
        }

        $absensi = Absensi::with('pendaftaran.peserta.user')->where('pertemuan_id', $id)->get();

        return view('instruktur.pertemuan.show', compact('pertemuan', 'absensi'));
    }

    // 3. Menyimpan Perubahan Absensi, Nilai, dan Catatan
    public function simpanAbsensi(Request $request, $id)
    {
        $request->validate([
            'absensi.*.status' => 'required|in:hadir,alpa',
            'absensi.*.nilai'  => 'nullable|numeric|min:0|max:100',
            'absensi.*.catatan'=> 'nullable|string|max:500',
        ]);

        $pertemuan = Pertemuan::findOrFail($id);
        if ($pertemuan->kelas->instruktur_id !== \Illuminate\Support\Facades\Auth::user()->instruktur->id) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        if ($request->has('absensi')) {
            foreach ($request->absensi as $absensi_id => $data) {
                Absensi::where('id', $absensi_id)->update([
                    'status' => $data['status'],
                    'nilai' => $data['nilai'] ?? null,
                    'catatan' => $data['catatan'] ?? null,
                ]);
            }
        }

        $this->updatePersentaseKehadiran($pertemuan->kelas_id);

        return back()->with('success', 'Absensi, Nilai, dan Catatan berhasil disimpan!');
    }

    // 4. Menghapus Pertemuan
    public function destroy($id)
    {
        $pertemuan = Pertemuan::findOrFail($id);
        if ($pertemuan->kelas->instruktur_id !== \Illuminate\Support\Facades\Auth::user()->instruktur->id) {
            abort(403, 'Anda tidak memiliki akses.');
        }
        $kelas_id = $pertemuan->kelas_id;
        
        // Hapus file materi jika ada
        if ($pertemuan->file_materi && Storage::disk('public')->exists($pertemuan->file_materi)) {
            Storage::disk('public')->delete($pertemuan->file_materi);
        }

        $pertemuan->delete(); // Otomatis cascade absensi
        $this->updatePersentaseKehadiran($kelas_id);

        return redirect()->route('instruktur.jadwal.show', $kelas_id)->with('success', 'Pertemuan/Jadwal berhasil dihapus secara permanen!');
    }

    // 5. Update Materi
    public function updateMateri(Request $request, $id)
    {
        $pertemuan = Pertemuan::findOrFail($id);
        if ($pertemuan->kelas->instruktur_id !== \Illuminate\Support\Facades\Auth::user()->instruktur->id) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $request->validate([
            'file_materi' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar|max:5120',
        ]);

        if ($request->hasFile('file_materi')) {
            // Hapus file lama jika ada
            if ($pertemuan->file_materi && Storage::disk('public')->exists($pertemuan->file_materi)) {
                Storage::disk('public')->delete($pertemuan->file_materi);
            }
            $materiPath = $request->file('file_materi')->store('materi_pertemuan', 'public');
            $pertemuan->update(['file_materi' => $materiPath]);
        }

        return back()->with('success', 'Materi berhasil diperbarui!');
    }

    // 6. Hapus Materi
    public function destroyMateri($id)
    {
        $pertemuan = Pertemuan::findOrFail($id);
        if ($pertemuan->kelas->instruktur_id !== \Illuminate\Support\Facades\Auth::user()->instruktur->id) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        if ($pertemuan->file_materi && Storage::disk('public')->exists($pertemuan->file_materi)) {
            Storage::disk('public')->delete($pertemuan->file_materi);
            $pertemuan->update(['file_materi' => null]);
        }

        return back()->with('success', 'Materi berhasil dihapus!');
    }

    private function updatePersentaseKehadiran($kelas_id)
    {
        $total_pertemuan = Pertemuan::where('kelas_id', $kelas_id)->count();
        if ($total_pertemuan == 0) return;

        $pendaftarans = Pendaftaran::where('kelas_id', $kelas_id)->where('status_pendaftaran', 'disetujui')->get();

        foreach ($pendaftarans as $p) {
            $total_hadir = Absensi::whereHas('pertemuan', function($query) use ($kelas_id) {
                $query->where('kelas_id', $kelas_id);
            })->where('pendaftaran_id', $p->id)->where('status', 'hadir')->count();

            $persentase = round(($total_hadir / $total_pertemuan) * 100);
            $p->update(['kehadiran' => $persentase]);
        }
    }
}