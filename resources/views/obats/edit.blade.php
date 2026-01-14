<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('obats.index') }}" class="p-2 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200">
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
                    {{ __('Edit Obat') }}
                </h2>
                <p class="text-sm text-gray-500">Perbarui data obat: {{ $obat->nama_obat }}</p>
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white">Edit Data Obat</h3>
                                <p class="text-blue-100 text-sm">ID: #{{ str_pad($obat->id, 4, '0', STR_PAD_LEFT) }}</p>
                            </div>
                        </div>
                        <div class="hidden sm:flex items-center space-x-2 bg-white/10 px-4 py-2 rounded-xl">
                            @if($obat->stok == 0)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-500 text-white">
                                    Stok Habis
                                </span>
                            @elseif($obat->stok <= 10)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-400 text-white">
                                    Stok Menipis
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-400 text-white">
                                    Stok Tersedia
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <form action="{{ route('obats.update', $obat) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <!-- Nama Obat -->
                        <div class="group">
                            <label for="nama_obat" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                </svg>
                                Nama Obat
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="text" id="nama_obat" name="nama_obat" value="{{ old('nama_obat', $obat->nama_obat) }}" required autofocus
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 hover:bg-white focus:bg-white"
                                placeholder="Masukkan nama obat...">
                            @error('nama_obat')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Satuan -->
                        <div class="group">
                            <label for="satuan" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                Satuan
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="text" id="satuan" name="satuan" value="{{ old('satuan', $obat->satuan) }}" required
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 hover:bg-white focus:bg-white"
                                placeholder="tablet, botol, strip, kapsul...">
                            <p class="mt-2 text-xs text-gray-500 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Contoh: tablet, botol, strip, kapsul, ampul
                            </p>
                            @error('satuan')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Grid for Stok and Harga -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Stok -->
                            <div class="group">
                                <label for="stok" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                    <svg class="w-4 h-4 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    Stok
                                    <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" id="stok" name="stok" value="{{ old('stok', $obat->stok) }}" required min="0"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 hover:bg-white focus:bg-white"
                                        placeholder="0">
                                    @if($obat->stok <= 10 && $obat->stok > 0)
                                        <span class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                            </svg>
                                        </span>
                                    @elseif($obat->stok == 0)
                                        <span class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                            </svg>
                                        </span>
                                    @endif
                                </div>
                                @if($obat->stok <= 10)
                                    <p class="mt-2 text-xs {{ $obat->stok == 0 ? 'text-red-600' : 'text-amber-600' }} flex items-center font-medium">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                        {{ $obat->stok == 0 ? 'Stok habis! Segera restok.' : 'Peringatan: Stok menipis!' }}
                                    </p>
                                @endif
                                @error('stok')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Harga -->
                            <div class="group">
                                <label for="harga" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Harga (Rp)
                                    <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                                    <input type="number" id="harga" name="harga" value="{{ old('harga', $obat->harga) }}" required min="0"
                                        class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 hover:bg-white focus:bg-white"
                                        placeholder="0">
                                </div>
                                @error('harga')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                            <form action="{{ route('obats.destroy', $obat) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus obat {{ $obat->nama_obat }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2.5 border border-red-200 rounded-xl text-red-600 font-medium hover:bg-red-50 hover:border-red-300 transition-all duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Hapus Obat
                                </button>
                            </form>
                            
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('obats.index') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Batal
                                </a>
                                <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl text-white font-semibold shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:from-blue-600 hover:to-indigo-700 transform hover:-translate-y-0.5 transition-all duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                    </svg>
                                    Update Obat
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Card -->
            <div class="mt-6 bg-gradient-to-r from-gray-50 to-slate-50 border border-gray-200 rounded-2xl p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0 bg-gray-500 rounded-xl p-2">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h4 class="font-semibold text-gray-800">Informasi Obat</h4>
                        <div class="mt-2 text-sm text-gray-600 space-y-1">
                            <p class="flex items-center">
                                <span class="font-medium w-32">Dibuat pada:</span>
                                <span>{{ $obat->created_at->format('d M Y, H:i') }}</span>
                            </p>
                            <p class="flex items-center">
                                <span class="font-medium w-32">Terakhir diubah:</span>
                                <span>{{ $obat->updated_at->format('d M Y, H:i') }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>