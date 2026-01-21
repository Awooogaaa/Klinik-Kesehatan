<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('pembayarans.index') }}" class="p-2 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div class="p-2 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    {{ __('Nota Pembayaran') }}
                </h2>
                <p class="text-sm text-gray-500">Invoice #{{ $pembayaran->order_id }}</p>
            </div>
        </div>
    </x-slot>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                
                <!-- Invoice Header -->
                <div class="px-8 py-6 bg-gradient-to-r from-green-500 to-emerald-600 text-center">
                    <div class="flex items-center justify-center mb-4">
                        <div class="p-4 bg-white/20 rounded-2xl">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                    <h1 class="text-2xl font-bold text-white">INVOICE PENGOBATAN</h1>
                    <p class="text-green-100 font-mono mt-1">#{{ $pembayaran->order_id }}</p>
                    
                    <div class="mt-4">
                        @if($pembayaran->status_pembayaran == 'lunas')
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-white text-emerald-600 shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                LUNAS
                            </span>
                        @else
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-amber-400 text-white shadow-lg animate-pulse">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                BELUM BAYAR
                            </span>
                        @endif
                    </div>
                </div>

                <div class="p-8">
                    <!-- Patient & Doctor Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-gradient-to-br from-violet-50 to-purple-50 border border-violet-200 rounded-2xl p-5">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0 h-12 w-12 bg-gradient-to-br from-violet-400 to-purple-500 rounded-2xl flex items-center justify-center shadow-lg">
                                    <span class="text-white font-bold text-lg">{{ strtoupper(substr($pembayaran->kunjungan->pasien->nama, 0, 2)) }}</span>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-violet-600 uppercase tracking-wider">Pasien</p>
                                    <p class="font-bold text-gray-900 text-lg">{{ $pembayaran->kunjungan->pasien->nama }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200 rounded-2xl p-5">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0 h-12 w-12 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-2xl flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-blue-600 uppercase tracking-wider">Dokter</p>
                                    <p class="font-bold text-gray-900 text-lg">Dr. {{ $pembayaran->kunjungan->dokter->nama ?? $pembayaran->kunjungan->dokter->user->name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Invoice Items -->
                    <div class="rounded-2xl border border-gray-200 overflow-hidden mb-8">
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4">
                            <h3 class="font-semibold text-gray-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Rincian Biaya
                            </h3>
                        </div>
                        
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-4 px-6 text-xs font-bold text-gray-600 uppercase tracking-wider">Deskripsi</th>
                                    <th class="text-right py-4 px-6 text-xs font-bold text-gray-600 uppercase tracking-wider">Biaya</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="py-4 px-6">
                                        <div class="flex items-center">
                                            <div class="p-2 bg-blue-100 rounded-lg mr-3">
                                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                            <span class="text-gray-700 font-medium">Biaya Pemeriksaan Dokter</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-right font-semibold text-gray-900">Rp {{ number_format($pembayaran->kunjungan->rekamMedis->biaya_pemeriksaan ?? 0, 0, ',', '.') }}</td>
                                </tr>
                                
                                @if($pembayaran->kunjungan->rekamMedis && $pembayaran->kunjungan->rekamMedis->tindakanMedis)
                                @foreach($pembayaran->kunjungan->rekamMedis->tindakanMedis as $tindakan)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="py-4 px-6">
                                        <div class="flex items-center">
                                            <div class="p-2 bg-amber-100 rounded-lg mr-3">
                                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <span class="text-gray-700 font-medium">{{ $tindakan->nama_tindakan }}</span>
                                                @if($tindakan->keterangan)
                                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">{{ $tindakan->keterangan }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-right font-semibold text-gray-900">Rp {{ number_format($tindakan->biaya, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr class="bg-gradient-to-r from-green-50 to-emerald-50">
                                    <td class="py-5 px-6 font-bold text-lg text-gray-900">TOTAL TAGIHAN</td>
                                    <td class="py-5 px-6 text-right font-bold text-2xl text-emerald-600">Rp {{ number_format($pembayaran->total_harga, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Payment Actions -->
                    <div class="space-y-4">
                        @if($pembayaran->status_pembayaran == 'pending')
                            <button id="pay-button" class="w-full inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl text-white font-bold text-lg shadow-lg shadow-blue-500/30 hover:shadow-xl hover:from-blue-600 hover:to-indigo-700 transform hover:-translate-y-0.5 transition-all duration-200">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                Bayar Online Sekarang (QRIS/E-Wallet/Bank)
                            </button>
                            
                            <div class="flex items-center">
                                <div class="flex-1 border-t border-gray-200"></div>
                                <span class="px-4 text-sm text-gray-500">ATAU</span>
                                <div class="flex-1 border-t border-gray-200"></div>
                            </div>

                            <div class="bg-gradient-to-r from-gray-50 to-slate-50 border border-gray-200 rounded-2xl p-6 text-center">
                                <div class="flex items-center justify-center mb-3">
                                    <div class="p-3 bg-gray-200 rounded-xl">
                                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                </div>
                                <p class="font-bold text-gray-700 text-lg">Bayar di Kasir / Resepsionis</p>
                                <p class="text-sm text-gray-500 mt-2">Silakan tunjukkan Invoice ID <strong class="font-mono bg-gray-200 px-2 py-0.5 rounded">{{ $pembayaran->order_id }}</strong> kepada petugas kami untuk pembayaran tunai.</p>
                            </div>
                        @else
                            <div class="bg-gradient-to-r from-emerald-50 to-green-50 border border-emerald-200 rounded-2xl p-8 text-center">
                                <div class="flex items-center justify-center mb-4">
                                    <div class="p-4 bg-gradient-to-br from-emerald-400 to-green-500 rounded-2xl shadow-lg">
                                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold text-emerald-700">Pembayaran Berhasil</h3>
                                <p class="text-emerald-600 mt-2">Terima kasih, transaksi Anda telah selesai.</p>
                                <div class="mt-4 inline-flex items-center px-4 py-2 bg-white rounded-xl border border-emerald-200">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-600">Metode: {{ strtoupper($pembayaran->metode_pembayaran) }}</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Back Link -->
                    <div class="mt-8 text-center">
                        <a href="{{ route('pasiens.landingpage') }}" class="inline-flex items-center text-gray-500 hover:text-gray-700 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Kembali ke Dashboard
                        </a>
                    </div>
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