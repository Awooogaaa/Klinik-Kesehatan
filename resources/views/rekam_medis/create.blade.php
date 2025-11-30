<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Rekam Medis Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900" x-data="resepForm()">
                    
                    <form action="{{ route('rekam-medis.store') }}" method="POST">
                        @csrf
                        
                        <h3 class="font-semibold mb-4">Data Kunjungan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="pasien_id" :value="__('Pasien')" />
                                <select id="pasien_id" name="pasien_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Pilih Pasien</option>
                                    @foreach($pasiens as $pasien)
                                        <option value="{{ $pasien->id }}" @if(old('pasien_id') == $pasien->id) selected @endif>
                                            {{ $pasien->name }} (RM: {{ $pasien->pasien->no_rekam_medis ?? 'N/A' }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('pasien_id')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="dokter_id" :value="__('Dokter')" />
                                <select id="dokter_id" name="dokter_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Pilih Dokter</option>
                                    @foreach($dokters as $dokter)
                                        <option value="{{ $dokter->id }}" @if(old('dokter_id') == $dokter->id) selected @endif>
                                            {{ $dokter->name }} ({{ $dokter->dokter->spesialisasi ?? 'N/A' }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('dokter_id')" class="mt-2" />
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-input-label for="tanggal_kunjungan" :value="__('Tanggal Kunjungan')" />
                            <x-text-input id="tanggal_kunjungan" class="block mt-1 w-full" type="datetime-local" name="tanggal_kunjungan" :value="old('tanggal_kunjungan')" required />
                            <x-input-error :messages="$errors->get('tanggal_kunjungan')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="keluhan" :value="__('Keluhan')" />
                            <textarea id="keluhan" name="keluhan" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('keluhan') }}</textarea>
                            <x-input-error :messages="$errors->get('keluhan')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="diagnosa" :value="__('Diagnosa')" />
                            <textarea id="diagnosa" name="diagnosa" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('diagnosa') }}</textarea>
                            <x-input-error :messages="$errors->get('diagnosa')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="tindakan" :value="__('Tindakan (Opsional)')" />
                            <textarea id="tindakan" name="tindakan" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('tindakan') }}</textarea>
                            <x-input-error :messages="$errors->get('tindakan')" class="mt-2" />
                        </div>

                        <h3 class="font-semibold mt-8 mb-4">Resep Obat</h3>
                        <div class="space-y-4">
                            
                            <template x-for="(resep, index) in reseps" :key="'resep-' + index">
                                <div class="flex items-end space-x-4 border p-4 rounded-md">
                                    <div class="flex-1">
                                        <x-input-label :value="__('Obat')" />
                                        <select :name="'obats[' + index + '][obat_id]'" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            <option value="">Pilih Obat</option>
                                            @foreach($obats as $obat)
                                                <option value="{{ $obat->id }}">{{ $obat->nama_obat }} (Stok: {{ $obat->stok }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="w-1/4">
                                        <x-input-label :value="__('Jumlah')" />
                                        <x-text-input type="number" :name="'obats[' + index + '][jumlah]'" class="block mt-1 w-full" x-model="resep.jumlah" min="1" />
                                    </div>
                                    <div class="flex-1">
                                        <x-input-label :value="__('Dosis (Cth: 3x1 sehari)')" />
                                        <x-text-input type="text" :name="'obats[' + index + '][dosis]'" class="block mt-1 w-full" x-model="resep.dosis" />
                                    </div>
                                    <button type="button" @@click="removeResep(index)" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-500">-</button>
                                </div>
                            </template>
                        </div>
                        <button type="button" @@click="addResep()" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-500">
    + Tambah Obat
</button>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('rekam-medis.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                                Batal
                            </a>
                            <x-primary-button>
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    @verbatim
    <script>
        function resepForm() {
            return {
                reseps: [],
                addResep() {
                    this.reseps.push({
                        obat_id: '',
                        jumlah: 1,
                        dosis: ''
                    });
                },
                removeResep(index) {
                    this.reseps.splice(index, 1);
                }
            }
        }
    </script>
    @endverbatim
</x-app-layout>