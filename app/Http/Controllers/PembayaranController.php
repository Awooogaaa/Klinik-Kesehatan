<?php

namespace App\Http\Controllers;

use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function bayar()
{
    Config::$serverKey = config('services.midtrans.server_key');
    Config::$isProduction = config('services.midtrans.is_production');
    Config::$isSanitized = config('services.midtrans.is_sanitized');
    Config::$is3ds = config('services.midtrans.is_3ds');

    // TAMBAHKAN KODE INI UNTUK MEMPERBAIKI ERROR "Undefined array key 10023"
    Config::$curlOptions = [
        CURLOPT_HTTPHEADER => [], // Key 10023 didefinisikan sebagai array kosong
    ];

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

    $snapToken = Snap::getSnapToken($params);

    return view('bayar', compact('snapToken'));
}

    public function callback(Request $request)
{
    $serverKey = config('services.midtrans.server_key');
    $hashed = hash(
        "sha512",
        $request->order_id .
        $request->status_code .
        $request->gross_amount .
        $serverKey
    );

    if ($hashed !== $request->signature_key) {
        return response()->json(['message' => 'Invalid signature'], 403);
    }

    // Contoh simpan status
    // Order::where('order_id', $request->order_id)
    //     ->update(['status' => $request->transaction_status]);

    return response()->json(['message' => 'Callback received']);
}

}
