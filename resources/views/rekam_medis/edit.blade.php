<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Rekam Medis') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Form mengarah ke route update --}}
                    <form action="{{ route('rekam_medis.update', $rekamMedis->id) }}" method="POST"
                          x-data="resepForm({{ json_encode($rekamMedis->obats->map(function($item) {
                              return [
                                  'obat_id' => $item->id,
                                  'jumlah' => $item->pivot->jumlah,
                                  'dosis' => $item->pivot->dosis
                              ];
                          })) }})">
                        @csrf
                        @method('PUT')
                        
                        <div class="bg-blue-50 p-4 rounded-lg mb-6 grid grid-cols-2 gap-4 border border-blue-100">
                            <div>
                                <label class="text-xs text-blue-500 uppercase font-bold">Pasien</label>
                                <p class="font-semibold text-gray-800">{{ $rekamMedis->pasien->nama }}</p>
                            </div>
                            <div>
                                <label class="text-xs text-blue-500 uppercase font-bold">Dokter</label>
                                <p class="font-semibold text-gray-800">{{ $rekamMedis->dokter->user->name }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                            <div>
                                <x-input-label for="keluhan" :value="__('Keluhan')" />
                                <textarea id="keluhan" name="keluhan" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" rows="3" required>{{ old('keluhan', $rekamMedis->keluhan) }}</textarea>
                            </div>
                            <div>
                                <x-input-label for="diagnosa" :value="__('Diagnosa')" />
                                <textarea id="diagnosa" name="diagnosa" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" rows="3" required>{{ old('diagnosa', $rekamMedis->diagnosa) }}</textarea>
                            </div>
                        </div>

                        <div class="mb-6">
                            <x-input-label for="tindakan" :value="__('Tindakan')" />
                            <textarea id="tindakan" name="tindakan" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" rows="2">{{ old('tindakan', $rekamMedis->tindakan) }}</textarea>
                        </div>

                        <div class="border-t pt-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="font-bold text-lg text-gray-800">Resep Obat</h3>
                                <button type="button" @click="addResep()" class="text-sm bg-blue-100 text-blue-700 px-3 py-1 rounded hover:bg-blue-200 font-semibold transition">
                                    + Tambah Obat
                                </button>
                            </div>
                            
                            @if($errors->has('obats'))
                                <div class="mb-4 text-sm text-red-600 font-medium">
                                    {{ $errors->first('obats') }}
                                </div>
                            @endif

                            <div class="space-y-3">
                                <template x-for="(resep, index) in reseps" :key="index">
                                    <div class="flex flex-col md:flex-row gap-3 items-start md:items-end bg-gray-50 p-4 rounded-lg border border-gray-200">
                                        
                                        <div class="w-full md:flex-1">
                                            <label class="text-xs text-gray-500 uppercase font-bold mb-1 block">Nama Obat</label>
                                            <select :name="'obats['+index+'][obat_id]'" x-model="resep.obat_id" class="block w-full border-gray-300 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500" required>
                                                <option value="">-- Pilih Obat --</option>
                                                @foreach($obats as $obat)
                                                    <option value="{{ $obat->id }}">{{ $obat->nama_obat }} (Stok: {{ $obat->stok }})</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="w-full md:w-24">
                                            <label class="text-xs text-gray-500 uppercase font-bold mb-1 block">Jumlah</label>
                                            <input type="number" :name="'obats['+index+'][jumlah]'" x-model="resep.jumlah" class="block w-full border-gray-300 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500" min="1" required>
                                        </div>

                                        <div class="w-full md:w-1/3">
                                            <label class="text-xs text-gray-500 uppercase font-bold mb-1 block">Dosis</label>
                                            <input type="text" :name="'obats['+index+'][dosis]'" x-model="resep.dosis" class="block w-full border-gray-300 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Contoh: 3x1 Sesudah Makan" required>
                                        </div>

                                        <div>
                                            <button type="button" @click="removeResep(index)" class="text-red-500 hover:text-red-700 p-2 rounded hover:bg-red-50 transition" title="Hapus Baris">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                                
                                <div x-show="reseps.length === 0" class="text-center py-4 text-gray-400 text-sm italic bg-gray-50 rounded border border-dashed">
                                    Belum ada obat yang ditambahkan.
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 gap-4">
                            <a href="{{ route('rekam_medis.index') }}" class="text-gray-600 hover:text-gray-900 text-sm font-medium">Batal</a>
                            <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>
                        </div>
                    </form>

                    <script>
                        document.addEventListener('alpine:init', () => {
                            Alpine.data('resepForm', (initialData) => ({
                                reseps: initialData && initialData.length > 0 ? initialData : [],
                                
                                addResep() {
                                    this.reseps.push({ obat_id: '', jumlah: 1, dosis: '' });
                                },
                                
                                removeResep(index) {
                                    this.reseps.splice(index, 1);
                                }
                            }));
                        });
                    </script>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>