<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md mx-auto">
            {{-- Payment Card --}}
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                
                {{-- Header Section --}}
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-5">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white">Detail Pembayaran</h2>
                            <p class="text-blue-100 text-sm">Konfirmasi pembayaran Anda</p>
                        </div>
                    </div>
                </div>

                {{-- Content Section --}}
                <div class="p-6 space-y-5">
                    
                    {{-- Patient Info --}}
                    <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-xl">
                        <div class="w-11 h-11 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Nama Pasien</p>
                            <p class="text-slate-800 font-semibold truncate">{{ $pembayaran->kunjungan->pasien->nama }}</p>
                        </div>
                    </div>

                    {{-- Doctor Info --}}
                    <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-xl">
                        <div class="w-11 h-11 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Dokter</p>
                            <p class="text-slate-800 font-semibold truncate">{{ $pembayaran->kunjungan->dokter->user->name ?? $pembayaran->kunjungan->dokter->nama }}</p>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="border-t border-dashed border-slate-200"></div>

                    {{-- Total Amount --}}
                    <div class="bg-gradient-to-r from-amber-50 to-orange-50 p-5 rounded-xl border border-amber-200/50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="text-slate-600 font-medium">Total Tagihan</span>
                            </div>
                            <p class="text-xl font-bold text-slate-800">Rp {{ number_format($pembayaran->total_harga, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    {{-- Pay Button --}}
                    <button id="pay-button" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-4 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span>Bayar Sekarang</span>
                    </button>

                    {{-- Security Note --}}
                    <div class="flex items-center justify-center gap-2 text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <span class="text-xs">Pembayaran aman via Midtrans</span>
                    </div>
                </div>
            </div>

            {{-- Back Link --}}
            <div class="text-center mt-6">
                <a href="{{ url('/landingpage-pasien') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-700 transition-colors text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function(){
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    alert("Pembayaran Berhasil!");
                    window.location.href = "/landingpage-pasien";
                },
                onPending: function(result){
                    alert("Menunggu pembayaran!");
                },
                onError: function(result){
                    alert("Pembayaran gagal!");
                }
            });
        };
    </script>
    @endpush
</x-app-layout>