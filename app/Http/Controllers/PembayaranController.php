<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function bayar($id)
    {
        $peserta = Auth::user()->peserta;

        // Cegah error jika user belum mengisi biodata
        if (!$peserta) {
            return redirect()->route('peserta.biodata.index')->with('error', 'Silakan lengkapi biodata terlebih dahulu.');
        }

        // 1. Cari data pendaftaran milik user yang sedang login
        $pendaftaran = Pendaftaran::with('kelas.programPelatihan')
            ->where('id', $id)
            ->where('peserta_id', $peserta->id)
            ->firstOrFail();

        // 2. Jika sudah lunas, kembalikan ke halaman sebelumnya
        if ($pendaftaran->status_pembayaran == 'sukses') {
            return back()->with('info', 'Pendaftaran ini sudah lunas!');
        }

        // 3. Set Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

        // 4. Buat Token Baru JIKA belum punya token sama sekali
        if (!$pendaftaran->snap_token) {
            
            $harga = $pendaftaran->kelas->programPelatihan->harga_pelatihan ?? 500000; 

            // Siapkan Parameter untuk Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => 'LPK-' . $pendaftaran->id . '-' . time(), // Order ID harus unik
                    'gross_amount' => $harga, 
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'phone' => Auth::user()->peserta->nomor_telepon ?? '', // SUDAH DIPERBAIKI
                ]
            ];

            // Minta Snap Token ke Midtrans
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Simpan token ke database
            $pendaftaran->update([
                'snap_token' => $snapToken
            ]);
        }

        // 5. Kirim data ke halaman view Pop-Up Pembayaran
        return view('peserta.pembayaran.bayar', compact('pendaftaran'));
    }

    // FUNGSI PENERIMA NOTIFIKASI DARI MIDTRANS (SI PENJAGA GUDANG)
    public function callback(Request $request)
    {
        // 1. Ambil Server Key dari config
        $serverKey = config('midtrans.server_key');

        // 2. Buat Signature Key untuk validasi keamanan
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        // 3. Jika validasi sukses, proses datanya!
        if ($hashed == $request->signature_key) {
            // Jika pembayaran LUNAS
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                
                // Pisahkan Order ID (Format: LPK-{id}-{time})
                $order_id_parts = explode('-', $request->order_id);
                $pendaftaran_id = $order_id_parts[1]; 

                // Cari datanya di database
                $pendaftaran = Pendaftaran::find($pendaftaran_id);
                
                if ($pendaftaran) {
                    // --- LOGIKA MENDETEKSI METODE PEMBAYARAN (QRIS/BNI/DLL) ---
                    $metode = $request->payment_type;
                    if ($metode == 'bank_transfer') {
                        $bank = $request->va_numbers[0]['bank'] ?? '';
                        $metode = 'Virtual Account ' . strtoupper($bank);
                    } elseif ($metode == 'echannel') {
                        $metode = 'Mandiri Bill';
                    } elseif ($metode == 'qris') {
                        $metode = 'QRIS';
                    } elseif ($metode == 'gopay') {
                        $metode = 'GoPay';
                    } elseif ($metode == 'shopeepay') {
                        $metode = 'ShopeePay';
                    } else {
                        $metode = ucwords(str_replace('_', ' ', $metode)); 
                    }

                    // UPDATE SEMUA DATA LUNAS KE DATABASE
                    $pendaftaran->update([
                        'status_pembayaran' => 'sukses',
                        'status_pendaftaran' => 'disetujui',
                        'metode_pembayaran' => $metode,
                        'waktu_pembayaran' => $request->settlement_time ?? now()
                    ]);
                }
            }
        }

        // 4. Beri jawaban "OK" ke Midtrans
        return response()->json(['message' => 'Callback received']);
    }
}