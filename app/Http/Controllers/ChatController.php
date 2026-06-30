<?php

namespace App\Http\Controllers;

use App\Models\Pesan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // Menampilkan halaman chat utama
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Admin: Ambil daftar peserta (yang pernah daftar atau punya akun peserta)
            // Urutkan berdasarkan pesan terakhir
            $kontak = User::where('role', 'peserta')
                ->with(['peserta'])
                ->get()
                ->sortByDesc(function ($q) {
                    return Pesan::where('pengirim_id', $q->id)
                        ->orWhere('penerima_id', $q->id)
                        ->max('created_at');
                });
            
            // Pilih kontak aktif jika ada di URL, atau otomatis pilih yang pertama
            $aktifId = $request->query('user_id', $kontak->first()->id ?? null);
            $aktifUser = $aktifId ? User::find($aktifId) : null;

            return view('chat.admin', compact('kontak', 'aktifUser'));
        } else {
            // Peserta: Langsung chat dengan Admin utama (ID 1 atau role admin pertama)
            $admin = User::where('role', 'admin')->first();
            return view('chat.peserta', compact('admin'));
        }
    }

    // Mengambil pesan via AJAX
    public function getMessages($lawan_id)
    {
        $saya_id = Auth::id();

        // Tandai pesan sudah dibaca
        Pesan::where('pengirim_id', $lawan_id)
            ->where('penerima_id', $saya_id)
            ->whereNull('dibaca_pada')
            ->update(['dibaca_pada' => now()]);

        $pesan = Pesan::with(['kelas.programPelatihan'])
            ->where(function ($q) use ($saya_id, $lawan_id) {
                $q->where('pengirim_id', $saya_id)->where('penerima_id', $lawan_id);
            })
            ->orWhere(function ($q) use ($saya_id, $lawan_id) {
                $q->where('pengirim_id', $lawan_id)->where('penerima_id', $saya_id);
            })
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($item) use ($saya_id) {
                return [
                    'id' => $item->id,
                    'is_saya' => $item->pengirim_id == $saya_id,
                    'pesan' => $item->pesan,
                    'waktu' => $item->created_at->format('H:i'),
                    'dibaca' => $item->dibaca_pada !== null,
                    'kelas' => $item->kelas ? [
                        'nama_program' => $item->kelas->programPelatihan->nama_program,
                        'nama_kelas' => $item->kelas->nama_kelas,
                        'harga' => number_format($item->kelas->programPelatihan->harga_pelatihan, 0, ',', '.'),
                        'gambar' => $item->kelas->programPelatihan->gambar ? asset('storage/' . $item->kelas->programPelatihan->gambar) : null,
                    ] : null,
                ];
            });

        return response()->json($pesan);
    }

    // Mengirim pesan via AJAX
    public function sendMessage(Request $request)
    {
        $request->validate([
            'penerima_id' => 'required|exists:users,id',
            'pesan' => 'required|string',
        ]);

        $pesan = Pesan::create([
            'pengirim_id' => Auth::id(),
            'penerima_id' => $request->penerima_id,
            'pesan' => $request->pesan,
        ]);

        return response()->json(['status' => 'success', 'data' => $pesan]);
    }
}
