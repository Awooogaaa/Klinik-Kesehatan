<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-gradient-to-br from-violet-500 to-purple-600 rounded-xl shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-xl text-gray-800 leading-tight">
                        {{ __('Dashboard Admin') }}
                    </h2>
                    <p class="text-sm text-gray-500">Panel kontrol administrasi klinik</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Card -->
            <div class="bg-gradient-to-r from-violet-500 via-purple-500 to-fuchsia-500 overflow-hidden shadow-xl rounded-2xl mb-6">
                <div class="p-8">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-5">
                            <div class="h-16 w-16 rounded-2xl bg-white/20 flex items-center justify-center shadow-xl border-4 border-white/30">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-white">Selamat Datang, {{ Auth::user()->name }}!</h3>
                                <p class="text-purple-100 mt-1">Anda memiliki akses penuh untuk mengelola sistem klinik.</p>
                            </div>
                        </div>
                        <div class="hidden md:block text-right">
    {{-- Menggunakan Carbon untuk set timezone ke Jakarta dan format bahasa Indonesia --}}
    <p class="text-purple-100 text-sm">
        {{ now()->setTimezone('Asia/Jakarta')->translatedFormat('l, d F Y') }}
    </p>
    <p class="text-white text-lg font-semibold">
        {{ now()->setTimezone('Asia/Jakarta')->format('H:i') }} WIB
    </p>
</div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl p-5 text-white shadow-lg shadow-blue-500/30 transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Total Dokter</p>
                            <p class="text-3xl font-bold mt-1">{{ \App\Models\Dokter::count() }}</p>
                        </div>
                        <div class="bg-white/20 p-3 rounded-xl">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-teal-500 to-cyan-600 rounded-2xl p-5 text-white shadow-lg shadow-teal-500/30 transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-teal-100 text-sm font-medium">Total Pasien</p>
                            <p class="text-3xl font-bold mt-1">{{ \App\Models\Pasien::count() }}</p>
                        </div>
                        <div class="bg-white/20 p-3 rounded-xl">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl p-5 text-white shadow-lg shadow-amber-500/30 transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-amber-100 text-sm font-medium">Kunjungan Hari Ini</p>
                            <p class="text-3xl font-bold mt-1">{{ \App\Models\Kunjungan::whereDate('created_at', today())->count() }}</p>
                        </div>
                        <div class="bg-white/20 p-3 rounded-xl">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl p-5 text-white shadow-lg shadow-emerald-500/30 transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-emerald-100 text-sm font-medium">Total Obat</p>
                            <p class="text-3xl font-bold mt-1">{{ \App\Models\Obat::count() }}</p>
                        </div>
                        <div class="bg-white/20 p-3 rounded-xl">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100 mb-6">
                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex items-center space-x-2">
                        <div class="p-2 bg-gradient-to-br from-violet-500 to-purple-600 rounded-xl">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">Statistik Kunjungan Pasien</h4>
                            <p class="text-sm text-gray-500">Data tahun {{ date('Y') }}</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-end space-x-2 sm:space-x-4 h-64 border-b-2 border-gray-200 pb-2">
                        @foreach($chartData as $data)
                            <div class="flex-1 flex flex-col justify-end items-center group relative h-full">
                                <div class="absolute bottom-full mb-2 hidden group-hover:block z-10">
                                    <span class="bg-gray-800 text-white text-xs rounded-lg py-1.5 px-3 whitespace-nowrap shadow-lg">
                                        {{ $data['count'] }} Pasien
                                    </span>
                                </div>

                                @if($data['count'] > 0)
                                    <span class="text-xs text-gray-600 mb-1 font-bold">{{ $data['count'] }}</span>
                                @endif

                                <div class="w-full bg-gradient-to-t from-violet-500 to-purple-400 hover:from-violet-600 hover:to-purple-500 rounded-t-lg transition-all duration-300 shadow-sm"
                                     style="height: {{ $maxKunjungan > 0 ? ($data['count'] / $maxKunjungan) * 100 : 0 }}%; min-height: {{ $data['count'] > 0 ? '8px' : '0' }};">
                                </div>
                                
                                <div class="text-xs text-gray-500 mt-3 font-semibold">{{ $data['label'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Navigation Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Manajemen Pengguna -->
                <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100 hover:shadow-2xl hover:border-blue-200 transform hover:-translate-y-1 transition-all duration-300">
                    <div class="p-6">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="p-3 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-lg shadow-blue-500/30">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-900">Manajemen Pengguna</h4>
                                <p class="text-sm text-gray-500">Kelola data dokter & pasien</p>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <a href="{{ route('dokters.index') }}" class="flex items-center justify-between p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-100 hover:border-blue-300 hover:shadow-md transition-all duration-200 group">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-semibold text-gray-700">Kelola Data Dokter</span>
                                </div>
                                <svg class="w-5 h-5 text-blue-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                            <a href="{{ route('pasiens.index') }}" class="flex items-center justify-between p-3 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-xl border border-teal-100 hover:border-teal-300 hover:shadow-md transition-all duration-200 group">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-teal-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <span class="font-semibold text-gray-700">Kelola Data Pasien</span>
                                </div>
                                <svg class="w-5 h-5 text-teal-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Layanan Klinik -->
                <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100 hover:shadow-2xl hover:border-emerald-200 transform hover:-translate-y-1 transition-all duration-300">
                    <div class="p-6">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="p-3 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl shadow-lg shadow-emerald-500/30">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-900">Layanan Klinik</h4>
                                <p class="text-sm text-gray-500">Kelola obat & kunjungan</p>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <a href="{{ route('obats.index') }}" class="flex items-center justify-between p-3 bg-gradient-to-r from-emerald-50 to-green-50 rounded-xl border border-emerald-100 hover:border-emerald-300 hover:shadow-md transition-all duration-200 group">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-emerald-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                    </svg>
                                    <span class="font-semibold text-gray-700">Kelola Obat</span>
                                </div>
                                <svg class="w-5 h-5 text-emerald-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                            <a href="{{ route('kunjungans.index') }}" class="flex items-center justify-between p-3 bg-gradient-to-r from-violet-50 to-purple-50 rounded-xl border border-violet-100 hover:border-violet-300 hover:shadow-md transition-all duration-200 group">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-violet-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="font-semibold text-gray-700">Lihat Kunjungan</span>
                                </div>
                                <svg class="w-5 h-5 text-violet-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Stok Menipis Alert -->
                @if($obatMenipis->count() > 0)
                <div class="bg-gradient-to-br from-red-50 to-rose-50 overflow-hidden shadow-xl rounded-2xl border-2 border-red-200">
                    <div class="p-6">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="p-3 bg-gradient-to-br from-red-500 to-rose-600 rounded-2xl shadow-lg shadow-red-500/30 animate-pulse">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-red-800">Stok Menipis!</h4>
                                <p class="text-sm text-red-600">{{ $obatMenipis->count() }} obat perlu restock</p>
                            </div>
                        </div>
                        <div class="space-y-2 max-h-40 overflow-y-auto">
                            @foreach($obatMenipis as $obat)
                                <div class="flex items-center justify-between p-3 bg-white rounded-xl border border-red-100 shadow-sm">
                                    <div class="flex items-center">
                                        <div class="p-2 bg-red-100 rounded-lg mr-3">
                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                            </svg>
                                        </div>
                                        <span class="font-semibold text-gray-800 truncate">{{ $obat->nama_obat }}</span>
                                    </div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold {{ $obat->stok == 0 ? 'bg-red-500 text-white' : 'bg-amber-100 text-amber-700' }}">
                                        {{ $obat->stok == 0 ? 'Habis' : 'Sisa: ' . $obat->stok }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                        <a href="{{ route('obats.index') }}" class="mt-4 inline-flex items-center justify-center w-full px-4 py-2.5 bg-gradient-to-r from-red-500 to-rose-600 rounded-xl text-white font-semibold shadow-lg hover:shadow-xl hover:from-red-600 hover:to-rose-700 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Kelola Stok Obat
                        </a>
                    </div>
                </div>
                @else
                <!-- Rekam Medis Card (shown when no low stock) -->
                <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100 hover:shadow-2xl hover:border-rose-200 transform hover:-translate-y-1 transition-all duration-300">
                    <div class="p-6">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="p-3 bg-gradient-to-br from-rose-500 to-pink-600 rounded-2xl shadow-lg shadow-rose-500/30">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-900">Rekam Medis</h4>
                                <p class="text-sm text-gray-500">Kelola catatan medis</p>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <a href="{{ route('rekam_medis.index') }}" class="flex items-center justify-between p-3 bg-gradient-to-r from-rose-50 to-pink-50 rounded-xl border border-rose-100 hover:border-rose-300 hover:shadow-md transition-all duration-200 group">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-rose-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span class="font-semibold text-gray-700">Lihat Rekam Medis</span>
                                </div>
                                <svg class="w-5 h-5 text-rose-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                            <a href="{{ url('/admin/pembayarans') }}" class="flex items-center justify-between p-3 bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl border border-amber-100 hover:border-amber-300 hover:shadow-md transition-all duration-200 group">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-amber-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <span class="font-semibold text-gray-700">Kelola Pembayaran</span>
                                </div>
                                <svg class="w-5 h-5 text-amber-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>