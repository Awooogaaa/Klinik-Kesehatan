<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('rekam_medis.index') }}" class="p-2 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div class="p-2 bg-gradient-to-br from-rose-500 to-pink-600 rounded-xl shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    {{ __('Detail Rekam Medis') }}
                </h2>
                <p class="text-sm text-gray-500">Lihat catatan medis lengkap</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                <!-- Header with Patient Info -->
                <div class="px-6 py-6 border-b border-gray-100 bg-gradient-to-r from-rose-500 to-pink-600">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-5">
                            <div class="h-16 w-16 rounded-2xl bg-white/20 flex items-center justify-center shadow-xl border-4 border-white/30">
                                <span class="text-white font-bold text-2xl">{{ strtoupper(substr($rekamMedis->pasien->nama ?? 'P', 0, 2)) }}</span>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">{{ $rekamMedis->pasien->nama ?? 'N/A' }}</h3>
                                <div class="flex items-center space-x-2 mt-1">
                                    <span class="inline-flex items-center bg-white/20 text-white text-sm px-3 py-1 rounded-full font-mono font-medium">
                                        {{ $rekamMedis->pasien->no_rekam_medis ?? '-' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-rose-100 text-xs uppercase font-semibold">Tanggal Pemeriksaan</p>
                            <p class="text-white font-bold text-lg">{{ $rekamMedis->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-8 space-y-8">
                    <!-- Info Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-start space-x-4 p-4 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border border-blue-200">
                            <div class="flex-shrink-0 p-2 bg-blue-500 rounded-lg">
                                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-blue-600 uppercase tracking-wider">Dokter Pemeriksa</p>
                                <p class="text-lg font-semibold text-gray-900 mt-1">Dr. {{ $rekamMedis->dokter->user->name ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4 p-4 bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl border border-amber-200">
                            <div class="flex-shrink-0 p-2 bg-amber-500 rounded-lg">
                                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-amber-600 uppercase tracking-wider">Waktu Kunjungan</p>
                                <p class="text-lg font-semibold text-gray-900 mt-1">{{ $rekamMedis->kunjungan->waktu_kunjungan->format('d M Y, H:i') ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Keluhan Section -->
                    <div>
                        <div class="flex items-center space-x-2 mb-3">
                            <div class="p-1.5 bg-violet-100 rounded-lg">
                                <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                </svg>
                            </div>
                            <h3 class="font-bold text-gray-800">Keluhan Pasien</h3>
                        </div>
                        <div class="p-4 bg-gradient-to-r from-violet-50 to-purple-50 rounded-xl border border-violet-200">
                            <p class="text-gray-800 leading-relaxed">{{ $rekamMedis->keluhan }}</p>
                        </div>
                    </div>

                    <!-- Diagnosa Section -->
                    <div>
                        <div class="flex items-center space-x-2 mb-3">
                            <div class="p-1.5 bg-rose-100 rounded-lg">
                                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <h3 class="font-bold text-gray-800">Diagnosa Dokter</h3>
                        </div>
                        <div class="p-4 bg-gradient-to-r from-rose-50 to-pink-50 rounded-xl border border-rose-200">
                            <p class="text-gray-800 leading-relaxed">{{ $rekamMedis->diagnosa }}</p>
                        </div>
                    </div>

                    <!-- Tindakan Section -->
                    @if($rekamMedis->tindakan)
                    <div>
                        <div class="flex items-center space-x-2 mb-3">
                            <div class="p-1.5 bg-teal-100 rounded-lg">
                                <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </div>
                            <h3 class="font-bold text-gray-800">Tindakan Medis</h3>
                        </div>
                        <div class="p-4 bg-gradient-to-r from-teal-50 to-emerald-50 rounded-xl border border-teal-200">
                            <p class="text-gray-800 leading-relaxed">{{ $rekamMedis->tindakan }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Resep Obat Section -->
                    <div>
                        <div class="flex items-center space-x-2 mb-3">
                            <div class="p-1.5 bg-emerald-100 rounded-lg">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                </svg>
                            </div>
                            <h3 class="font-bold text-gray-800">Resep Obat</h3>
                            <span class="text-xs text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-lg border border-emerald-200">Beli di luar klinik</span>
                        </div>
                        @if($rekamMedis->catatan_obat)
                            <div class="p-4 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl border border-emerald-200">
                                <pre class="text-gray-800 text-sm whitespace-pre-wrap font-mono bg-white p-4 rounded-lg border border-emerald-100">{{ $rekamMedis->catatan_obat }}</pre>
                            </div>
                        @else
                            <div class="p-6 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200 text-center">
                                <div class="p-3 bg-gray-100 rounded-full w-fit mx-auto mb-3">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-500">Tidak ada resep obat</p>
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                        <a href="{{ route('rekam_medis.index') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Kembali
                        </a>
                        <a href="{{ route('rekam_medis.edit', $rekamMedis) }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl text-white font-semibold shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:from-blue-600 hover:to-indigo-700 transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit Rekam Medis
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>