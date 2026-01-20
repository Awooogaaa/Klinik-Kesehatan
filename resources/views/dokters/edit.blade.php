<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('dokters.index') }}" class="p-2 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200">
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
                    {{ __('Edit Data Dokter') }}
                </h2>
                <p class="text-sm text-gray-500">Perbarui informasi Dr. {{ $dokter->user->name ?? 'Dokter' }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                <!-- Card Header with Doctor Preview -->
                <div class="px-6 py-6 border-b border-gray-100 bg-gradient-to-r from-blue-500 to-indigo-600">
                    <div class="flex items-center space-x-5">
                        @if($dokter->foto)
                            <img src="{{ asset('storage/' . $dokter->foto) }}" alt="Foto Dokter" class="h-20 w-20 rounded-2xl object-cover border-4 border-white/30 shadow-xl">
                        @else
                            <div class="h-20 w-20 rounded-2xl bg-white/20 flex items-center justify-center text-white font-bold text-3xl shadow-xl border-4 border-white/30">
                                {{ substr($dokter->user->name ?? 'D', 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <h3 class="text-xl font-bold text-white">Dr. {{ $dokter->user->name ?? 'Nama Tidak Tersedia' }}</h3>
                            <span class="inline-flex items-center bg-white/20 text-white text-sm px-3 py-1 rounded-full mt-2 font-medium">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                </svg>
                                {{ $dokter->spesialisasi }}
                            </span>
                            <p class="text-blue-100 text-sm mt-2">ID: #{{ str_pad($dokter->id, 4, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <form action="{{ route('dokters.update', $dokter) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        @method('PUT')
                        
                        <!-- Section 1: Informasi Akun Login -->
                        <div>
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="p-2 bg-gradient-to-br from-violet-500 to-purple-600 rounded-xl shadow">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-lg text-gray-800">1. Informasi Akun Login</h3>
                                    <p class="text-sm text-gray-500">Kredensial untuk login ke sistem</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-6 rounded-2xl">
                                <div class="group">
                                    <label for="name" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                        <svg class="w-4 h-4 mr-2 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        Nama Lengkap <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <input type="text" id="name" name="name" value="{{ old('name', $dokter->user->name) }}" required
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white">
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="group">
                                    <label for="email" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        Email <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <input type="email" id="email" name="email" value="{{ old('email', $dokter->user->email) }}" required
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white">
                                    @error('email')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="group">
                                    <label for="password" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                        <svg class="w-4 h-4 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                        Password Baru <span class="text-gray-400 text-xs ml-1">(Opsional)</span>
                                    </label>
                                    <input type="password" id="password" name="password" placeholder="Isi hanya jika ingin ganti password"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white">
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
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white">
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Profil Lengkap Dokter -->
                        <div>
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="p-2 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl shadow">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-lg text-gray-800">2. Profil Lengkap Dokter</h3>
                                    <p class="text-sm text-gray-500">Informasi profil yang akan ditampilkan</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-6 rounded-2xl">
                                <div class="group">
                                    <label for="spesialisasi" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                        </svg>
                                        Spesialisasi <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <input type="text" id="spesialisasi" name="spesialisasi" value="{{ old('spesialisasi', $dokter->spesialisasi) }}" required
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white">
                                    @error('spesialisasi')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="group">
                                    <label for="no_telepon" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                        <svg class="w-4 h-4 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        No. Telepon <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $dokter->no_telepon) }}" required
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white">
                                    @error('no_telepon')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="md:col-span-2 group">
                                    <label for="foto" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                        <svg class="w-4 h-4 mr-2 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Foto Dokter
                                    </label>
                                    
                                    @if($dokter->foto)
                                        <div id="current-foto" class="mb-4 flex items-center space-x-4 p-4 bg-blue-50 rounded-xl border border-blue-200">
                                            <img src="{{ asset('storage/' . $dokter->foto) }}" alt="Foto Dokter" class="w-20 h-20 object-cover rounded-xl border-2 border-white shadow-md">
                                            <div>
                                                <p class="text-sm font-medium text-blue-800">Foto Saat Ini</p>
                                                <p class="text-xs text-blue-600 mt-1">Upload foto baru untuk mengganti</p>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <!-- New Image Preview -->
                                    <div id="preview-container" class="hidden mb-4 flex items-center space-x-4 p-4 bg-emerald-50 rounded-xl border border-emerald-200">
                                        <img id="preview-image" src="" alt="Preview" class="w-20 h-20 object-cover rounded-xl border-2 border-white shadow-md">
                                        <div>
                                            <p class="text-sm font-medium text-emerald-800">Foto Baru (Preview)</p>
                                            <p id="preview-filename" class="text-xs text-emerald-600 mt-1"></p>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-center w-full">
                                        <label for="foto" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-white hover:bg-gray-50 transition-colors duration-200">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-8 h-8 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                                </svg>
                                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                                                <p class="text-xs text-gray-400">Biarkan kosong jika tidak ingin mengubah foto</p>
                                            </div>
                                            <input id="foto" type="file" name="foto" class="hidden" accept="image/*" onchange="previewImage(this)" />
                                        </label>
                                    </div>
                                    @error('foto')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    
                                    <script>
                                        function previewImage(input) {
                                            const container = document.getElementById('preview-container');
                                            const image = document.getElementById('preview-image');
                                            const filename = document.getElementById('preview-filename');
                                            const currentFoto = document.getElementById('current-foto');
                                            
                                            if (input.files && input.files[0]) {
                                                const reader = new FileReader();
                                                reader.onload = function(e) {
                                                    image.src = e.target.result;
                                                    filename.textContent = input.files[0].name;
                                                    container.classList.remove('hidden');
                                                    if (currentFoto) {
                                                        currentFoto.classList.add('hidden');
                                                    }
                                                }
                                                reader.readAsDataURL(input.files[0]);
                                            }
                                        }
                                    </script>
                                </div>

                                <div class="md:col-span-2 group">
                                    <label for="alamat" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                        <svg class="w-4 h-4 mr-2 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        Alamat Lengkap <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <textarea id="alamat" name="alamat" rows="3" required
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white resize-none">{{ old('alamat', $dokter->alamat) }}</textarea>
                                    @error('alamat')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                            <!-- Delete Button (using JavaScript form submit) -->
                            <button type="button" onclick="if(confirm('Yakin hapus dokter ini? Akun login juga akan terhapus.')) { document.getElementById('delete-form').submit(); }" class="inline-flex items-center px-4 py-2.5 border border-red-200 rounded-xl text-red-600 font-medium hover:bg-red-50 hover:border-red-300 transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Hapus Dokter
                            </button>
                            
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('dokters.index') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Batal
                                </a>
                                <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl text-white font-semibold shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:from-blue-600 hover:to-indigo-700 transform hover:-translate-y-0.5 transition-all duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                    </svg>
                                    Update Dokter
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Hidden Delete Form -->
                    <form id="delete-form" action="{{ route('dokters.destroy', $dokter) }}" method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
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
                        <h4 class="font-semibold text-gray-800">Informasi Data</h4>
                        <div class="mt-2 text-sm text-gray-600 space-y-1">
                            <p class="flex items-center">
                                <span class="font-medium w-32">Dibuat pada:</span>
                                <span>{{ $dokter->created_at->format('d M Y, H:i') }}</span>
                            </p>
                            <p class="flex items-center">
                                <span class="font-medium w-32">Terakhir diubah:</span>
                                <span>{{ $dokter->updated_at->format('d M Y, H:i') }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>