<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('kunjungans.index') }}" class="p-2 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div class="p-2 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    {{ __('Atur Jadwal Kunjungan') }}
                </h2>
                <p class="text-sm text-gray-500">Kelola jadwal dan status kunjungan pasien</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                <!-- Card Header -->
                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-blue-500 to-indigo-600">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="bg-white/20 p-2 rounded-xl">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white">Edit Jadwal Kunjungan</h3>
                                <p class="text-blue-100 text-sm">Perbarui informasi jadwal</p>
                            </div>
                        </div>
                        @php
                            $statusStyles = [
                                'menunggu' => 'bg-amber-400',
                                'pending_konfirmasi' => 'bg-orange-500',
                                'disetujui' => 'bg-blue-400',
                                'selesai' => 'bg-emerald-400',
                                'batal' => 'bg-red-400',
                            ];
                            $statusLabels = [
                                'menunggu' => 'Menunggu',
                                'pending_konfirmasi' => 'Pending Konfirmasi',
                                'disetujui' => 'Disetujui',
                                'selesai' => 'Selesai',
                                'batal' => 'Batal',
                            ];
                        @endphp
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold {{ $statusStyles[$kunjungan->status] ?? 'bg-gray-400' }} text-white">
                            {{ $statusLabels[$kunjungan->status] ?? ucfirst($kunjungan->status) }}
                        </span>
                    </div>
                </div>

                <div class="p-8">
                    <!-- Error Alert -->
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 text-red-700 rounded-2xl shadow-sm">
                            <div class="flex items-center mb-2">
                                <div class="flex-shrink-0 bg-red-500 rounded-lg p-1.5 mr-3">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <span class="font-semibold">Tidak Dapat Menyimpan Jadwal!</span>
                            </div>
                            <ul class="list-disc list-inside text-sm space-y-1 ml-9">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Patient Info Card -->
                    <div class="mb-8 bg-gradient-to-r from-violet-50 to-purple-50 border border-violet-200 rounded-2xl p-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-14 w-14 bg-gradient-to-br from-violet-400 to-purple-500 rounded-2xl flex items-center justify-center shadow-lg">
                                <span class="text-white font-bold text-lg">{{ strtoupper(substr($kunjungan->pasien->nama, 0, 2)) }}</span>
                            </div>
                            <div class="ml-5 flex-1">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="text-lg font-bold text-gray-900">{{ $kunjungan->pasien->nama }}</h4>
                                        <p class="text-sm text-gray-500 flex items-center mt-1">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            No. RM: {{ $kunjungan->pasien->no_rekam_medis }}
                                        </p>
                                    </div>
                                </div>
                                <div class="mt-4 p-3 bg-white rounded-xl border border-violet-100">
                                    <p class="text-xs font-semibold text-violet-600 uppercase tracking-wider mb-1">Keluhan</p>
                                    <p class="text-sm text-gray-700">{{ $kunjungan->keluhan_awal }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Preferensi Dokter dari Pasien --}}
                    @if($kunjungan->preferensiDokter)
                    <div class="mb-8 bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 rounded-2xl p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-12 w-12 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-2xl flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-xs font-semibold text-emerald-600 uppercase tracking-wider">Preferensi Dokter dari Pasien</p>
                                <p class="text-base font-bold text-gray-900 mt-0.5">{{ $kunjungan->preferensiDokter->user->name ?? $kunjungan->preferensiDokter->nama }}</p>
                                @if($kunjungan->preferensiDokter->spesialisasi)
                                    <p class="text-sm text-emerald-700">{{ $kunjungan->preferensiDokter->spesialisasi }}</p>
                                @endif
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Pilihan Pasien
                                </span>
                            </div>
                        </div>
                        <p class="text-xs text-emerald-600 mt-3 ml-16">💡 Anda tetap bisa memilih dokter lain sesuai ketersediaan klinik.</p>
                    </div>
                    @endif

                    <form action="{{ route('kunjungans.update', $kunjungan) }}" method="POST" class="space-y-6"
                        x-data="{ 
                            selectedStatus: '{{ $kunjungan->status }}',
                            hasRekamMedis: {{ $hasRekamMedis ? 'true' : 'false' }},
                            originalStatus: '{{ $kunjungan->status }}',
                            isDokter: {{ $isDokter ? 'true' : 'false' }}
                        }">
                        @csrf
                        @method('PUT')
                        
                        <input type="hidden" name="pasien_id" value="{{ $kunjungan->pasien_id }}">
                        <input type="hidden" name="keluhan_awal" value="{{ $kunjungan->keluhan_awal }}">

                        <!-- Warning: Rekam Medis sudah tercatat -->
                        @if($hasRekamMedis)
                        <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-2xl">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-blue-500 rounded-lg p-1.5 mr-3">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-blue-800">Rekam Medis Sudah Tercatat</p>
                                    <p class="text-xs text-blue-600">Status kunjungan tidak dapat diubah karena rekam medis sudah tercatat untuk kunjungan ini.</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Pilih Dokter - Hidden when status is batal -->
                        <div class="group" x-show="selectedStatus !== 'batal'" x-transition>
                            <label for="dokter_id" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Pilih Dokter <span class="text-red-500 ml-1">*</span>
                                @if($isDokter)
                                    <span class="ml-2 text-xs text-gray-400 font-normal">(Tidak dapat diubah oleh dokter)</span>
                                @endif
                            </label>
                            <div class="relative">
                                <select name="dokter_id" id="dokter_id" :required="selectedStatus !== 'batal'"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none cursor-pointer
                                    {{ $isDokter ? 'bg-gray-100 cursor-not-allowed' : 'bg-gray-50 hover:bg-white focus:bg-white' }}"
                                    {{ $isDokter ? 'disabled' : '' }}>
                                    <option value="">-- Pilih Dokter --</option>
                                    @foreach($dokters as $dokter)
                                        <option value="{{ $dokter->id }}" @if($kunjungan->dokter_id == $dokter->id) selected @endif>
                                            {{ $dokter->user->name }} ({{ $dokter->spesialisasi }})
                                        </option>
                                    @endforeach
                                </select>
                                @if($isDokter)
                                    <input type="hidden" name="dokter_id" value="{{ $kunjungan->dokter_id }}">
                                @endif
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                            @error('dokter_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal & Jam - Hidden when status is batal -->
                        <div class="group" x-show="selectedStatus !== 'batal'" x-transition>
                            <label for="waktu_kunjungan" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Tanggal & Jam Periksa <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="datetime-local" name="waktu_kunjungan" id="waktu_kunjungan" :required="selectedStatus !== 'batal'"
                                value="{{ $kunjungan->waktu_kunjungan ? $kunjungan->waktu_kunjungan->format('Y-m-d\TH:i') : '' }}"
                                min="{{ now()->format('Y-m-d\TH:i') }}"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 hover:bg-white focus:bg-white">
                            @error('waktu_kunjungan')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Notice when status is batal -->
                        <div class="p-4 bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 rounded-2xl" x-show="selectedStatus === 'batal'" x-transition>
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-red-500 rounded-lg p-1.5 mr-3">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-red-800">Kunjungan Akan Dibatalkan</p>
                                    <p class="text-xs text-red-600">Data dokter dan jadwal akan dihapus jika kunjungan dibatalkan.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="group">
                            <label class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Status Kunjungan <span class="text-red-500 ml-1">*</span>
                            </label>
                            
                            @if($isDokter)
                            <!-- Warning for Dokter: Limited access -->
                            <div class="mb-3 p-3 bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-xl">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-amber-500 rounded-lg p-1.5 mr-3">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-amber-800">Akses Terbatas</p>
                                        <p class="text-xs text-amber-600">Sebagai dokter, Anda tidak dapat memilih status <strong>Menunggu</strong> atau mengubah <strong>Pilih Dokter</strong>.</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                <!-- Menunggu -->
                                <label class="relative" :class="{ 'cursor-not-allowed opacity-60': hasRekamMedis || isDokter, 'cursor-pointer': !hasRekamMedis && !isDokter }">
                                    <input type="radio" name="status" value="menunggu" class="peer sr-only" 
                                        @if($kunjungan->status == 'menunggu') checked @endif 
                                        @change="selectedStatus = 'menunggu'"
                                        :disabled="hasRekamMedis || isDokter"
                                        required>
                                    <div class="p-4 border-2 border-gray-200 rounded-xl text-center transition-all duration-200 peer-checked:border-amber-500 peer-checked:bg-amber-50 peer-disabled:bg-gray-100 peer-disabled:cursor-not-allowed" :class="{ 'hover:border-gray-300 hover:bg-gray-50': !hasRekamMedis && !isDokter }">
                                        <svg class="w-6 h-6 mx-auto mb-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-700">Menunggu</span>
                                        <template x-if="isDokter">
                                            <p class="text-xs text-gray-400 mt-1">Tidak tersedia</p>
                                        </template>
                                    </div>
                                </label>
                                
                                <!-- Disetujui -->
                                <label class="relative" :class="{ 'cursor-not-allowed opacity-60': hasRekamMedis, 'cursor-pointer': !hasRekamMedis }">
                                    <input type="radio" name="status" value="disetujui" class="peer sr-only" 
                                        @if($kunjungan->status == 'disetujui') checked @endif
                                        @change="selectedStatus = 'disetujui'"
                                        :disabled="hasRekamMedis">
                                    <div class="p-4 border-2 border-gray-200 rounded-xl text-center transition-all duration-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-disabled:bg-gray-100 peer-disabled:cursor-not-allowed" :class="{ 'hover:border-gray-300 hover:bg-gray-50': !hasRekamMedis }">
                                        <svg class="w-6 h-6 mx-auto mb-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-700">Disetujui</span>
                                    </div>
                                </label>
                                
                                <!-- Selesai -->
                                <label class="relative" :class="{ 'cursor-not-allowed opacity-60': !hasRekamMedis && originalStatus !== 'selesai', 'cursor-pointer': hasRekamMedis || originalStatus === 'selesai' }">
                                    <input type="radio" name="status" value="selesai" class="peer sr-only" 
                                        @if($kunjungan->status == 'selesai') checked @endif
                                        @change="selectedStatus = 'selesai'"
                                        :disabled="!hasRekamMedis && originalStatus !== 'selesai'">
                                    <div class="p-4 border-2 border-gray-200 rounded-xl text-center transition-all duration-200 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-disabled:bg-gray-100 peer-disabled:cursor-not-allowed" :class="{ 'hover:border-gray-300 hover:bg-gray-50': hasRekamMedis || originalStatus === 'selesai' }">
                                        <svg class="w-6 h-6 mx-auto mb-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-700">Selesai</span>
                                        <template x-if="!hasRekamMedis && originalStatus !== 'selesai'">
                                            <p class="text-xs text-red-500 mt-1">Rekam Medis Belum tercatat</p>
                                        </template>
                                    </div>
                                </label>
                                
                                <!-- Batal -->
                                <label class="relative" :class="{ 'cursor-not-allowed opacity-60': hasRekamMedis, 'cursor-pointer': !hasRekamMedis }">
                                    <input type="radio" name="status" value="batal" class="peer sr-only" 
                                        @if($kunjungan->status == 'batal') checked @endif
                                        @change="selectedStatus = 'batal'"
                                        :disabled="hasRekamMedis">
                                    <div class="p-4 border-2 border-gray-200 rounded-xl text-center transition-all duration-200 peer-checked:border-red-500 peer-checked:bg-red-50 peer-disabled:bg-gray-100 peer-disabled:cursor-not-allowed" :class="{ 'hover:border-gray-300 hover:bg-gray-50': !hasRekamMedis }">
                                        <svg class="w-6 h-6 mx-auto mb-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-700">Batal</span>
                                    </div>
                                </label>
                            </div>
                            @error('status')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('kunjungans.index') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl text-white font-semibold shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:from-blue-600 hover:to-indigo-700 transform hover:-translate-y-0.5 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                                Update Jadwal
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Actions -->
            @if($kunjungan->status == 'selesai')
            <div class="mt-6 bg-gradient-to-r from-emerald-50 to-green-50 border border-emerald-200 rounded-2xl p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-emerald-500 rounded-xl p-2 mr-4">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-emerald-900">Kunjungan Selesai</h4>
                            <p class="text-sm text-emerald-700">Anda dapat membuat rekam medis untuk kunjungan ini</p>
                        </div>
                    </div>
                    <a href="{{ route('rekam_medis.create', ['kunjungan_id' => $kunjungan->id]) }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 rounded-xl text-white text-sm font-semibold hover:bg-emerald-700 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Buat Rekam Medis
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>