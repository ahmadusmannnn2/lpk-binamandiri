<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Peserta; // <--- INI KUNCI PENYELESAIANNYA

class BiodataController extends Controller
{
    public function index()
    {
        $peserta = Auth::user()->peserta;
        return view('peserta.biodata.index', compact('peserta'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|max:16',
            'nomor_telepon' => 'required|string|max:15',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'pendidikan_terakhir' => 'required|string|max:50',
            'alamat_lengkap' => 'required|string',
            'pas_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'file_ijazah' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
            'file_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();
        
        // Update atau Create data peserta
        $peserta = Peserta::firstOrCreate(
            ['user_id' => $user->id],
            [
                'nik' => $request->nik,
                'nomor_telepon' => $request->nomor_telepon,
                'jenis_kelamin' => $request->jenis_kelamin,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'alamat_lengkap' => $request->alamat_lengkap,
            ]
        );

        // Jika bukan create baru, update datanya
        if (!$peserta->wasRecentlyCreated) {
            $peserta->update([
                'nik' => $request->nik,
                'nomor_telepon' => $request->nomor_telepon,
                'jenis_kelamin' => $request->jenis_kelamin,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'alamat_lengkap' => $request->alamat_lengkap,
            ]);
        }

        // Handle Upload Pas Foto
        if ($request->hasFile('pas_foto')) {
            if ($peserta->pas_foto && Storage::disk('public')->exists($peserta->pas_foto)) {
                Storage::disk('public')->delete($peserta->pas_foto);
            }
            $peserta->update(['pas_foto' => $request->file('pas_foto')->store('peserta/foto', 'public')]);
        }

        // Handle Upload KTP
        if ($request->hasFile('file_ktp')) {
            if ($peserta->file_ktp && Storage::disk('public')->exists($peserta->file_ktp)) {
                Storage::disk('public')->delete($peserta->file_ktp);
            }
            $peserta->update(['file_ktp' => $request->file('file_ktp')->store('peserta/ktp', 'public')]);
        }

        // Handle Upload Ijazah
        if ($request->hasFile('file_ijazah')) {
            if ($peserta->file_ijazah && Storage::disk('public')->exists($peserta->file_ijazah)) {
                Storage::disk('public')->delete($peserta->file_ijazah);
            }
            $peserta->update(['file_ijazah' => $request->file('file_ijazah')->store('peserta/ijazah', 'public')]);
        }

        return back()->with('success', 'Biodata dan Berkas berhasil diperbarui!');
    }
}