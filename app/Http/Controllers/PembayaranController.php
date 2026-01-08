<?php

namespace App\Http\Controllers;

use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Log;

class PembayaranController extends Controller
{
   public function bayar()
{
    // DEBUG: Cek apakah key terbaca?
    $serverKey = config('services.midtrans.server_key');
    
    // Jika layar menampilkan "NULL" atau kosong, berarti masalahnya di Config/Env
    // dd($serverKey); 

    // --- SOLUSI SEMENTARA: HARDCODE ---
    // Masukkan Key langsung di sini untuk memastikan kode jalan dulu
    // Ganti string ini dengan Server Key dari dashboard Midtrans kamu
    Config::$serverKey = config('services.midtrans.server_key');
    
    Config::$isProduction = false;
    Config::$isSanitized = true;
    Config::$is3ds = true;

    $params = [
        'transaction_details' => [
            'order_id' => 'ORDER-' . time(),
            'gross_amount' => 100000,
        ],
        'customer_details' => [
            'first_name' => 'Putra',
            'email' => 'putra@test.com',
        ],
    ];

    try {
        $snapToken = Snap::getSnapToken($params);
        return view('pembayaran', compact('snapToken'));
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    public function show($id)
    {
        // 1. Cari data pembayaran berdasarkan ID
        $pembayaran = Pembayaran::with(['kunjungan.pasien', 'kunjungan.dokter'])->findOrFail($id);

        // 2. Jika status sudah lunas (settlement/capture), arahkan ke nota saja (opsional)
        // if ($pembayaran->status_pembayaran == 'success') {
        //     return redirect()->route('pasiens.nota', $pembayaran->kunjungan_id);
        // }

        // 3. Ambil Snap Token dari database
        $snapToken = $pembayaran->snap_token;

        // 4. Jika token hilang/expired tapi status masih pending, bisa generate ulang di sini (Opsional, advanced logic)
        // Untuk sekarang kita asumsikan token dari RekamMedisController masih valid.

        // 5. Tampilkan view pembayaran dengan data asli
        return view('pembayaran', compact('pembayaran', 'snapToken'));
    }

    // ... Method callback() biarkan tetap ada ...
    public function callback(Request $request)
    {
        // ... (kode validasi signature biarkan saja) ...
        $serverKey = config('services.midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed !== $request->signature_key) {
            Log::error('Invalid Signature Key');
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $pembayaran = Pembayaran::where('order_id', $request->order_id)->first();

        if ($pembayaran) {
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                
                // --- PERBAIKAN DISINI ---
                // Ganti 'success' menjadi 'lunas' (Sesuai ENUM Database)
                $pembayaran->update(['status_pembayaran' => 'lunas']); 
                
                // Opsional: Update status kunjungan
                 $pembayaran->kunjungan->update(['status' => 'selesai']);

            } elseif ($request->transaction_status == 'expire' || $request->transaction_status == 'cancel' || $request->transaction_status == 'deny') {
                
                // --- PERBAIKAN DISINI ---
                // Ganti 'failed' menjadi 'batal' (Sesuai ENUM Database)
                $pembayaran->update(['status_pembayaran' => 'batal']);
                
            }
        }

        return response()->json(['message' => 'Callback received']);
    }

}
