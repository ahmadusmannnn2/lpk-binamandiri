<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;

class PesertaController extends Controller
{
    public function index()
    {
        $peserta = Peserta::with('user')->latest()->get();
        return view('admin.peserta.index', compact('peserta'));
    }

    public function create()
    {
        return view('admin.peserta.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi Input (termasuk validasi foto max 2MB)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nik' => 'nullable|string|max:16|unique:peserta,nik',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'nomor_telepon' => 'nullable|string|max:20',
            'pas_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Canggih: Validasi tipe dan ukuran gambar
        ]);

        // 2. Proses Upload Foto (Jika ada)
        $fotoPath = null;
        if ($request->hasFile('pas_foto')) {
            // Simpan ke folder storage/app/public/foto_peserta
            $fotoPath = $request->file('pas_foto')->store('foto_peserta', 'public');
        }

        // 3. Buat Akun User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'peserta',
        ]);

        // 4. Buat Data Peserta
        Peserta::create([
            'user_id' => $user->id,
            'nik' => $request->nik,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'nomor_telepon' => $request->nomor_telepon,
            'pas_foto' => $fotoPath, // Simpan path gambar ke database
        ]);

        return redirect()->route('admin.peserta.index')->with('success', 'Data Peserta berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $peserta = Peserta::with('user')->findOrFail($id);
        return view('admin.peserta.edit', compact('peserta'));
    }

    public function update(Request $request, $id)
    {
        $peserta = Peserta::findOrFail($id);
        $user = User::findOrFail($peserta->user_id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'nik' => 'nullable|string|max:16|unique:peserta,nik,'.$peserta->id,
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'nomor_telepon' => 'nullable|string|max:20',
            'pas_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update User
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => ['confirmed', Rules\Password::defaults()]]);
            $user->update(['password' => Hash::make($request->password)]);
        }

        // Canggih: Proses Ganti Foto
        $fotoPath = $peserta->pas_foto; // Gunakan foto lama sebagai default
        if ($request->hasFile('pas_foto')) {
            // Hapus foto lama jika ada
            if ($peserta->pas_foto && Storage::disk('public')->exists($peserta->pas_foto)) {
                Storage::disk('public')->delete($peserta->pas_foto);
            }
            // Upload foto baru
            $fotoPath = $request->file('pas_foto')->store('foto_peserta', 'public');
        }

        // Update Peserta
        $peserta->update([
            'nik' => $request->nik,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'nomor_telepon' => $request->nomor_telepon,
            'pas_foto' => $fotoPath,
        ]);

        return redirect()->route('admin.peserta.index')->with('success', 'Data Peserta berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $peserta = Peserta::findOrFail($id);
        $user_id = $peserta->user_id;

        // Canggih: Hapus file fisik foto dari server agar tidak memenuhi harddisk
        if ($peserta->pas_foto && Storage::disk('public')->exists($peserta->pas_foto)) {
            Storage::disk('public')->delete($peserta->pas_foto);
        }
        
        $peserta->delete();
        User::destroy($user_id);

        return redirect()->route('admin.peserta.index')->with('success', 'Peserta dan akunnya berhasil dihapus!');
    }
}