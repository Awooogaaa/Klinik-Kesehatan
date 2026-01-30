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
                    {{ __('Pemeriksaan Baru') }}
                </h2>
                <p class="text-sm text-gray-500">Catat rekam medis pasien</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if ($errors->any())
                <div class="mb-6 p-4 bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 text-red-700 rounded-2xl shadow-sm">
                    <div class="flex items-center mb-2">
                        <div class="flex-shrink-0 bg-red-500 rounded-lg p-1.5 mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <span class="font-semibold">Terjadi Kesalahan!</span>
                    </div>
                    <ul class="list-disc list-inside text-sm space-y-1 ml-9">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($kunjungans->isEmpty())
                <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                    <div class="p-12 text-center">
                        <div class="p-4 bg-amber-100 rounded-full w-fit mx-auto mb-4">
                            <svg class="w-12 h-12 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Tidak Ada Antrian Pasien</h3>
                        <p class="text-gray-500 mb-6">Tidak ada antrian pasien dengan status "Disetujui".{{ Auth::user()->role !== 'perawat' ? ' Silakan atur jadwal kunjungan terlebih dahulu.' : ' Silakan hubungi dokter atau admin untuk jadwal kunjungan.' }}</p>
                        @if(Auth::user()->role !== 'perawat')
                        <a href="{{ route('kunjungans.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-amber-500 to-orange-600 rounded-xl text-white font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Kelola Jadwal Kunjungan
                        </a>
                        @endif
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                    <!-- Card Header -->
                    <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-rose-500 to-pink-600">
                        <div class="flex items-center space-x-3">
                            <div class="bg-white/20 p-2 rounded-xl">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white">Formulir Rekam Medis</h3>
                                <p class="text-rose-100 text-sm">Catat hasil pemeriksaan dan biaya perawatan</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-8">
                        <form action="{{ route('rekam_medis.store') }}" method="POST" x-data="formHandler()" class="space-y-8">
                            @csrf
                            
                            <!-- Section 1: Pilih Antrian -->
                            <div>
                                <div class="flex items-center space-x-3 mb-6">
                                    <div class="p-2 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-lg text-gray-800">1. Pilih Antrian Pasien</h3>
                                        <p class="text-sm text-gray-500">Pasien dengan jadwal yang sudah disetujui</p>
                                    </div>
                                </div>
                                
                                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-2xl border border-blue-200">
                                    <label for="kunjungan_id" class="flex items-center text-sm font-semibold text-blue-700 mb-2">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        Pilih Pasien <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <select name="kunjungan_id" id="kunjungan_id" required onchange="fillKeluhan()"
                                        class="w-full px-4 py-3 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white text-gray-800 font-medium">
                                        <option value="">-- Pilih Pasien dari Antrian --</option>
                                        @foreach($kunjungans as $k)
                                            <option value="{{ $k->id }}" data-keluhan="{{ $k->keluhan_awal }}" {{ old('kunjungan_id') == $k->id ? 'selected' : '' }}>
                                                🕐 {{ $k->waktu_kunjungan->format('H:i') }} - {{ $k->pasien->nama }} (Dr. {{ $k->dokter->user->name }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Section 2: Keluhan & Diagnosa -->
                            <div>
                                <div class="flex items-center space-x-3 mb-6">
                                    <div class="p-2 bg-gradient-to-br from-violet-500 to-purple-600 rounded-xl shadow">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-lg text-gray-800">2. Keluhan & Diagnosa</h3>
                                        <p class="text-sm text-gray-500">Catat keluhan pasien dan hasil diagnosa</p>
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
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all duration-200 bg-white resize-none"
                                            placeholder="Keluhan yang disampaikan pasien...">{{ old('keluhan') }}</textarea>
                                    </div>
                                    
                                    <div class="group">
                                        <label for="diagnosa" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                            <svg class="w-4 h-4 mr-2 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                            </svg>
                                            Diagnosa Dokter <span class="text-red-500 ml-1">*</span>
                                        </label>
                                        <textarea id="diagnosa" name="diagnosa" rows="4" required
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all duration-200 bg-white resize-none"
                                            placeholder="Hasil diagnosa oleh dokter...">{{ old('diagnosa') }}</textarea>
                                    </div>

                                    <div class="md:col-span-2 group">
                                        <label for="tindakan" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                            <svg class="w-4 h-4 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                            </svg>
                                            Catatan Tindakan
                                        </label>
                                        <textarea id="tindakan" name="tindakan" rows="2"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all duration-200 bg-white resize-none"
                                            placeholder="Tindakan medis yang dilakukan (opsional)...">{{ old('tindakan') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 3: Biaya & Resep Obat -->
                            <div>
                                <div class="flex items-center space-x-3 mb-6">
                                    <div class="p-2 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl shadow">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-lg text-gray-800">3. Biaya Pemeriksaan & Resep Obat</h3>
                                        <p class="text-sm text-gray-500">Input biaya dan tulis resep obat untuk pasien</p>
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
                                                value="{{ old('biaya_pemeriksaan', 50000) }}"
                                                class="w-full pl-12 pr-4 py-3 border border-emerald-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-white text-lg font-semibold"
                                                placeholder="50000">
                                        </div>
                                        <p class="text-xs text-emerald-600 mt-1">Biaya konsultasi/pemeriksaan dokter</p>
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
                                            placeholder="Tulis resep obat yang diberikan. Contoh:
- Paracetamol 500mg (3x1 sesudah makan)
- Vitamin C 1000mg (1x1 pagi hari)
- Amoxicillin 500mg (3x1 sesudah makan, habiskan)">{{ old('catatan_obat') }}</textarea>
                                        <p class="text-xs text-emerald-600 mt-1">
                                            <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Pasien akan membeli obat di luar klinik berdasarkan resep ini
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 4: Tindakan Medis Tambahan -->
                            <div>
                                <div class="flex items-center justify-between mb-6">
                                    <div class="flex items-center space-x-3">
                                        <div class="p-2 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl shadow">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-lg text-gray-800">4. Tindakan Medis Tambahan</h3>
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
                            <div class="bg-gradient-to-r from-gray-800 to-gray-900 p-6 rounded-2xl text-white">
                                <div class="flex justify-between items-center">
                                    <span class="font-semibold">Total Biaya (Preview)</span>
                                    <span class="text-2xl font-bold" x-text="'Rp ' + totalBiaya.toLocaleString('id-ID')"></span>
                                </div>
                                <p class="text-gray-400 text-sm mt-1">Biaya Pemeriksaan + Total Tindakan Medis</p>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                                <a href="{{ route('rekam_medis.index') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Batal
                                </a>
                                <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-rose-500 to-pink-600 rounded-xl text-white font-semibold shadow-lg shadow-rose-500/30 hover:shadow-xl hover:shadow-rose-500/40 hover:from-rose-600 hover:to-pink-700 transform hover:-translate-y-0.5 transition-all duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Simpan Rekam Medis
                                </button>
                            </div>
                        </form>

                        <script>
                            function fillKeluhan() {
                                var select = document.getElementById('kunjungan_id');
                                var keluhan = select.options[select.selectedIndex].getAttribute('data-keluhan');
                                document.getElementById('keluhan').value = keluhan ? keluhan : '';
                            }

                            function formHandler() {
                                return {
                                    tindakanList: [],
                                    get totalBiaya() {
                                        let biayaPemeriksaan = parseInt(document.getElementById('biaya_pemeriksaan')?.value) || 0;
                                        let totalTindakan = this.tindakanList.reduce((sum, item) => sum + (parseInt(item.biaya) || 0), 0);
                                        return biayaPemeriksaan + totalTindakan;
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
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>