<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nota Pembayaran') }}
        </h2>
    </x-slot>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="text-center mb-8 border-b pb-4">
                    <h1 class="text-2xl font-bold text-blue-600">INVOICE PENGOBATAN</h1>
                    <p class="text-gray-500">#{{ $pembayaran->order_id }}</p>
                    
                    @if($pembayaran->status_pembayaran == 'lunas')
                        <span class="bg-green-100 text-green-800 font-bold px-3 py-1 rounded-full mt-2 inline-block">LUNAS</span>
                    @else
                        <span class="bg-yellow-100 text-yellow-800 font-bold px-3 py-1 rounded-full mt-2 inline-block">BELUM BAYAR</span>
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-sm text-gray-500">Pasien</p>
                        <p class="font-bold">{{ $pembayaran->kunjungan->pasien->nama }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Dokter</p>
                        <p class="font-bold">{{ $pembayaran->kunjungan->dokter->nama ?? $pembayaran->kunjungan->dokter->user->name }}</p>
                    </div>
                </div>

                <table class="w-full mb-6">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2">Deskripsi</th>
                            <th class="text-right py-2">Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="py-2 text-gray-600">Jasa Konsultasi Dokter</td>
                            <td class="text-right font-medium">Rp {{ number_format($pembayaran->kunjungan->dokter->biaya_jasa ?? 50000, 0, ',', '.') }}</td>
                        </tr>
                        
                        @foreach($pembayaran->kunjungan->rekamMedis->obats as $obat)
                        <tr>
                            <td class="py-2 text-gray-600">{{ $obat->nama_obat }} ({{ $obat->pivot->jumlah }}x)</td>
                            <td class="text-right font-medium">
                                Rp {{ number_format($obat->harga * $obat->pivot->jumlah, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="border-t-2 border-gray-200">
                        <tr>
                            <td class="py-4 font-bold text-lg">TOTAL TAGIHAN</td>
                            <td class="py-4 text-right font-bold text-lg text-blue-600">
                                Rp {{ number_format($pembayaran->total_harga, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <div class="flex flex-col gap-4 mt-8">
                    @if($pembayaran->status_pembayaran == 'pending')
                        <button id="pay-button" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl shadow-lg transition">
                            Bayar Online Sekarang (QRIS/E-Wallet/Bank)
                        </button>
                        
                        <div class="text-center text-sm text-gray-500">
                            ATAU
                        </div>

                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-center">
                            <p class="font-bold text-gray-700">Bayar di Kasir / Resepsionis</p>
                            <p class="text-sm">Silakan tunjukkan Invoice ID <strong>{{ $pembayaran->order_id }}</strong> kepada petugas kami untuk pembayaran tunai.</p>
                        </div>
                    @else
                        <div class="bg-green-50 border border-green-200 rounded-xl p-6 text-center">
                            <svg class="w-16 h-16 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <h3 class="text-xl font-bold text-green-700">Pembayaran Berhasil</h3>
                            <p class="text-green-600 mt-2">Terima kasih, transaksi Anda telah selesai.</p>
                            <p class="text-sm text-gray-500 mt-1">Metode: {{ strtoupper($pembayaran->metode_pembayaran) }}</p>
                        </div>
                    @endif
                </div>

                <div class="mt-6 text-center">
                    <a href="{{ route('pasiens.landingpage') }}" class="text-gray-500 hover:text-gray-800 text-sm">Kembali ke Dashboard</a>
                </div>
            </div>
        </div>
    </div>

    @if($pembayaran->status_pembayaran == 'pending')
    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            window.snap.pay('{{ $pembayaran->snap_token }}', {
                onSuccess: function(result){
                    alert("Pembayaran Berhasil!");
                    location.reload();
                },
                onPending: function(result){
                    alert("Menunggu pembayaran Anda!"); console.log(result);
                },
                onError: function(result){
                    alert("Pembayaran gagal!"); console.log(result);
                },
                onClose: function(){
                    alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                }
            })
        });
    </script>
    @endif
</x-app-layout>