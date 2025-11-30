<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Rekam Medis') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('rekam_medis.update', $rekamMedis) }}" method="POST"
                          x-data="resepForm(@json($rekamMedis->obats->map(fn($o) => ['obat_id' => $o->id, 'jumlah' => $o->pivot->jumlah, 'dosis' => $o->pivot->dosis])))">
                        @csrf
                        @method('PUT')
                        
                        <div class="bg-gray-100 p-4 rounded mb-6 grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs text-gray-500 uppercase">Pasien</label>
                                <p class="font-bold">{{ $rekamMedis->pasien->nama }}</p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 uppercase">Dokter</label>
                                <p class="font-bold">{{ $rekamMedis->dokter->user->name }}</p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 uppercase">Tanggal Kunjungan</label>
                                <p class="font-bold">{{ $rekamMedis->kunjungan->waktu_kunjungan->format('d M Y H:i') }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="keluhan" :value="__('Keluhan')" />
                                <textarea id="keluhan" name="keluhan" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" rows="4" required>{{ old('keluhan', $rekamMedis->keluhan) }}</textarea>
                            </div>
                            <div>
                                <x-input-label for="diagnosa" :value="__('Diagnosa')" />
                                <textarea id="diagnosa" name="diagnosa" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" rows="4" required>{{ old('diagnosa', $rekamMedis->diagnosa) }}</textarea>
                            </div>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="tindakan" :value="__('Tindakan')" />
                            <textarea id="tindakan" name="tindakan" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" rows="2">{{ old('tindakan', $rekamMedis->tindakan) }}</textarea>
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
                                            <label class="text-sm text-gray-600">Dosis</label>
                                            <input type="text" :name="'obats['+index+'][dosis]'" x-model="resep.dosis" class="block w-full border-gray-300 rounded-md text-sm" required>
                                        </div>
                                        <button type="button" @click="removeResep(index)" class="text-red-600 hover:text-red-800 font-bold px-2">X</button>
                                    </div>
                                </template>
                            </div>
                            <button type="button" @click="addResep()" class="mt-3 text-sm text-blue-600 font-bold hover:underline">+ Tambah Obat</button>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('rekam_medis.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                            <x-primary-button>{{ __('Update Data') }}</x-primary-button>
                        </div>
                    </form>

                    <script>
                        function resepForm(existingReseps = []) {
                            return {
                                reseps: existingReseps,
                                addResep() { this.reseps.push({ obat_id: '', jumlah: 1, dosis: '' }); },
                                removeResep(index) { this.reseps.splice(index, 1); }
                            }
                        }
                    </script>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>