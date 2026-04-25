<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BiodataController extends Controller
{
    public function index()
    {
        $peserta = Auth::user()->peserta;
        return view('peserta.biodata.index', compact('peserta'));
    }

    public function update(Request $request)
    {
        $peserta = Auth::user()->peserta;

        $request->validate([
            'nik' => 'required|string|max:16|unique:peserta,nik,'.$peserta->id,
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'nomor_telepon' => 'required|string|max:20',
            'alamat' => 'required|string',
            'pas_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $fotoPath = $peserta->pas_foto;
        if ($request->hasFile('pas_foto')) {
            if ($peserta->pas_foto && Storage::disk('public')->exists($peserta->pas_foto)) {
                Storage::disk('public')->delete($peserta->pas_foto);
            }
            $fotoPath = $request->file('pas_foto')->store('foto_peserta', 'public');
        }

        $peserta->update([
            'nik' => $request->nik,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'nomor_telepon' => $request->nomor_telepon,
            'alamat' => $request->alamat,
            'pas_foto' => $fotoPath,
        ]);

        return redirect()->route('peserta.biodata.index')->with('success', 'Biodata berhasil diperbarui! Anda sekarang bisa mendaftar kelas.');
    }
}