<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('perawats.index') }}" class="p-2 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div class="p-2 bg-gradient-to-br from-violet-500 to-purple-600 rounded-xl shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    Tugaskan Dokter ke {{ $perawat->user->name ?? 'Perawat' }}
                </h2>
                <p class="text-sm text-gray-500">Pilih dokter yang akan dibantu oleh perawat ini</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                <!-- Perawat Info Card -->
                <div class="bg-gradient-to-r from-pink-500 to-rose-600 p-6">
                    <div class="flex items-center">
                        @if($perawat->foto)
                            <img src="{{ asset('storage/' . $perawat->foto) }}" alt="Foto" class="w-20 h-20 rounded-2xl object-cover border-4 border-white/30 shadow-xl">
                        @else
                            <div class="w-20 h-20 rounded-2xl bg-white/20 flex items-center justify-center text-white font-bold text-3xl shadow-xl border-4 border-white/30">
                                {{ substr($perawat->user->name ?? 'P', 0, 1) }}
                            </div>
                        @endif
                        <div class="ml-5 text-white">
                            <h3 class="text-2xl font-bold">{{ $perawat->user->name ?? '-' }}</h3>
                            <p class="text-pink-100">{{ $perawat->user->email ?? '-' }}</p>
                            <p class="text-pink-200 text-sm mt-1">{{ $perawat->no_telepon ?? '-' }}</p>
                        </div>
                    </div>
                </div>

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

                    <form method="POST" action="{{ route('perawats.assign.store', $perawat) }}" class="space-y-6">
                        @csrf

                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Pilih Dokter yang Akan Dibantu
                            </h3>
                            <div class="bg-amber-50 border border-amber-200 rounded-xl p-3 mb-4">
                                <p class="text-sm text-amber-700 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Perawat hanya dapat membantu <strong>1 dokter</strong>. Pilih satu dokter di bawah ini.
                                </p>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Opsi tidak memilih dokter -->
                                <label class="flex items-center p-4 bg-gray-50 rounded-xl border-2 border-gray-200 hover:border-violet-300 hover:bg-violet-50 cursor-pointer transition-all group {{ !$perawat->dokter_id ? 'border-violet-500 bg-violet-50' : '' }}">
                                    <input type="radio" name="dokter_id" value="" 
                                        {{ !$perawat->dokter_id ? 'checked' : '' }}
                                        class="w-5 h-5 border-gray-300 text-violet-600 focus:ring-violet-500">
                                    <div class="ml-4 flex items-center flex-1">
                                        <div class="w-12 h-12 rounded-xl bg-gray-300 flex items-center justify-center text-gray-500 font-bold text-lg">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="font-semibold text-gray-500 group-hover:text-violet-600 transition">Tidak ada dokter</p>
                                            <p class="text-sm text-gray-400">Dapat ditugaskan nanti</p>
                                        </div>
                                    </div>
                                </label>
                                @foreach($dokters as $dokter)
                                    <label class="flex items-center p-4 bg-gray-50 rounded-xl border-2 border-gray-200 hover:border-violet-300 hover:bg-violet-50 cursor-pointer transition-all group {{ $perawat->dokter_id == $dokter->id ? 'border-violet-500 bg-violet-50' : '' }}">
                                        <input type="radio" name="dokter_id" value="{{ $dokter->id }}" 
                                            {{ $perawat->dokter_id == $dokter->id ? 'checked' : '' }}
                                            class="w-5 h-5 border-gray-300 text-violet-600 focus:ring-violet-500">
                                        <div class="ml-4 flex items-center flex-1">
                                            @if($dokter->foto)
                                                <img src="{{ asset('storage/' . $dokter->foto) }}" alt="Foto" class="w-12 h-12 rounded-xl object-cover border-2 border-violet-200">
                                            @else
                                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-violet-400 to-purple-500 flex items-center justify-center text-white font-bold text-lg">
                                                    {{ substr($dokter->user->name ?? 'D', 0, 1) }}
                                                </div>
                                            @endif
                                            <div class="ml-3">
                                                <p class="font-semibold text-gray-900 group-hover:text-violet-600 transition">Dr. {{ $dokter->user->name ?? '-' }}</p>
                                                <p class="text-sm text-gray-500">{{ $dokter->spesialisasi }}</p>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            
                            @if($dokters->isEmpty())
                                <p class="text-sm text-gray-400 italic text-center py-8">Belum ada dokter terdaftar.</p>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                            <a href="{{ route('perawats.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold text-sm hover:bg-gray-200 transition-all">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-violet-500 to-purple-600 text-white rounded-xl font-semibold text-sm shadow-lg shadow-violet-500/30 hover:shadow-xl hover:from-violet-600 hover:to-purple-700 transform hover:-translate-y-0.5 transition-all">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Simpan Penugasan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
