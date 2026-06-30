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
    public function index(Request $request)
    {
        $programs = ProgramPelatihan::all();
        $today = now()->toDateString();

        $query = Kelas::with(['programPelatihan', 'instruktur.user'])
            ->withCount(['pendaftaran' => function($q) {
                $q->where('status_pendaftaran', 'disetujui');
            }]);

        // --- PENCARIAN ---
        $query->when($request->search, function ($q, $search) {
            $q->where('nama_kelas', 'like', '%' . $search . '%')
              ->orWhereHas('instruktur.user', function ($instrukturQ) use ($search) {
                  $instrukturQ->where('name', 'like', '%' . $search . '%');
              });
        });

        // --- FILTER STATUS OTOMATIS DARI TANGGAL ---
        $query->when($request->status, function ($q, $status) use ($today) {
            if ($status === 'akan_datang') {
                $q->where('tanggal_mulai', '>', $today);
            } elseif ($status === 'berjalan') {
                $q->where('tanggal_mulai', '<=', $today)->where('tanggal_selesai', '>=', $today);
            } elseif ($status === 'selesai') {
                $q->where('tanggal_selesai', '<', $today);
            }
        });

        // --- FILTER PROGRAM ---
        $query->when($request->program, function ($q, $program) {
            $q->where('program_pelatihan_id', $program);
        });

        // --- URUTAN ---
        $urutan = $request->urutan ?? 'terbaru';
        if ($urutan === 'terlama') {
            $query->orderBy('created_at', 'asc');
        } elseif ($urutan === 'mulai_asc') {
            $query->orderBy('tanggal_mulai', 'asc');
        } elseif ($urutan === 'mulai_desc') {
            $query->orderBy('tanggal_mulai', 'desc');
        } else {
            $query->orderBy('created_at', 'desc'); // default: terbaru
        }

        $kelas = $query->paginate(15)->withQueryString();

        return view('admin.kelas.index', compact('kelas', 'programs'));
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
            'program_pelatihan_id' => 'required|exists:program_pelatihan,id',
            'instruktur_id'        => 'required|exists:instruktur,id',
            'nama_kelas'           => 'required|string|max:255',
            'kuota_peserta'        => 'required|integer|min:1',
            'tanggal_mulai'        => 'required|date',
        ]);

        $program = ProgramPelatihan::findOrFail($request->program_pelatihan_id);

        $tanggalSelesaiOtomatis = \Carbon\Carbon::parse($request->tanggal_mulai)
            ->addWeekdays($program->durasi_hari - 1)
            ->format('Y-m-d');

        // Status kelas ditentukan otomatis dari tanggal
        $today = now()->toDateString();
        if ($request->tanggal_mulai > $today) {
            $statusOtomatis = 'menunggu';
        } elseif ($tanggalSelesaiOtomatis >= $today) {
            $statusOtomatis = 'berjalan';
        } else {
            $statusOtomatis = 'selesai';
        }

        Kelas::create([
            'program_pelatihan_id' => $request->program_pelatihan_id,
            'instruktur_id'        => $request->instruktur_id,
            'nama_kelas'           => $request->nama_kelas,
            'kuota_peserta'        => $request->kuota_peserta,
            'tanggal_mulai'        => $request->tanggal_mulai,
            'tanggal_selesai'      => $tanggalSelesaiOtomatis,
            'status_kelas'         => $statusOtomatis,
        ]);

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil ditambahkan! Status dan tanggal selesai dihitung otomatis.');
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
            'program_pelatihan_id' => 'required|exists:program_pelatihan,id',
            'instruktur_id'        => 'required|exists:instruktur,id',
            'nama_kelas'           => 'required|string|max:255',
            'kuota_peserta'        => 'required|integer|min:1',
            'tanggal_mulai'        => 'required|date',
        ]);

        $kelas = Kelas::findOrFail($id);
        $program = ProgramPelatihan::findOrFail($request->program_pelatihan_id);

        $tanggalSelesaiOtomatis = \Carbon\Carbon::parse($request->tanggal_mulai)
            ->addWeekdays($program->durasi_hari - 1)
            ->format('Y-m-d');

        // Status kelas dihitung ulang otomatis dari tanggal
        $today = now()->toDateString();
        if ($request->tanggal_mulai > $today) {
            $statusOtomatis = 'menunggu';
        } elseif ($tanggalSelesaiOtomatis >= $today) {
            $statusOtomatis = 'berjalan';
        } else {
            $statusOtomatis = 'selesai';
        }

        $kelas->update([
            'program_pelatihan_id' => $request->program_pelatihan_id,
            'instruktur_id'        => $request->instruktur_id,
            'nama_kelas'           => $request->nama_kelas,
            'kuota_peserta'        => $request->kuota_peserta,
            'tanggal_mulai'        => $request->tanggal_mulai,
            'tanggal_selesai'      => $tanggalSelesaiOtomatis,
            'status_kelas'         => $statusOtomatis,
        ]);

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil diperbarui! Status dihitung otomatis dari tanggal.');
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
        // Kelas tujuan pindah: yang belum selesai (tanggal_selesai >= hari ini)
        $kelasLain = Kelas::with('programPelatihan')
            ->where('id', '!=', $id)
            ->where('tanggal_selesai', '>=', now()->toDateString())
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