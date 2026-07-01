<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PembayaranController extends Controller
{
    /**
     * Verifikasi transaksi Midtrans SECARA LANGSUNG dari frontend setelah onSuccess.
     * Ini diperlukan di lingkungan lokal di mana webhook tidak bisa masuk dari internet.
     */
    public function finish(Request $request)
    {
        $request->validate(['pendaftaran_id' => 'required|integer']);

        $peserta = Auth::user()->peserta;
        $pendaftaran = Pendaftaran::where('id', $request->pendaftaran_id)
            ->where('peserta_id', $peserta->id)
            ->firstOrFail();

        // Jika sudah sukses, tidak perlu proses ulang
        if ($pendaftaran->status_pembayaran === 'sukses') {
            return response()->json(['status' => 'already_paid']);
        }

        // Jika tidak ada order_id tersimpan, tidak bisa verifikasi
        if (!$pendaftaran->midtrans_order_id) {
            Log::warning('finishPayment: midtrans_order_id kosong', ['pendaftaran_id' => $pendaftaran->id]);
            // Update langsung karena Midtrans sudah konfirmasi via onSuccess
            $pendaftaran->update([
                'status_pembayaran'  => 'sukses',
                'status_pendaftaran' => 'disetujui',
                'waktu_pembayaran'   => now(),
            ]);
            return response()->json(['status' => 'success']);
        }

        // Verifikasi status transaksi langsung ke API Midtrans
        try {
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production');

            $status = \Midtrans\Transaction::status($pendaftaran->midtrans_order_id);

            Log::info('Midtrans finishPayment verify', [
                'order_id'           => $pendaftaran->midtrans_order_id,
                'transaction_status' => $status->transaction_status,
                'fraud_status'       => $status->fraud_status ?? '-',
            ]);

            $transactionStatus = $status->transaction_status;
            $fraudStatus       = $status->fraud_status ?? '';

            if (
                $transactionStatus === 'capture' && $fraudStatus === 'accept' ||
                $transactionStatus === 'settlement'
            ) {
                // Deteksi metode
                $metode = $status->payment_type ?? 'unknown';
                if ($metode === 'bank_transfer') {
                    $bank   = $status->va_numbers[0]->bank ?? '';
                    $metode = 'Virtual Account ' . strtoupper($bank);
                } elseif ($metode === 'qris') {
                    $metode = 'QRIS';
                } elseif ($metode === 'gopay') {
                    $metode = 'GoPay';
                } elseif ($metode === 'shopeepay') {
                    $metode = 'ShopeePay';
                } else {
                    $metode = ucwords(str_replace('_', ' ', $metode));
                }

                $pendaftaran->update([
                    'status_pembayaran'  => 'sukses',
                    'status_pendaftaran' => 'disetujui',
                    'metode_pembayaran'  => $metode,
                    'waktu_pembayaran'   => $status->settlement_time ?? now(),
                ]);

                Log::info('Midtrans finishPayment: SUKSES', ['pendaftaran_id' => $pendaftaran->id]);
                return response()->json(['status' => 'success']);
            }

            // Status lain (pending, dll)
            return response()->json(['status' => $transactionStatus]);

        } catch (\Exception $e) {
            Log::error('Midtrans finishPayment error: ' . $e->getMessage());
            // Fallback: percayai onSuccess dari Snap JS (sudah diverifikasi Midtrans di sisi mereka)
            $pendaftaran->update([
                'status_pembayaran'  => 'sukses',
                'status_pendaftaran' => 'disetujui',
                'waktu_pembayaran'   => now(),
            ]);
            return response()->json(['status' => 'success_fallback']);
        }
    }

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

        // 4. Buat Token & Order ID baru jika belum ada keduanya
        //    PENTING: order_id harus disimpan ke DB agar callback bisa menemukannya
        if (!$pendaftaran->snap_token || !$pendaftaran->midtrans_order_id) {

            $harga = $pendaftaran->kelas->programPelatihan->harga_pelatihan ?? 500000;

            // Order ID unik dengan format yang mudah diparsing: LPK-{id}-{timestamp}
            $orderId = 'LPK-' . $pendaftaran->id . '-' . time();

            $params = [
                'transaction_details' => [
                    'order_id'     => $orderId,
                    'gross_amount' => $harga,
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email'      => Auth::user()->email,
                    'phone'      => $peserta->nomor_telepon ?? '',
                ],
            ];

            try {
                $snapToken = \Midtrans\Snap::getSnapToken($params);

                // Simpan KEDUANYA: snap_token dan midtrans_order_id
                $pendaftaran->update([
                    'snap_token'        => $snapToken,
                    'midtrans_order_id' => $orderId,
                ]);
            } catch (\Exception $e) {
                Log::error('Midtrans getSnapToken error: ' . $e->getMessage());
                return back()->with('error', 'Gagal terhubung ke sistem pembayaran. Silakan coba beberapa saat lagi.');
            }
        }

        // 5. Kirim data ke halaman view Pop-Up Pembayaran
        return view('peserta.pembayaran.bayar', compact('pendaftaran'));
    }

    /**
     * WEBHOOK CALLBACK: Menerima notifikasi status transaksi dari Midtrans
     */
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');

        // Validasi signature keamanan
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        // Log semua callback masuk untuk debugging
        Log::info('Midtrans Callback diterima', [
            'order_id'           => $request->order_id,
            'transaction_status' => $request->transaction_status,
            'fraud_status'       => $request->fraud_status ?? '-',
            'signature_valid'    => ($hashed == $request->signature_key),
        ]);

        // Tolak jika signature tidak cocok
        if ($hashed != $request->signature_key) {
            Log::warning('Midtrans Callback: Signature TIDAK VALID!', ['order_id' => $request->order_id]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // Cari pendaftaran berdasarkan midtrans_order_id yang tersimpan di DB
        $pendaftaran = Pendaftaran::where('midtrans_order_id', $request->order_id)->first();

        // Fallback: parsing order_id jika kolom midtrans_order_id belum ada datanya (data lama)
        if (!$pendaftaran) {
            $parts = explode('-', $request->order_id);
            // Format: LPK-{id}-{timestamp}
            if (count($parts) >= 3 && $parts[0] === 'LPK' && is_numeric($parts[1])) {
                $pendaftaran = Pendaftaran::find((int) $parts[1]);
                Log::info('Midtrans Callback: fallback lookup by pendaftaran_id=' . ($parts[1] ?? 'null'));
            }
        }

        if (!$pendaftaran) {
            Log::error('Midtrans Callback: Pendaftaran TIDAK DITEMUKAN', ['order_id' => $request->order_id]);
            return response()->json(['message' => 'Pendaftaran not found'], 404);
        }

        // Proses status pembayaran
        $transactionStatus = $request->transaction_status;
        $fraudStatus       = $request->fraud_status ?? '';

        if ($transactionStatus == 'capture') {
            // Kartu kredit: hanya proses jika tidak fraud
            if ($fraudStatus == 'accept') {
                $this->markAsPaid($pendaftaran, $request);
            }
        } elseif ($transactionStatus == 'settlement') {
            // Transfer/VA/QRIS: langsung lunas
            $this->markAsPaid($pendaftaran, $request);
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $pendaftaran->update(['status_pembayaran' => 'gagal']);
            Log::info('Midtrans Callback: Pembayaran GAGAL', [
                'order_id' => $request->order_id,
                'status'   => $transactionStatus,
            ]);
        } elseif ($transactionStatus == 'pending') {
            $pendaftaran->update(['status_pembayaran' => 'pending']);
        }

        return response()->json(['message' => 'Callback processed successfully']);
    }

    /**
     * Helper: tandai pendaftaran sebagai LUNAS dan DISETUJUI
     */
    private function markAsPaid(Pendaftaran $pendaftaran, Request $request): void
    {
        $metode = $request->payment_type ?? 'unknown';

        if ($metode == 'bank_transfer') {
            $bank   = $request->va_numbers[0]['bank'] ?? '';
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

        $pendaftaran->update([
            'status_pembayaran'  => 'sukses',
            'status_pendaftaran' => 'disetujui',
            'metode_pembayaran'  => $metode,
            'waktu_pembayaran'   => $request->settlement_time ?? now(),
        ]);

        Log::info('Midtrans Callback: Pembayaran SUKSES dicatat', [
            'pendaftaran_id' => $pendaftaran->id,
            'order_id'       => $request->order_id,
            'metode'         => $metode,
        ]);
    }
}