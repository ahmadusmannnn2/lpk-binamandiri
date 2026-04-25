<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Instruktur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class InstrukturController extends Controller
{
    public function index()
    {
        // Mengambil data instruktur beserta data akun user-nya
        $instruktur = Instruktur::with('user')->latest()->get();
        return view('admin.instruktur.index', compact('instruktur'));
    }

    public function create()
    {
        return view('admin.instruktur.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nomor_telepon' => 'nullable|string|max:20',
            'spesialisasi_las' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
        ]);

        // 2. Buat Akun User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'instruktur',
        ]);

        // 3. Buat Profil Instruktur dan hubungkan ke User
        Instruktur::create([
            'user_id' => $user->id,
            'nomor_telepon' => $request->nomor_telepon,
            'spesialisasi_las' => $request->spesialisasi_las,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('admin.instruktur.index')->with('success', 'Instruktur berhasil ditambahkan beserta akun loginnya!');
    }

    public function edit($id)
    {
        $instruktur = Instruktur::with('user')->findOrFail($id);
        return view('admin.instruktur.edit', compact('instruktur'));
    }

    public function update(Request $request, $id)
    {
        $instruktur = Instruktur::findOrFail($id);
        $user = User::findOrFail($instruktur->user_id);

        $request->validate([
            'name' => 'required|string|max:255',
            // Pastikan email unik, kecuali untuk email user ini sendiri
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'nomor_telepon' => 'nullable|string|max:20',
            'spesialisasi_las' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
        ]);

        // Update User
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update Password jika diisi, biarkan jika kosong
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            $user->update(['password' => Hash::make($request->password)]);
        }

        // Update Instruktur
        $instruktur->update([
            'nomor_telepon' => $request->nomor_telepon,
            'spesialisasi_las' => $request->spesialisasi_las,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('admin.instruktur.index')->with('success', 'Data Instruktur berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $instruktur = Instruktur::findOrFail($id);
        $user_id = $instruktur->user_id;
        
        // Hapus instruktur
        $instruktur->delete();
        // Hapus juga akun user-nya agar tidak ada akun menggantung
        User::destroy($user_id);

        return redirect()->route('admin.instruktur.index')->with('success', 'Instruktur dan akun loginnya berhasil dihapus!');
    }
}