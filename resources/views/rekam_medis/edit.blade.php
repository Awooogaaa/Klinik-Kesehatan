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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    {{ __('Edit Rekam Medis') }}
                </h2>
                <p class="text-sm text-gray-500">Perbarui catatan rekam medis pasien</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                <!-- Card Header with Patient Info -->
                <div class="px-6 py-6 border-b border-gray-100 bg-gradient-to-r from-rose-500 to-pink-600">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-5">
                            <div class="h-14 w-14 rounded-2xl bg-white/20 flex items-center justify-center shadow-xl border-4 border-white/30">
                                <span class="text-white font-bold text-xl">{{ strtoupper(substr($rekamMedis->pasien->nama ?? 'P', 0, 2)) }}</span>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">{{ $rekamMedis->pasien->nama }}</h3>
                                <div class="flex items-center space-x-2 mt-1">
                                    <span class="inline-flex items-center bg-white/20 text-white text-sm px-3 py-1 rounded-full font-medium">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Dr. {{ $rekamMedis->dokter->user->name }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-rose-100 text-xs uppercase font-semibold">ID Rekam Medis</p>
                            <p class="text-white font-bold text-lg">#{{ str_pad($rekamMedis->id, 5, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    @php
                        $existingTindakan = $rekamMedis->tindakanMedis->map(function($item) {
                            return [
                                'nama_tindakan' => $item->nama_tindakan,
                                'biaya' => $item->biaya,
                                'keterangan' => $item->keterangan,
                            ];
                        })->toArray();
                    @endphp
                    
                    <form action="{{ route('rekam_medis.update', $rekamMedis->id) }}" method="POST"
                          x-data="formHandler({{ json_encode($existingTindakan) }}, {{ $rekamMedis->biaya_pemeriksaan }})" class="space-y-8">
                        @csrf
                        @method('PUT')
                        
                        <!-- Section 1: Keluhan & Diagnosa -->
                        <div>
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="p-2 bg-gradient-to-br from-violet-500 to-purple-600 rounded-xl shadow">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-lg text-gray-800">1. Keluhan & Diagnosa</h3>
                                    <p class="text-sm text-gray-500">Perbarui catatan keluhan dan diagnosa</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-6 rounded-2xl">
                                <div class="group">
                                    <label for="keluhan" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                        <svg class="w-4 h-4 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                        </svg>
                                        Keluhan Pasien <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <textarea id="keluhan" name="keluhan" rows="4" required
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all duration-200 bg-white resize-none">{{ old('keluhan', $rekamMedis->keluhan) }}</textarea>
                                </div>
                                
                                <div class="group">
                                    <label for="diagnosa" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                        <svg class="w-4 h-4 mr-2 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                        Diagnosa Dokter <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <textarea id="diagnosa" name="diagnosa" rows="4" required
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all duration-200 bg-white resize-none">{{ old('diagnosa', $rekamMedis->diagnosa) }}</textarea>
                                </div>

                                <div class="md:col-span-2 group">
                                    <label for="tindakan" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                        <svg class="w-4 h-4 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                        Catatan Tindakan
                                    </label>
                                    <textarea id="tindakan" name="tindakan" rows="2"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all duration-200 bg-white resize-none">{{ old('tindakan', $rekamMedis->tindakan) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Biaya & Resep Obat -->
                        <div>
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="p-2 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl shadow">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-lg text-gray-800">2. Biaya Pemeriksaan & Resep Obat</h3>
                                    <p class="text-sm text-gray-500">Perbarui biaya dan resep obat</p>
                                </div>
                            </div>
                            
                            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 p-6 rounded-2xl border border-emerald-200 space-y-6">
                                <!-- Biaya Pemeriksaan -->
                                <div>
                                    <label for="biaya_pemeriksaan" class="flex items-center text-sm font-semibold text-emerald-700 mb-2">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        Biaya Pemeriksaan (Rp) <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <span class="text-emerald-600 font-semibold">Rp</span>
                                        </div>
                                        <input type="number" name="biaya_pemeriksaan" id="biaya_pemeriksaan" required min="0"
                                            x-model="biayaPemeriksaan"
                                            value="{{ old('biaya_pemeriksaan', $rekamMedis->biaya_pemeriksaan) }}"
                                            class="w-full pl-12 pr-4 py-3 border border-emerald-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-white text-lg font-semibold">
                                    </div>
                                </div>

                                <!-- Catatan Obat/Resep -->
                                <div>
                                    <label for="catatan_obat" class="flex items-center text-sm font-semibold text-emerald-700 mb-2">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                        </svg>
                                        Resep Obat (Catatan Manual)
                                    </label>
                                    <textarea name="catatan_obat" id="catatan_obat" rows="4"
                                        class="w-full px-4 py-3 border border-emerald-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-white resize-none font-mono text-sm"
                                        placeholder="Tulis resep obat...">{{ old('catatan_obat', $rekamMedis->catatan_obat) }}</textarea>
                                    <p class="text-xs text-emerald-600 mt-1">
                                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Pasien akan membeli obat di luar klinik
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Tindakan Medis Tambahan -->
                        <div>
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl shadow">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-lg text-gray-800">3. Tindakan Medis Tambahan</h3>
                                        <p class="text-sm text-gray-500">Suntik, infus, atau tindakan lainnya (opsional)</p>
                                    </div>
                                </div>
                                <button type="button" @click="addTindakan()" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-amber-500 to-orange-600 rounded-xl text-white text-sm font-semibold shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Tambah Tindakan
                                </button>
                            </div>
                            
                            <div class="space-y-4">
                                <template x-for="(item, index) in tindakanList" :key="index">
                                    <div class="flex flex-col md:flex-row gap-4 items-start md:items-end bg-gradient-to-r from-amber-50 to-orange-50 p-5 rounded-2xl border border-amber-200">
                                        <div class="flex-1 w-full">
                                            <label class="text-xs text-amber-600 uppercase font-bold mb-2 block">Nama Tindakan</label>
                                            <input type="text" :name="'tindakan_medis['+index+'][nama_tindakan]'" x-model="item.nama_tindakan"
                                                class="w-full px-4 py-3 border border-amber-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 bg-white"
                                                placeholder="Contoh: Suntik, Infus Nutrisi, dll">
                                        </div>
                                        <div class="w-full md:w-40">
                                            <label class="text-xs text-amber-600 uppercase font-bold mb-2 block">Biaya (Rp)</label>
                                            <input type="number" :name="'tindakan_medis['+index+'][biaya]'" x-model="item.biaya" min="0"
                                                class="w-full px-4 py-3 border border-amber-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 bg-white"
                                                placeholder="25000">
                                        </div>
                                        <div class="flex-1 w-full">
                                            <label class="text-xs text-amber-600 uppercase font-bold mb-2 block">Keterangan</label>
                                            <input type="text" :name="'tindakan_medis['+index+'][keterangan]'" x-model="item.keterangan"
                                                class="w-full px-4 py-3 border border-amber-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 bg-white"
                                                placeholder="Keterangan (opsional)">
                                        </div>
                                        <button type="button" @click="removeTindakan(index)" class="p-3 bg-red-100 text-red-600 rounded-xl hover:bg-red-200 transition-colors duration-200" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"> 
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                                
                                <div x-show="tindakanList.length === 0" class="text-center py-8 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                                    <div class="p-3 bg-gray-100 rounded-full w-fit mx-auto mb-3">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 text-sm">Belum ada tindakan medis tambahan</p>
                                    <button type="button" @click="addTindakan()" class="mt-3 text-amber-600 font-semibold text-sm hover:underline">+ Tambah Tindakan</button>
                                </div>
                            </div>
                        </div>

                        <!-- Total Preview -->
                        <div class="pt-6 border-t border-gray-100">
                            <div class="flex items-center justify-end space-x-3">
                                
                                <button type="submit" form="delete-form" onclick="return confirm('Hapus data rekam medis ini? Data tidak dapat dikembalikan!');" 
                                        class="inline-flex items-center px-6 py-3 border border-red-200 rounded-xl text-red-600 font-semibold hover:bg-red-50 hover:border-red-300 transition-all duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Hapus
                                </button>

                                <a href="{{ route('rekam_medis.index') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Batal
                                </a>

                                <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-rose-500 to-pink-600 rounded-xl text-white font-semibold shadow-lg shadow-rose-500/30 hover:shadow-xl hover:shadow-rose-500/40 hover:from-rose-600 hover:to-pink-700 transform hover:-translate-y-0.5 transition-all duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                    </svg>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                    <form id="delete-form" action="{{ route('rekam_medis.destroy', $rekamMedis->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>

                </div>
            </div>

            <div class="mt-6 bg-gradient-to-r from-gray-50 to-slate-50 border border-gray-200 rounded-2xl p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0 bg-gray-500 rounded-xl p-2">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h4 class="font-semibold text-gray-800">Informasi Data</h4>
                        <div class="mt-2 text-sm text-gray-600 space-y-1">
                            <p class="flex items-center">
                                <span class="font-medium w-32">Dibuat pada:</span>
                                <span>{{ $rekamMedis->created_at->format('d M Y, H:i') }}</span>
                            </p>
                            <p class="flex items-center">
                                <span class="font-medium w-32">Terakhir diubah:</span>
                                <span>{{ $rekamMedis->updated_at->format('d M Y, H:i') }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function formHandler(initialTindakan, initialBiaya) {
            return {
                tindakanList: initialTindakan && initialTindakan.length > 0 ? initialTindakan : [],
                biayaPemeriksaan: initialBiaya || 0,
                get totalBiaya() {
                    let biaya = parseInt(this.biayaPemeriksaan) || 0;
                    let totalTindakan = this.tindakanList.reduce((sum, item) => sum + (parseInt(item.biaya) || 0), 0);
                    return biaya + totalTindakan;
                },
                addTindakan() { 
                    this.tindakanList.push({ nama_tindakan: '', biaya: 0, keterangan: '' }); 
                },
                removeTindakan(index) { 
                    this.tindakanList.splice(index, 1); 
                }
            }
        }
    </script>
</x-app-layout>