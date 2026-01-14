<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-gradient-to-br from-rose-500 to-pink-600 rounded-xl shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-xl text-gray-800 leading-tight">
                        {{ __('Riwayat Rekam Medis') }}
                    </h2>
                    <p class="text-sm text-gray-500">Kelola catatan medis pasien</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                @php
                    $totalRM = $rekamMedis->total();
                    $hariIni = $rekamMedis->filter(function($rm) {
                        return $rm->created_at->isToday();
                    })->count();
                    $denganObat = $rekamMedis->filter(function($rm) {
                        return $rm->obats->count() > 0;
                    })->count();
                @endphp
                
                <div class="bg-gradient-to-br from-rose-500 to-pink-600 rounded-2xl p-5 text-white shadow-lg shadow-rose-500/30 transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-rose-100 text-sm font-medium">Total Rekam Medis</p>
                            <p class="text-3xl font-bold mt-1">{{ $totalRM }}</p>
                        </div>
                        <div class="bg-white/20 p-3 rounded-xl">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl p-5 text-white shadow-lg shadow-amber-500/30 transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-amber-100 text-sm font-medium">Hari Ini</p>
                            <p class="text-3xl font-bold mt-1">{{ $hariIni }}</p>
                        </div>
                        <div class="bg-white/20 p-3 rounded-xl">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-5 text-white shadow-lg shadow-emerald-500/30 transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-emerald-100 text-sm font-medium">Dengan Resep</p>
                            <p class="text-3xl font-bold mt-1">{{ $denganObat }}</p>
                        </div>
                        <div class="bg-white/20 p-3 rounded-xl">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl p-5 text-white shadow-lg shadow-blue-500/30 transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Tanpa Resep</p>
                            <p class="text-3xl font-bold mt-1">{{ $rekamMedis->count() - $denganObat }}</p>
                        </div>
                        <div class="bg-white/20 p-3 rounded-xl">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Card -->
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                <!-- Card Header -->
                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-800">Daftar Rekam Medis</h3>
                        </div>
                        
                        <a href="{{ route('rekam_medis.create') }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-rose-500 to-pink-600 border border-transparent rounded-xl font-semibold text-sm text-white shadow-lg shadow-rose-500/30 hover:shadow-xl hover:shadow-rose-500/40 hover:from-rose-600 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Periksa Pasien Baru
                        </a>
                    </div>
                </div>

                <div class="p-6">
                    @if (session('success'))
                        <div class="mb-6 p-4 bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center shadow-sm">
                            <div class="flex-shrink-0 bg-emerald-500 rounded-full p-1 mr-3">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 text-red-700 rounded-xl shadow-sm">
                            <div class="flex items-center mb-2">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="font-semibold">Terjadi kesalahan:</span>
                            </div>
                            <ul class="list-disc list-inside text-sm space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Table -->
                    <div class="overflow-x-auto rounded-xl border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Tanggal</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Pasien</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Dokter</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Diagnosa</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Resep Obat</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse ($rekamMedis as $rm)
                                    <tr class="hover:bg-gradient-to-r hover:from-gray-50 hover:to-rose-50/30 transition-all duration-200 group">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-rose-400 to-pink-500 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg group-hover:scale-110 transition-all duration-200">
                                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-semibold text-gray-900">
                                                        {{ \Carbon\Carbon::parse($rm->kunjungan->waktu_kunjungan ?? $rm->created_at)->format('d M Y') }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">{{ $rm->created_at->format('H:i') }} WIB</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8 bg-gradient-to-br from-teal-400 to-cyan-500 rounded-lg flex items-center justify-center shadow">
                                                    <span class="text-white font-bold text-xs">{{ strtoupper(substr($rm->pasien->nama ?? 'N', 0, 2)) }}</span>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-semibold text-gray-900">{{ $rm->pasien->name ?? $rm->pasien->nama ?? 'N/A' }}</div>
                                                    <div class="text-xs text-gray-500 font-mono">{{ $rm->pasien->no_rekam_medis ?? '-' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-lg flex items-center justify-center shadow">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                </div>
                                                <span class="ml-3 text-sm text-gray-700">Dr. {{ $rm->dokter->user->name ?? 'N/A' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="max-w-xs">
                                                <p class="text-sm text-gray-700 truncate" title="{{ $rm->diagnosa }}">{{ Str::limit($rm->diagnosa, 35) }}</p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($rm->obats->count() > 0)
                                                <div class="flex flex-wrap gap-1">
                                                    @foreach ($rm->obats->take(2) as $obat)
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-medium bg-gradient-to-r from-emerald-100 to-teal-100 text-emerald-700 border border-emerald-200">
                                                            {{ $obat->nama_obat }} ({{ $obat->pivot->jumlah }})
                                                        </span>
                                                    @endforeach
                                                    @if ($rm->obats->count() > 2)
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-medium bg-gray-100 text-gray-600">
                                                            +{{ $rm->obats->count() - 2 }} lainnya
                                                        </span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-gray-400 italic text-xs">Tidak ada obat</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="flex items-center justify-center space-x-2">
                                                <button type="button" onclick="openDetailModal({{ $rm->id }})" class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-teal-500 to-cyan-600 rounded-lg text-white text-xs font-semibold shadow-md hover:shadow-lg hover:from-teal-600 hover:to-cyan-700 transform hover:-translate-y-0.5 transition-all duration-200">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                    Detail
                                                </button>

                                                <a href="{{ route('rekam_medis.edit', $rm->id) }}" class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg text-white text-xs font-semibold shadow-md hover:shadow-lg hover:from-blue-600 hover:to-indigo-700 transform hover:-translate-y-0.5 transition-all duration-200">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    Edit
                                                </a>
                                                
                                                <form action="{{ route('rekam_medis.destroy', $rm->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus data ini? PERINGATAN: Stok obat yang sudah diambil TIDAK AKAN kembali.');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-red-500 to-rose-600 rounded-lg text-white text-xs font-semibold shadow-md hover:shadow-lg hover:from-red-600 hover:to-rose-700 transform hover:-translate-y-0.5 transition-all duration-200">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-16 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="p-4 bg-gray-100 rounded-full mb-4">
                                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                </div>
                                                <p class="text-gray-500 text-lg font-medium mb-2">Belum ada data rekam medis</p>
                                                <p class="text-gray-400 text-sm mb-4">Mulai periksa pasien pertama</p>
                                                <a href="{{ route('rekam_medis.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-rose-500 to-pink-600 rounded-lg text-white text-sm font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                    </svg>
                                                    Periksa Pasien Pertama
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $rekamMedis->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-modal name="detail-modal" focusable>
        <div class="p-6">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h2 class="text-lg font-bold text-gray-900 flex items-center">
                    <div class="p-2 bg-gradient-to-br from-rose-500 to-pink-600 rounded-xl mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    Detail Rekam Medis
                </h2>
                <button x-on:click="$dispatch('close')" class="text-gray-400 hover:text-gray-500 p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div id="modal-loading" class="text-center py-8">
                <svg class="animate-spin h-8 w-8 text-rose-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="mt-2 text-sm text-gray-500">Memuat data...</p>
            </div>

            <div id="modal-content" class="hidden space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 bg-gradient-to-br from-teal-50 to-cyan-50 rounded-xl border border-teal-200">
                        <span class="text-xs text-teal-600 uppercase font-bold block mb-1">Pasien</span>
                        <span id="d-pasien" class="text-gray-900 font-semibold text-lg"></span>
                    </div>
                    <div class="p-4 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border border-blue-200">
                        <span class="text-xs text-blue-600 uppercase font-bold block mb-1">Dokter</span>
                        <span id="d-dokter" class="text-gray-900 font-semibold"></span>
                    </div>
                    <div class="p-4 bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl border border-amber-200">
                        <span class="text-xs text-amber-600 uppercase font-bold block mb-1">Tanggal Kunjungan</span>
                        <span id="d-tanggal" class="text-gray-900 font-semibold"></span>
                    </div>
                    <div class="p-4 bg-gradient-to-br from-violet-50 to-purple-50 rounded-xl border border-violet-200">
                        <span class="text-xs text-violet-600 uppercase font-bold block mb-1">Keluhan</span>
                        <p id="d-keluhan" class="text-gray-900 italic text-sm"></p>
                    </div>
                </div>

                <div class="p-4 bg-gradient-to-br from-rose-50 to-pink-50 rounded-xl border border-rose-200">
                    <span class="text-xs text-rose-600 uppercase font-bold block mb-2">Diagnosa</span>
                    <p id="d-diagnosa" class="text-gray-900 bg-white p-3 rounded-lg border border-rose-100"></p>
                </div>

                <div class="mt-4">
                    <span class="text-xs text-emerald-600 uppercase font-bold block mb-2">Resep Obat</span>
                    <div class="border border-emerald-200 rounded-xl overflow-hidden">
                        <table class="min-w-full divide-y divide-emerald-200">
                            <thead class="bg-gradient-to-r from-emerald-50 to-teal-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-emerald-700 uppercase">Nama Obat</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-emerald-700 uppercase">Jumlah</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-emerald-700 uppercase">Dosis</th>
                                </tr>
                            </thead>
                            <tbody id="d-obat-list" class="bg-white divide-y divide-gray-100 text-sm"></tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">Tutup</x-secondary-button>
                </div>
            </div>
        </div>
    </x-modal>

    @push('scripts')
    <script>
        function openDetailModal(id) {
            if (typeof Alpine === 'undefined') {
                console.error('Error: Alpine.js tidak terdeteksi.');
                return;
            }

            const modalLoading = document.getElementById('modal-loading');
            const modalContent = document.getElementById('modal-content');

            modalLoading.classList.remove('hidden');
            modalContent.classList.add('hidden');
            
            window.dispatchEvent(new CustomEvent('open-modal', { detail: 'detail-modal' }));

            fetch(`/rekam_medis/${id}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                const rm = data.rekam_medis || data; 

                document.getElementById('d-pasien').textContent = rm.pasien?.name || rm.pasien?.nama || '-';
                document.getElementById('d-dokter').textContent = rm.dokter?.user?.name || rm.dokter?.nama || '-';

                if (rm.kunjungan?.waktu_kunjungan) {
                    const dateObj = new Date(rm.kunjungan.waktu_kunjungan);
                    document.getElementById('d-tanggal').textContent = dateObj.toLocaleDateString('id-ID', {
                        day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit'
                    });
                } else {
                    document.getElementById('d-tanggal').textContent = '-';
                }

                document.getElementById('d-diagnosa').textContent = rm.diagnosa || '-';
                document.getElementById('d-keluhan').textContent = rm.keluhan || '-';
                
                const obatBody = document.getElementById('d-obat-list');
                obatBody.innerHTML = '';

                if(rm.obats && rm.obats.length > 0) {
                    rm.obats.forEach(obat => {
                        const row = `
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium">${obat.nama_obat}</td>
                                <td class="px-4 py-3">${obat.pivot?.jumlah || '-'}</td>
                                <td class="px-4 py-3">${obat.pivot?.dosis || '-'}</td>
                            </tr>`;
                        obatBody.innerHTML += row;
                    });
                } else {
                    obatBody.innerHTML = `<tr><td colspan="3" class="px-4 py-3 text-center text-gray-400 italic">Tidak ada resep obat</td></tr>`;
                }

                modalLoading.classList.add('hidden');
                modalContent.classList.remove('hidden');
            })
            .catch(err => {
                console.error(err);
                alert('Gagal memuat data.');
                window.dispatchEvent(new CustomEvent('close-modal', { detail: 'detail-modal' }));
            });
        }
    </script>
    @endpush
</x-app-layout>