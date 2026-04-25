<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        // Ubah data pengaturan menjadi format array yang mudah dibaca: ['kunci' => 'nilai']
        $pengaturan = Pengaturan::pluck('nilai', 'kunci')->toArray();
        return view('admin.pengaturan.index', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        // Ambil semua input kecuali token CSRF dan method PUT
        $data = $request->except(['_token', '_method']);

        foreach ($data as $kunci => $nilai) {
            // Update jika kunci ada, atau buat baru jika tidak ada
            Pengaturan::updateOrCreate(
                ['kunci' => $kunci],
                ['nilai' => $nilai]
            );
        }

        return back()->with('success', 'Konten Landing Page berhasil diperbarui!');
    }
}