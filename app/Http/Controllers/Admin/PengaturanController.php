<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    public function index()
    {
        $pengaturan = Pengaturan::pluck('nilai', 'kunci')->toArray();
        return view('admin.pengaturan.index', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        // Validasi khusus logo jika diupload
        $request->validate([
            'logo_navbar' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $data = $request->except(['_token', '_method']);

        foreach ($data as $kunci => $nilai) {
            // KHUSUS JIKA ADA FILE YANG DIUPLOAD
            if ($request->hasFile($kunci)) {
                // Hapus logo lama jika ada
                $logoLama = Pengaturan::where('kunci', $kunci)->value('nilai');
                if ($logoLama && Storage::disk('public')->exists($logoLama)) {
                    Storage::disk('public')->delete($logoLama);
                }

                // Simpan logo baru
                $file = $request->file($kunci);
                $nilai = $file->store('pengaturan_web', 'public');
            }

            // Simpan ke database
            if ($nilai !== null) {
                Pengaturan::updateOrCreate(
                    ['kunci' => $kunci],
                    ['nilai' => $nilai]
                );
            }
        }

        return back()->with('success', 'Pengaturan Web & Logo berhasil diperbarui!');
    }
}