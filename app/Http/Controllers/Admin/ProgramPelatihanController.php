<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramPelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProgramPelatihanController extends Controller
{
    // Menampilkan halaman daftar program
    public function index()
    {
        $program = ProgramPelatihan::latest()->get();
        return view('admin.program.index', compact('program'));
    }

    // Menampilkan form tambah program
    public function create()
    {
        return view('admin.program.create');
    }

    // Menyimpan data program baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama_program' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga_pelatihan' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('program_pelatihan', 'public');
        }

        ProgramPelatihan::create($data);

        return redirect()->route('admin.program.index')->with('success', 'Program Pelatihan berhasil ditambahkan!');
    }

    // Menampilkan form edit program
    public function edit($id)
    {
        $program = ProgramPelatihan::findOrFail($id);
        return view('admin.program.edit', compact('program'));
    }

    // Menyimpan perubahan data program
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_program' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga_pelatihan' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $program = ProgramPelatihan::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('gambar')) {
            if ($program->gambar && Storage::disk('public')->exists($program->gambar)) {
                Storage::disk('public')->delete($program->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('program_pelatihan', 'public');
        }

        $program->update($data);

        return redirect()->route('admin.program.index')->with('success', 'Program Pelatihan berhasil diperbarui!');
    }

    // Menghapus data program (Soft Delete)
    public function destroy($id)
    {
        $program = ProgramPelatihan::findOrFail($id);
        
        // CEK PENGAMAN: Apakah program ini punya kelas yang terkait?
        $jumlahKelas = \App\Models\Kelas::where('program_pelatihan_id', $id)->count();
        
        if ($jumlahKelas > 0) {
            return redirect()->route('admin.program.index')->with('error', 'TOLAK: Program ini tidak bisa dihapus karena masih memiliki ' . $jumlahKelas . ' kelas/angkatan. Silakan hapus atau ubah kelas tersebut terlebih dahulu.');
        }

        if ($program->gambar && Storage::disk('public')->exists($program->gambar)) {
            Storage::disk('public')->delete($program->gambar);
        }

        $program->delete();

        return redirect()->route('admin.program.index')->with('success', 'Program Pelatihan berhasil dihapus!');
    }
}