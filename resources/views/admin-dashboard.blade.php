<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold">Selamat Datang, Admin!</h3>
                    <p>Anda memiliki akses penuh untuk mengelola User, Dokter, dan Pasien.</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                <h4 class="font-bold text-gray-800 mb-6">Statistik Kunjungan Pasien ({{ date('Y') }})</h4>
                
                <div class="flex items-end space-x-2 sm:space-x-4 h-64 border-b-2 border-gray-200 pb-2">
                    
                    @foreach($chartData as $data)
                        <div class="flex-1 flex flex-col justify-end items-center group relative h-full">
                            
                            <div class="absolute bottom-full mb-2 hidden group-hover:block z-10">
                                <span class="bg-gray-800 text-white text-xs rounded py-1 px-2 whitespace-nowrap shadow-lg">
                                    {{ $data['count'] }} Pasien
                                </span>
                            </div>

                            @if($data['count'] > 0)
                                <span class="text-xs text-gray-500 mb-1 font-semibold">{{ $data['count'] }}</span>
                            @endif

                            <div class="w-full bg-blue-500 hover:bg-blue-600 rounded-t-sm transition-all duration-300"
                                 style="height: {{ $maxKunjungan > 0 ? ($data['count'] / $maxKunjungan) * 100 : 0 }}%;">
                            </div>
                            
                            <div class="text-xs text-gray-500 mt-2 font-medium">{{ $data['label'] }}</div>
                        </div>
                    @endforeach

                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                
                <div class="bg-blue-100 p-6 rounded-lg shadow-sm">
                    <h4 class="font-bold text-blue-800">Manajemen Pengguna</h4>
                    <ul class="mt-2 list-disc list-inside">
                        <li><a href="{{ route('dokters.index') }}" class="text-blue-600 hover:underline">Kelola Data Dokter</a></li>
                        <li><a href="{{ route('pasiens.index') }}" class="text-blue-600 hover:underline">Kelola Data Pasien</a></li>
                    </ul>
                </div>

                <div class="bg-green-100 p-6 rounded-lg shadow-sm">
                    <h4 class="font-bold text-green-800">Layanan Klinik</h4>
                    <ul class="mt-2 list-disc list-inside">
                        <li><a href="{{ route('obats.index') }}" class="text-green-600 hover:underline">Kelola Obat</a></li>
                        <li><a href="{{ route('kunjungans.index') }}" class="text-green-600 hover:underline">Lihat Kunjungan</a></li>
                    </ul>
                </div>

                @if($obatMenipis->count() > 0)
                <div class="bg-red-50 border border-red-200 p-6 rounded-lg shadow-sm">
                    <div class="flex items-start mb-2">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div class="ml-2">
                            <h4 class="font-bold text-red-800">Stok Menipis!</h4>
                        </div>
                    </div>
                    
                    <p class="text-sm text-red-700 mb-3">
                        Ada <strong>{{ $obatMenipis->count() }} obat</strong> stok < 10.
                    </p>

                    <div class="space-y-2">
                        @foreach($obatMenipis as $obat)
                            <div class="bg-white p-2 rounded border border-red-100 text-sm flex justify-between items-center">
                                <span class="font-semibold text-gray-800 truncate pr-2">{{ $obat->nama_obat }}</span>
                                <span class="text-red-600 font-bold whitespace-nowrap">Sisa: {{ $obat->stok }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>