<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramPelatihan;
use Illuminate\Http\Request;

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
        ]);

        ProgramPelatihan::create($request->all());

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
        ]);

        $program = ProgramPelatihan::findOrFail($id);
        $program->update($request->all());

        return redirect()->route('admin.program.index')->with('success', 'Program Pelatihan berhasil diperbarui!');
    }

    // Menghapus data program (Soft Delete)
    public function destroy($id)
    {
        $program = ProgramPelatihan::findOrFail($id);
        $program->delete();

        return redirect()->route('admin.program.index')->with('success', 'Program Pelatihan berhasil dihapus!');
    }
}