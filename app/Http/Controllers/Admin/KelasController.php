<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\ProgramPelatihan;
use App\Models\Instruktur;
use App\Models\Pendaftaran; // <--- INI KUNCI PENYELESAIANNYA
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        // Canggih: Mengambil data Kelas sekaligus memanggil relasi Program, Instruktur, dan nama User Instruktur (Eager Loading)
        $kelas = Kelas::with(['programPelatihan', 'instruktur.user'])->latest()->get();
        return view('admin.kelas.index', compact('kelas'));
    }

    public function create()
    {
        // Mengambil master data untuk dijadikan Dropdown Pilihan
        $program = ProgramPelatihan::all();
        $instruktur = Instruktur::with('user')->get();
        return view('admin.kelas.create', compact('program', 'instruktur'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'program_pelatihan_id' => 'required|exists:program_pelatihan,id',
            'instruktur_id' => 'required|exists:instruktur,id',
            'kuota_peserta' => 'required|integer|min:1',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status_kelas' => 'required|in:menunggu,berjalan,selesai',
        ]);

        Kelas::create($request->all());

        return redirect()->route('admin.kelas.index')->with('success', 'Data Kelas berhasil dibuat!');
    }

    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        $program = ProgramPelatihan::all();
        $instruktur = Instruktur::with('user')->get();
        
        return view('admin.kelas.edit', compact('kelas', 'program', 'instruktur'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'program_pelatihan_id' => 'required|exists:program_pelatihan,id',
            'instruktur_id' => 'required|exists:instruktur,id',
            'kuota_peserta' => 'required|integer|min:1',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status_kelas' => 'required|in:menunggu,berjalan,selesai',
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update($request->all());

        return redirect()->route('admin.kelas.index')->with('success', 'Data Kelas berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        
        // CEK PENGAMAN: Apakah kelas ini sudah ada pendaftarnya?
        $jumlahPendaftar =  Pendaftaran::where('kelas_id', $id)->count();
        
        if ($jumlahPendaftar > 0) {
            // Jika ada pesertanya, TOLAK PENGHAPUSAN!
            return redirect()->route('admin.kelas.index')->with('error', 'TOLAK: Kelas tidak dapat dihapus karena sudah ada ' . $jumlahPendaftar . ' peserta yang mendaftar. Jika kelas sudah berakhir, silakan edit dan ubah statusnya menjadi "Selesai".');
        }

        // Jika kelas masih kosong / belum ada yang daftar, boleh dihapus
        $kelas->delete();

        return redirect()->route('admin.kelas.index')->with('success', 'Data Kelas berhasil dihapus secara permanen!');
    }

    public function show($id)
    {
        $kelas = Kelas::with(['programPelatihan', 'instruktur.user'])->findOrFail($id);
        
        $pendaftaran = Pendaftaran::with('peserta.user')
            ->where('kelas_id', $id)
            ->whereIn('status_pendaftaran', ['disetujui', 'selesai'])
            ->get();

        // Ambil daftar kelas lain (untuk opsi pemindahan peserta)
        $kelasLain = Kelas::with('programPelatihan')
            ->where('id', '!=', $id)
            ->whereIn('status_kelas', ['menunggu', 'berjalan'])
            ->get();

        return view('admin.kelas.show', compact('kelas', 'pendaftaran', 'kelasLain'));
    }

    // Fitur Memindahkan Peserta ke Kelas Lain
    public function pindahPeserta(Request $request, $kelas_id, $pendaftaran_id)
    {
        $request->validate([
            'kelas_baru_id' => 'required|exists:kelas,id'
        ]);

        $pendaftaran = Pendaftaran::findOrFail($pendaftaran_id);
        
        // Pastikan pendaftaran ini memang dari kelas asalnya
        if ($pendaftaran->kelas_id == $kelas_id) {
            $pendaftaran->update([
                'kelas_id' => $request->kelas_baru_id
            ]);
            return back()->with('success', 'Peserta berhasil dipindahkan ke kelas baru!');
        }

        return back()->with('error', 'Terjadi kesalahan validasi data pendaftaran.');
    }
}