<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Pendaftaran;
use App\Models\Pertemuan;
use Illuminate\Http\Request;

class PertemuanController extends Controller
{
    // 1. Menyimpan Pertemuan Baru
    public function store(Request $request, $kelas_id)
    {
        $request->validate([
            'judul_pertemuan' => 'required|string|max:255',
            'tanggal' => 'required|date',
        ]);

        $pertemuan = Pertemuan::create([
            'kelas_id' => $kelas_id,
            'judul_pertemuan' => $request->judul_pertemuan,
            'tanggal' => $request->tanggal,
        ]);

        // Canggih: Otomatis buatkan draf absen "Alpa" untuk semua peserta yang disetujui di kelas ini
        $pesertaKelas = Pendaftaran::where('kelas_id', $kelas_id)->where('status_pendaftaran', 'disetujui')->get();
        foreach ($pesertaKelas as $peserta) {
            Absensi::create([
                'pertemuan_id' => $pertemuan->id,
                'pendaftaran_id' => $peserta->id,
                'status' => 'alpa' // Default jika belum diabsen instruktur
            ]);
        }

        $this->updatePersentaseKehadiran($kelas_id);

        return back()->with('success', 'Jadwal Pertemuan berhasil ditambahkan!');
    }

    // 2. Menampilkan Form Absensi untuk 1 Pertemuan
    public function show($id)
    {
        $pertemuan = Pertemuan::with('kelas.programPelatihan')->findOrFail($id);
        $absensi = Absensi::with('pendaftaran.peserta.user')->where('pertemuan_id', $id)->get();

        return view('instruktur.pertemuan.show', compact('pertemuan', 'absensi'));
    }

    // 3. Menyimpan Perubahan Absensi
    public function simpanAbsensi(Request $request, $id)
    {
        $request->validate([
            'absensi.*.status' => 'required|in:hadir,izin,sakit,alpa',
        ]);

        $pertemuan = Pertemuan::findOrFail($id);

        // Update status absensi tiap peserta
        if ($request->has('absensi')) {
            foreach ($request->absensi as $absensi_id => $data) {
                Absensi::where('id', $absensi_id)->update(['status' => $data['status']]);
            }
        }

        // Hitung ulang persentase kehadiran
        $this->updatePersentaseKehadiran($pertemuan->kelas_id);

        return back()->with('success', 'Data Absensi Harian berhasil disimpan!');
    }

    // 4. Menghapus Pertemuan
    public function destroy($id)
    {
        $pertemuan = Pertemuan::findOrFail($id);
        $kelas_id = $pertemuan->kelas_id;
        $pertemuan->delete(); // Ini otomatis akan menghapus data absensi terkait karena cascade

        $this->updatePersentaseKehadiran($kelas_id);

        return back()->with('success', 'Pertemuan berhasil dihapus!');
    }

    // --- FUNGSI KECERDASAN (AUTO CALCULATE PERSENTASE) ---
    private function updatePersentaseKehadiran($kelas_id)
    {
        $total_pertemuan = Pertemuan::where('kelas_id', $kelas_id)->count();
        if ($total_pertemuan == 0) return; // Cegah error dibagi 0

        $pendaftarans = Pendaftaran::where('kelas_id', $kelas_id)->where('status_pendaftaran', 'disetujui')->get();

        foreach ($pendaftarans as $p) {
            // Hitung berapa kali peserta ini "hadir" di kelas ini
            $total_hadir = Absensi::whereHas('pertemuan', function($query) use ($kelas_id) {
                $query->where('kelas_id', $kelas_id);
            })->where('pendaftaran_id', $p->id)->where('status', 'hadir')->count();

            // Hitung persentase
            $persentase = round(($total_hadir / $total_pertemuan) * 100);
            
            // Update tabel pendaftaran (yang dipakai untuk nilai akhir)
            $p->update(['kehadiran' => $persentase]);
        }
    }
}