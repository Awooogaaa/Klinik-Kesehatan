<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Pemeriksaan Baru') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- 1. ERROR DITAMPILKAN DI SINI (SEBELUM FORM) --}}
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg relative shadow-sm" role="alert">
                            <strong class="font-bold flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                                Terjadi Kesalahan!
                            </strong>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($kunjungans->isEmpty())
                        <div class="bg-yellow-50 p-4 rounded text-yellow-700">
                            Tidak ada antrian pasien (Status: Disetujui). Silakan atur jadwal kunjungan dulu.
                        </div>
                    @else
                        <form action="{{ route('rekam_medis.store') }}" method="POST" x-data="resepForm()">
                            @csrf
                            
                            <div class="mb-6 bg-blue-50 p-4 rounded-lg border border-blue-100">
                                <x-input-label for="kunjungan_id" :value="__('Pilih Antrian Pasien')" />
                                <select name="kunjungan_id" id="kunjungan_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required onchange="fillKeluhan()">
                                    <option value="">-- Pilih --</option>
                                    @foreach($kunjungans as $k)
                                        <option value="{{ $k->id }}" data-keluhan="{{ $k->keluhan_awal }}" {{ old('kunjungan_id') == $k->id ? 'selected' : '' }}>
                                            Jam {{ $k->waktu_kunjungan->format('H:i') }} - {{ $k->pasien->nama }} (Dr. {{ $k->dokter->user->name }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="keluhan" :value="__('Keluhan Pasien')" />
                                    <textarea id="keluhan" name="keluhan" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" rows="4" required>{{ old('keluhan') }}</textarea>
                                </div>
                                <div>
                                    <x-input-label for="diagnosa" :value="__('Diagnosa Dokter')" />
                                    <textarea id="diagnosa" name="diagnosa" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" rows="4" required>{{ old('diagnosa') }}</textarea>
                                </div>
                            </div>

                            <div class="mt-4">
                                <x-input-label for="tindakan" :value="__('Tindakan Medis')" />
                                <textarea id="tindakan" name="tindakan" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" rows="2">{{ old('tindakan') }}</textarea>
                            </div>

                            <div class="mt-8 border-t pt-6">
                                <h3 class="font-bold text-lg mb-2">Resep Obat</h3>
                                <div class="space-y-3">
                                    <template x-for="(resep, index) in reseps" :key="index">
                                        <div class="flex gap-4 items-end bg-gray-50 p-3 rounded border">
                                            <div class="flex-1">
                                                <label class="text-sm text-gray-600">Nama Obat</label>
                                                <select :name="'obats['+index+'][obat_id]'" x-model="resep.obat_id" class="block w-full border-gray-300 rounded-md text-sm" required>
                                                    <option value="">-- Pilih Obat --</option>
                                                    @foreach($obats as $obat)
                                                        <option value="{{ $obat->id }}">{{ $obat->nama_obat }} (Stok: {{ $obat->stok }})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="w-24">
                                                <label class="text-sm text-gray-600">Jumlah</label>
                                                <input type="number" :name="'obats['+index+'][jumlah]'" x-model="resep.jumlah" class="block w-full border-gray-300 rounded-md text-sm" min="1" required>
                                            </div>
                                            <div class="flex-1">
                                                <label class="text-sm text-gray-600">Dosis (e.g. 3x1)</label>
                                                <input type="text" :name="'obats['+index+'][dosis]'" x-model="resep.dosis" class="block w-full border-gray-300 rounded-md text-sm" required>
                                            </div>
                                            <button type="button" @click="removeResep(index)" class="text-red-600 hover:text-red-800 font-bold px-2">X</button>
                                        </div>
                                    </template>
                                </div>
                                <button type="button" @click="addResep()" class="mt-3 text-sm text-blue-600 font-bold hover:underline">+ Tambah Obat</button>
                            </div>

                            <div class="flex justify-end mt-6">
                                <x-primary-button>Simpan Rekam Medis</x-primary-button>
                            </div>
                        </form>

                        {{-- 2. SCRIPT JAVASCRIPT BERSIH DARI HTML --}}
                        <script>
                            function fillKeluhan() {
                                var select = document.getElementById('kunjungan_id');
                                var keluhan = select.options[select.selectedIndex].getAttribute('data-keluhan');
                                document.getElementById('keluhan').value = keluhan ? keluhan : '';
                            }

                            function resepForm() {
                                return {
                                    reseps: [], // Bisa diisi default jika perlu
                                    addResep() { this.reseps.push({ obat_id: '', jumlah: 1, dosis: '' }); },
                                    removeResep(index) { this.reseps.splice(index, 1); }
                                }
                            }
                        </script>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>