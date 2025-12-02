<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Pemeriksaan Baru') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if($kunjungans->isEmpty())
                        <div class="bg-yellow-50 p-4 rounded text-yellow-700">
                            Tidak ada antrian pasien (Status: Disetujui). Silakan atur jadwal kunjungan dulu.
                        </div>
                    @else
                        <form action="{{ route('rekam_medis.store') }}" method="POST" x-data="resepForm()">
                            @csrf
                            
                            <div class="mb-6 bg-blue-50 p-4 rounded-lg border border-blue-100">
                                <x-input-label for="kunjungan_id" :value="__('Pilih Antrian Pasien')" />
                                <select name="kunjungan_id" id="kunjungan_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required onchange="fillKeluhan()">
                                    <option value="">-- Pilih --</option>
                                    @foreach($kunjungans as $k)
                                        <option value="{{ $k->id }}" data-keluhan="{{ $k->keluhan_awal }}">
                                            Jam {{ $k->waktu_kunjungan->format('H:i') }} - {{ $k->pasien->nama }} (Dr. {{ $k->dokter->user->name }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="keluhan" :value="__('Keluhan Pasien')" />
                                    <textarea id="keluhan" name="keluhan" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" rows="4" required></textarea>
                                </div>
                                <div>
                                    <x-input-label for="diagnosa" :value="__('Diagnosa Dokter')" />
                                    <textarea id="diagnosa" name="diagnosa" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" rows="4" required></textarea>
                                </div>
                            </div>

                            <div class="mt-4">
                                <x-input-label for="tindakan" :value="__('Tindakan Medis')" />
                                <textarea id="tindakan" name="tindakan" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" rows="2"></textarea>
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

                        <script>
                            function fillKeluhan() {
                                var select = document.getElementById('kunjungan_id');
                                var keluhan = select.options[select.selectedIndex].getAttribute('data-keluhan');
                                document.getElementById('keluhan').value = keluhan ? keluhan : '';
                            }

                            function resepForm() {
                                return {
                                    reseps: [],
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