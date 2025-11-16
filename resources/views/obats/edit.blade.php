<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Obat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('obats.update', $obat) }}" method="POST">
                        @csrf
                        @method('PUT') <div>
                            <x-input-label for="nama_obat" :value="__('Nama Obat')" />
                            <x-text-input id="nama_obat" class="block mt-1 w-full" type="text" name="nama_obat" :value="old('nama_obat', $obat->nama_obat)" required autofocus />
                            <x-input-error :messages="$errors->get('nama_obat')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="satuan" :value="__('Satuan (cth: tablet, botol, strip)')" />
                            <x-text-input id="satuan" class="block mt-1 w-full" type="text" name="satuan" :value="old('satuan', $obat->satuan)" required />
                            <x-input-error :messages="$errors->get('satuan')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="stok" :value="__('Stok')" />
                            <x-text-input id="stok" class="block mt-1 w-full" type="number" name="stok" :value="old('stok', $obat->stok)" required />
                            <x-input-error :messages="$errors->get('stok')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('obats.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                                Batal
                            </a>
                            <x-primary-button>
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>