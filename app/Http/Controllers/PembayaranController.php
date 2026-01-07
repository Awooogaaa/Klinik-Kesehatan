<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    // [ADMIN] Melihat semua daftar pembayaran
    public function index()
    {
        $pembayarans = Pembayaran::with(['kunjungan.pasien', 'kunjungan.dokter'])
                        ->latest()
                        ->get();
        
        return view('pembayarans.index', compact('pembayarans'));
    }

    // [ADMIN] Konfirmasi pembayaran CASH (Offline)
    public function confirmOffline($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        
        $pembayaran->update([
            'status_pembayaran' => 'lunas',
            'metode_pembayaran' => 'offline'
        ]);

        return back()->with('success', 'Pembayaran Cash berhasil dikonfirmasi.');
    }

    // [PASIEN] Halaman Nota / Checkout
    public function show($id)
    {
        // Pastikan pasien hanya bisa lihat nota miliknya (opsional: tambahkan logic policy)
        $pembayaran = Pembayaran::with(['kunjungan.rekamMedis.obats', 'kunjungan.dokter', 'kunjungan.pasien'])
                        ->findOrFail($id);

        return view('pembayarans.show', compact('pembayaran'));
    }

    // [SYSTEM] Callback dari Midtrans (Webhooks)
    // Jangan lupa exclude route ini dari CSRF di bootstrap/app.php atau middleware
    public function callback(Request $request)
    {
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);

        if($hashed == $request->signature_key){
            $pembayaran = Pembayaran::where('order_id', $request->order_id)->first();
            
            if($request->transaction_status == 'capture' || $request->transaction_status == 'settlement'){
                $pembayaran->update([
                    'status_pembayaran' => 'lunas', 
                    'metode_pembayaran' => 'online'
                ]);
            }
        }
    }
}