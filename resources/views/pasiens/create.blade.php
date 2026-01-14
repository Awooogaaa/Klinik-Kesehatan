<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('pasiens.index') }}" class="p-2 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div class="p-2 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-xl shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    {{ __('Tambah Pasien Baru') }}
                </h2>
                <p class="text-sm text-gray-500">Daftarkan pasien baru ke sistem</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                <!-- Card Header -->
                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-teal-500 to-cyan-600">
                    <div class="flex items-center space-x-3">
                        <div class="bg-white/20 p-2 rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white">Formulir Pasien Baru</h3>
                            <p class="text-teal-100 text-sm">Lengkapi data pasien dan akun (opsional)</p>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <form action="{{ route('pasiens.store') }}" method="POST" class="space-y-8">
                        @csrf
                        
                        <!-- Section 1: Data Pribadi Pasien -->
                        <div>
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="p-2 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-xl shadow">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-lg text-gray-800">1. Data Pribadi Pasien</h3>
                                    <p class="text-sm text-gray-500">Informasi dasar pasien</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-6 rounded-2xl">
                                <div class="group">
                                    <label for="nama" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                        <svg class="w-4 h-4 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        Nama Lengkap <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required autofocus
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 bg-white"
                                        placeholder="Nama lengkap pasien">
                                    @error('nama')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="group">
                                    <label for="no_telepon" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        No. Telepon <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}" required
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 bg-white"
                                        placeholder="08xxxxxxxxxx">
                                    @error('no_telepon')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="group">
                                    <label for="tanggal_lahir" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                        <svg class="w-4 h-4 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Tanggal Lahir <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 bg-white">
                                    @error('tanggal_lahir')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="group">
                                    <label for="jenis_kelamin" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                        <svg class="w-4 h-4 mr-2 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                        </svg>
                                        Jenis Kelamin <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <div class="grid grid-cols-2 gap-3">
                                        <label class="relative cursor-pointer">
                                            <input type="radio" name="jenis_kelamin" value="Laki-laki" class="peer sr-only" @if(old('jenis_kelamin') == 'Laki-laki') checked @endif required>
                                            <div class="p-4 border-2 border-gray-200 rounded-xl text-center transition-all duration-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-gray-300 hover:bg-gray-50">
                                                <div class="w-10 h-10 mx-auto mb-2 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                    </svg>
                                                </div>
                                                <span class="text-sm font-medium text-gray-700">Laki-laki</span>
                                            </div>
                                        </label>
                                        <label class="relative cursor-pointer">
                                            <input type="radio" name="jenis_kelamin" value="Perempuan" class="peer sr-only" @if(old('jenis_kelamin') == 'Perempuan') checked @endif>
                                            <div class="p-4 border-2 border-gray-200 rounded-xl text-center transition-all duration-200 peer-checked:border-pink-500 peer-checked:bg-pink-50 hover:border-gray-300 hover:bg-gray-50">
                                                <div class="w-10 h-10 mx-auto mb-2 bg-pink-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                    </svg>
                                                </div>
                                                <span class="text-sm font-medium text-gray-700">Perempuan</span>
                                            </div>
                                        </label>
                                    </div>
                                    @error('jenis_kelamin')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2 group">
                                    <label for="alamat" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                        <svg class="w-4 h-4 mr-2 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        Alamat Lengkap
                                    </label>
                                    <textarea id="alamat" name="alamat" rows="3"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 bg-white resize-none"
                                        placeholder="Alamat lengkap pasien...">{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Akun Keluarga / Login (Opsional) -->
                        <div>
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="p-2 bg-gradient-to-br from-violet-500 to-purple-600 rounded-xl shadow">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-lg text-gray-800">2. Akun Keluarga / Login</h3>
                                    <p class="text-sm text-gray-500">Opsional - untuk akses portal pasien</p>
                                </div>
                            </div>
                            
                            <!-- Info Box -->
                            <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 bg-blue-500 rounded-lg p-1.5 mr-3">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div class="text-sm text-blue-800">
                                        <p class="font-semibold mb-1">Informasi:</p>
                                        <ul class="space-y-1">
                                            <li class="flex items-center">
                                                <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                                Jika email <strong>BELUM</strong> terdaftar: Sistem akan membuatkan akun baru
                                            </li>
                                            <li class="flex items-center">
                                                <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                                Jika email <strong>SUDAH</strong> terdaftar: Pasien ini akan otomatis <strong>ditambahkan ke akun keluarga</strong>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-6 rounded-2xl">
                                <div class="group">
                                    <label for="email" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                        <svg class="w-4 h-4 mr-2 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        Email Akun
                                    </label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all duration-200 bg-white"
                                        placeholder="Masukkan email Kepala Keluarga / Pribadi">
                                    @error('email')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="space-y-4">
                                    <div class="group">
                                        <label for="password" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                            <svg class="w-4 h-4 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                            </svg>
                                            Password
                                        </label>
                                        <input type="password" id="password" name="password"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all duration-200 bg-white"
                                            placeholder="Isi HANYA jika ini akun baru">
                                        @error('password')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div class="group">
                                        <label for="password_confirmation" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                            <svg class="w-4 h-4 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                            </svg>
                                            Konfirmasi Password
                                        </label>
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all duration-200 bg-white">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('pasiens.index') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-teal-500 to-cyan-600 rounded-xl text-white font-semibold shadow-lg shadow-teal-500/30 hover:shadow-xl hover:shadow-teal-500/40 hover:from-teal-600 hover:to-cyan-700 transform hover:-translate-y-0.5 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Simpan Pasien
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>