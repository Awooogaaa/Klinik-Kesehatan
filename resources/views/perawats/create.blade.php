<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('perawats.index') }}" class="p-2 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div class="p-2 bg-gradient-to-br from-pink-500 to-rose-600 rounded-xl shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    {{ __('Tambah Perawat Baru') }}
                </h2>
                <p class="text-sm text-gray-500">Buat akun dan profil perawat baru</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                <div class="p-8">
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('perawats.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Section: Data Akun -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <div class="p-2 bg-pink-100 rounded-lg mr-3">
                                    <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                Data Akun Login
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all"
                                        placeholder="Nama lengkap perawat">
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all"
                                        placeholder="email@example.com">
                                </div>
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password <span class="text-red-500">*</span></label>
                                    <input type="password" id="password" name="password" required
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all"
                                        placeholder="Minimal 8 karakter">
                                </div>
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password <span class="text-red-500">*</span></label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" required
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all"
                                        placeholder="Ulangi password">
                                </div>
                            </div>
                        </div>

                        <!-- Section: Data Profil -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <div class="p-2 bg-emerald-100 rounded-lg mr-3">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                Data Profil Perawat
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-2">No. Telepon <span class="text-red-500">*</span></label>
                                    <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}" required
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all"
                                        placeholder="08xxxxxxxxxx">
                                </div>
                                <div>
                                    <label for="foto" class="block text-sm font-medium text-gray-700 mb-2">Foto Profil</label>
                                    <input type="file" id="foto" name="foto" accept="image/*"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all">
                                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Maks 2MB</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                                    <textarea id="alamat" name="alamat" rows="3"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all"
                                        placeholder="Alamat lengkap perawat">{{ old('alamat') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Section: Penugasan Dokter -->
                        <div class="pb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <div class="p-2 bg-violet-100 rounded-lg mr-3">
                                    <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                Penugasan Dokter (Opsional)
                            </h3>
                            <div class="bg-amber-50 border border-amber-200 rounded-xl p-3 mb-4">
                                <p class="text-sm text-amber-700 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Perawat hanya dapat membantu <strong>1 dokter</strong>. Pilih satu dokter di bawah ini.
                                </p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                <!-- Opsi tidak memilih dokter -->
                                <label class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-200 hover:border-pink-300 hover:bg-pink-50 cursor-pointer transition-all group">
                                    <input type="radio" name="dokter_id" value="" 
                                        {{ old('dokter_id') === null ? 'checked' : '' }}
                                        class="w-5 h-5 border-gray-300 text-pink-600 focus:ring-pink-500">
                                    <div class="ml-3">
                                        <p class="font-medium text-gray-500 group-hover:text-pink-600 transition">Tidak memilih dokter</p>
                                        <p class="text-xs text-gray-400">Dapat ditugaskan nanti</p>
                                    </div>
                                </label>
                                @foreach($dokters as $dokter)
                                    <label class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-200 hover:border-pink-300 hover:bg-pink-50 cursor-pointer transition-all group">
                                        <input type="radio" name="dokter_id" value="{{ $dokter->id }}" 
                                            {{ old('dokter_id') == $dokter->id ? 'checked' : '' }}
                                            class="w-5 h-5 border-gray-300 text-pink-600 focus:ring-pink-500">
                                        <div class="ml-3">
                                            <p class="font-medium text-gray-900 group-hover:text-pink-600 transition">Dr. {{ $dokter->user->name ?? '-' }}</p>
                                            <p class="text-xs text-gray-500">{{ $dokter->spesialisasi }}</p>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @if($dokters->isEmpty())
                                <p class="text-sm text-gray-400 italic">Belum ada dokter terdaftar.</p>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                            <a href="{{ route('perawats.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold text-sm hover:bg-gray-200 transition-all">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-pink-500 to-rose-600 text-white rounded-xl font-semibold text-sm shadow-lg shadow-pink-500/30 hover:shadow-xl hover:from-pink-600 hover:to-rose-700 transform hover:-translate-y-0.5 transition-all">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Simpan Perawat
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
