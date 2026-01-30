<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-gradient-to-br from-pink-500 to-rose-600 rounded-xl shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    Dashboard Perawat
                </h2>
                <p class="text-sm text-gray-500">Selamat datang, {{ Auth::user()->name }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Card with Date & Time -->
            <div class="bg-gradient-to-r from-pink-500 via-rose-500 to-red-500 overflow-hidden shadow-xl rounded-2xl mb-6">
                <div class="p-8">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-5">
                            <div class="h-16 w-16 rounded-2xl bg-white/20 flex items-center justify-center shadow-xl border-4 border-white/30">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-white">Halo, {{ Auth::user()->name }}</h3>
                                <p class="text-pink-100 mt-1">Selamat bertugas! Semoga hari Anda menyenangkan.</p>
                            </div>
                        </div>
                        <div class="hidden md:block text-right">
                            <p id="perawat-date" class="text-pink-100 text-sm"></p>
                            <p id="perawat-time" class="text-white text-2xl font-bold"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gradient-to-br from-pink-500 to-rose-600 rounded-2xl p-6 text-white shadow-xl shadow-pink-500/30 transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-pink-100 text-sm font-medium">Dokter yang Dibantu</p>
                            <p class="text-4xl font-bold mt-2">{{ $perawat->dokters->count() }}</p>
                        </div>
                        <div class="bg-white/20 p-4 rounded-xl">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-6 text-white shadow-xl shadow-emerald-500/30 transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-emerald-100 text-sm font-medium">Rekam Medis Hari Ini</p>
                            <p class="text-4xl font-bold mt-2">{{ $totalRekamMedisHariIni }}</p>
                        </div>
                        <div class="bg-white/20 p-4 rounded-xl">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl p-6 text-white shadow-xl shadow-amber-500/30 transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-amber-100 text-sm font-medium">Kunjungan Menunggu</p>
                            <p class="text-4xl font-bold mt-2">{{ $totalKunjunganMenunggu }}</p>
                        </div>
                        <div class="bg-white/20 p-4 rounded-xl">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dokter yang Dibantu -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 mb-8">
                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-pink-500 to-rose-600 rounded-t-2xl">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-white">Dokter yang Anda Bantu</h3>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse($perawat->dokters as $dokter)
                            <div class="flex items-center p-4 bg-gradient-to-r from-gray-50 to-white rounded-xl border border-gray-100 hover:border-pink-200 hover:shadow-lg transition-all group">
                                @if($dokter->foto)
                                    <img src="{{ asset('storage/' . $dokter->foto) }}" alt="Foto" class="w-14 h-14 rounded-xl object-cover border-2 border-pink-200">
                                @else
                                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-pink-400 to-rose-500 flex items-center justify-center text-white font-bold text-xl">
                                        {{ substr($dokter->user->name ?? 'D', 0, 1) }}
                                    </div>
                                @endif
                                <div class="ml-4">
                                    <p class="font-bold text-gray-900 group-hover:text-pink-600 transition">Dr. {{ $dokter->user->name ?? '-' }}</p>
                                    <p class="text-sm text-gray-500">{{ $dokter->spesialisasi }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 text-center py-8 text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <p>Anda belum ditugaskan ke dokter manapun.</p>
                                <p class="text-sm text-gray-400">Hubungi admin untuk penugasan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <a href="{{ route('rekam_medis.create') }}" class="block bg-white rounded-2xl shadow-xl border border-gray-100 p-6 hover:shadow-2xl hover:border-pink-200 transition-all group">
                    <div class="flex items-center">
                        <div class="p-4 bg-gradient-to-br from-pink-500 to-rose-600 rounded-xl shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </div>
                        <div class="ml-5">
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-pink-600 transition">Input Rekam Medis</h3>
                            <p class="text-sm text-gray-500">Buat rekam medis baru untuk pasien</p>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('rekam_medis.index') }}" class="block bg-white rounded-2xl shadow-xl border border-gray-100 p-6 hover:shadow-2xl hover:border-emerald-200 transition-all group">
                    <div class="flex items-center">
                        <div class="p-4 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div class="ml-5">
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-emerald-600 transition">Lihat Rekam Medis</h3>
                            <p class="text-sm text-gray-500">Daftar rekam medis pasien</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Kunjungan Perlu Input -->
            @if($kunjungansPerluInput->count() > 0)
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100">
                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-amber-500 to-orange-600 rounded-t-2xl">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-white">Kunjungan Perlu Input Rekam Medis</h3>
                    </div>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Pasien</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Dokter</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Keluhan</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-600 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($kunjungansPerluInput as $kunjungan)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <p class="font-semibold text-gray-900">{{ $kunjungan->pasien->nama ?? '-' }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-gray-700">Dr. {{ $kunjungan->dokter->user->name ?? '-' }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-gray-600 truncate max-w-xs">{{ Str::limit($kunjungan->keluhan_awal, 50) }}</p>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('rekam_medis.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-pink-500 to-rose-600 text-white text-sm font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                </svg>
                                                Input
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <script>
        function updateDateTime(dateId, timeId) {
            const now = new Date();
            
            // Format tanggal: Jumat, 30 Januari 2026
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                           'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            
            const dayName = days[now.getDay()];
            const date = now.getDate();
            const monthName = months[now.getMonth()];
            const year = now.getFullYear();
            
            const dateStr = `${dayName}, ${date} ${monthName} ${year}`;
            
            // Format waktu: 10:00:58 WIB
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const timeStr = `${hours}:${minutes}:${seconds} WIB`;
            
            document.getElementById(dateId).textContent = dateStr;
            document.getElementById(timeId).textContent = timeStr;
        }
        
        // Update setiap detik
        updateDateTime('perawat-date', 'perawat-time');
        setInterval(() => updateDateTime('perawat-date', 'perawat-time'), 1000);
    </script>
</x-app-layout>
