<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('pasiens.update', $pasien) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <h3 class="font-semibold mb-4">Data Akun Login</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="name" :value="__('Nama Lengkap')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $pasien->user->name)" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $pasien->user->email)" required />
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

                        <h3 class="font-semibold mt-8 mb-4">Data Profil Pasien</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
    <x-input-label for="no_rekam_medis" :value="__('Nomor Rekam Medis (No. RM)')" />
    <x-text-input id="no_rekam_medis" class="block mt-1 w-full bg-gray-100" 
                  type="text" name="no_rekam_medis" 
                  :value="old('no_rekam_medis', $pasien->no_rekam_medis)" 
                  disabled readonly />
    <small class="text-gray-500">No. RM dibuat otomatis dan tidak bisa diubah.</small>
</div>
                             <div>
                                <x-input-label for="no_telepon" :value="__('No. Telepon')" />
                                <x-text-input id="no_telepon" class="block mt-1 w-full" type="text" name="no_telepon" :value="old('no_telepon', $pasien->no_telepon)" required />
                                <x-input-error :messages="$errors->get('no_telepon')" class="mt-2" />
                            </div>
                             <div>
                                <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                                <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir" :value="old('tanggal_lahir', $pasien->tanggal_lahir)" required />
                                <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                                <select id="jenis_kelamin" name="jenis_kelamin" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" @if(old('jenis_kelamin', $pasien->jenis_kelamin) == 'Laki-laki') selected @endif>Laki-laki</option>
                                    <option value="Perempuan" @if(old('jenis_kelamin', $pasien->jenis_kelamin) == 'Perempuan') selected @endif>Perempuan</option>
                                </select>
                                <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-input-label for="alamat" :value="__('Alamat')" />
                            <textarea id="alamat" name="alamat" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('alamat', $pasien->alamat) }}</textarea>
                            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                        </div>


                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('pasiens.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
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