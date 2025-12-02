<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Dokter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('dokters.update', $dokter) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <h3 class="font-semibold mb-4">Data Akun Login</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="name" :value="__('Nama Lengkap')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $dokter->user->name)" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $dokter->user->email)" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="password" :value="__('Password (Opsional)')" />
                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                <small class="text-gray-500">Kosongkan jika tidak ingin mengubah password.</small>
                            </div>
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password (Opsional)')" />
                                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" />
                            </div>
                        </div>

                        <h3 class="font-semibold mt-8 mb-4">Data Profil Dokter</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                             <div>
                                <x-input-label for="spesialisasi" :value="__('Spesialisasi')" />
                                <x-text-input id="spesialisasi" class="block mt-1 w-full" type="text" name="spesialisasi" :value="old('spesialisasi', $dokter->spesialisasi)" required />
                                <x-input-error :messages="$errors->get('spesialisasi')" class="mt-2" />
                            </div>
                             <div>
                                <x-input-label for="no_telepon" :value="__('No. Telepon')" />
                                <x-text-input id="no_telepon" class="block mt-1 w-full" type="text" name="no_telepon" :value="old('no_telepon', $dokter->no_telepon)" required />
                                <x-input-error :messages="$errors->get('no_telepon')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('dokters.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
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