<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Peserta;

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
            'nik'                        => 'required|string|max:16',
            'tempat_lahir'               => 'required|string|max:255',
            'tanggal_lahir'              => 'required|date',
            'nomor_telepon'              => 'required|string|max:15',
            'jenis_kelamin'              => 'required|in:Laki-laki,Perempuan',
            'pendidikan_terakhir'        => 'required|string|max:50',
            'alamat'                     => 'required|string',
            // Field baru (opsional)
            'alamat_domisili'            => 'nullable|string',
            'status_perkawinan'          => 'nullable|in:Belum Menikah,Menikah,Cerai Hidup,Cerai Mati',
            'pengalaman_bekerja'         => 'nullable|string',
            'perusahaan_terakhir'        => 'nullable|string|max:255',
            'keperluan_mendaftar'        => 'nullable|string',
            'rekomendasi_dari'           => 'nullable|string|max:255',
            // Upload berkas
            'pas_foto'                   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'file_ktp'                   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'file_ijazah'               => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
            'file_sertifikat_pendukung' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
        ]);

        $user = Auth::user();
        
        $dataToSave = [
            'nik'                  => $request->nik,
            'tempat_lahir'         => $request->tempat_lahir,
            'tanggal_lahir'        => $request->tanggal_lahir,
            'nomor_telepon'        => $request->nomor_telepon,
            'jenis_kelamin'        => $request->jenis_kelamin,
            'pendidikan_terakhir'  => $request->pendidikan_terakhir,
            'alamat'               => $request->alamat,
            // Field tambahan baru
            'alamat_domisili'      => $request->alamat_domisili,
            'status_perkawinan'    => $request->status_perkawinan,
            'pengalaman_bekerja'   => $request->pengalaman_bekerja,
            'perusahaan_terakhir'  => $request->perusahaan_terakhir,
            'keperluan_mendaftar'  => $request->keperluan_mendaftar,
            'rekomendasi_dari'     => $request->rekomendasi_dari,
            // Status verifikasi kembali ke menunggu saat ada perubahan
            'status_biodata'       => 'menunggu',
            'catatan_biodata'      => null,
        ];

        // Update atau Create data peserta
        $peserta = Peserta::firstOrCreate(
            ['user_id' => $user->id],
            $dataToSave
        );

        // Jika bukan create baru, update datanya
        if (!$peserta->wasRecentlyCreated) {
            $peserta->update($dataToSave);
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

        // Handle Upload Sertifikat Pendukung
        if ($request->hasFile('file_sertifikat_pendukung')) {
            if ($peserta->file_sertifikat_pendukung && Storage::disk('public')->exists($peserta->file_sertifikat_pendukung)) {
                Storage::disk('public')->delete($peserta->file_sertifikat_pendukung);
            }
            $peserta->update(['file_sertifikat_pendukung' => $request->file('file_sertifikat_pendukung')->store('peserta/sertifikat', 'public')]);
        }

        return back()->with('success', 'Biodata berhasil disimpan. Menunggu verifikasi dari Admin!');
    }
}