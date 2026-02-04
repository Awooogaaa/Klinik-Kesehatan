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

                    {{-- Detail Harga (Itemized Breakdown) --}}
                    <div class="space-y-3">
                        <h3 class="font-bold text-slate-700 flex items-center text-sm">
                            <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Detail Harga
                        </h3>
                        
                        {{-- Biaya Pemeriksaan --}}
                        @if($pembayaran->kunjungan->rekamMedis)
                        <div class="flex justify-between items-center py-2 border-b border-slate-100">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="text-sm text-slate-600">Biaya Pemeriksaan</span>
                            </div>
                            <span class="text-sm font-semibold text-slate-700">Rp{{ number_format($pembayaran->kunjungan->rekamMedis->biaya_pemeriksaan ?? 0, 0, ',', '.') }}</span>
                        </div>
                        
                        {{-- Tindakan Medis (if any) --}}
                        @if($pembayaran->kunjungan->rekamMedis->tindakanMedis && $pembayaran->kunjungan->rekamMedis->tindakanMedis->count() > 0)
                            @foreach($pembayaran->kunjungan->rekamMedis->tindakanMedis as $tindakan)
                            <div class="flex justify-between items-center py-2 border-b border-slate-100">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 bg-amber-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                        </svg>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm text-slate-600">{{ $tindakan->nama_tindakan }}</span>
                                        @if($tindakan->keterangan)
                                            <span class="text-xs text-slate-400">{{ $tindakan->keterangan }}</span>
                                        @endif
                                    </div>
                                </div>
                                <span class="text-sm font-semibold text-slate-700">Rp{{ number_format($tindakan->biaya, 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                        @endif
                        
                    
                        @else
                        <div class="text-center py-4 text-sm text-slate-500 italic">
                            Detail rekam medis tidak tersedia
                        </div>
                        @endif
                    </div>

                    {{-- Total Amount --}}
                    <div class="bg-gradient-to-r from-amber-50 to-orange-50 p-5 rounded-xl border border-amber-200/50">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-700 font-bold">Total Pembayaran</span>
                            <p class="text-xl font-bold text-slate-800">Rp{{ number_format($pembayaran->total_harga, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    {{-- Pay Button --}}
                    <button id="pay-button" class="w-full bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white font-semibold py-4 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span>Pilih Pembayaran</span>
                    </button>

                    {{-- Security Note --}}
                    <div class="flex items-center justify-center gap-2 text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <span class="text-xs">Garansi 100% aman via Midtrans</span>
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