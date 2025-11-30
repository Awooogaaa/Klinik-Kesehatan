<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Pasien Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('pasiens.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-8 border-b pb-8">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                <span class="bg-blue-100 text-blue-600 py-1 px-3 rounded-full text-xs mr-2">1</span>
                                Data Pribadi Pasien
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="nama" :value="__('Nama Lengkap Pasien')" />
                                    <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama')" required autofocus />
                                    <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="no_telepon" :value="__('No. Telepon')" />
                                    <x-text-input id="no_telepon" class="block mt-1 w-full" type="text" name="no_telepon" :value="old('no_telepon')" required />
                                    <x-input-error :messages="$errors->get('no_telepon')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                                    <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir" :value="old('tanggal_lahir')" required />
                                    <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                                    <select id="jenis_kelamin" name="jenis_kelamin" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki" @if(old('jenis_kelamin') == 'Laki-laki') selected @endif>Laki-laki</option>
                                        <option value="Perempuan" @if(old('jenis_kelamin') == 'Perempuan') selected @endif>Perempuan</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
                                </div>
                            </div>
                            <div class="mt-4">
                                <x-input-label for="alamat" :value="__('Alamat')" />
                                <textarea id="alamat" name="alamat" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" rows="3">{{ old('alamat') }}</textarea>
                                <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mb-4">
                            <h3 class="text-lg font-bold text-gray-800 mb-2 flex items-center">
                                <span class="bg-gray-100 text-gray-600 py-1 px-3 rounded-full text-xs mr-2">2</span>
                                Akun Keluarga / Login (Opsional)
                            </h3>
                            
                            <div class="bg-blue-50 border border-blue-200 text-blue-800 p-4 rounded-lg mb-4 text-sm">
                                <strong>Info:</strong> 
                                <ul>
                                    <li>- Jika email <strong>BELUM</strong> terdaftar: Sistem akan membuatkan akun baru.</li>
                                    <li>- Jika email <strong>SUDAH</strong> terdaftar: Pasien ini akan otomatis <strong>ditambahkan ke akun keluarga</strong> pemilik email tersebut.</li>
                                </ul>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <div>
                                    <x-input-label for="email" :value="__('Email Akun')" />
                                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="Masukkan email Kepala Keluarga / Pribadi" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <x-input-label for="password" :value="__('Password')" />
                                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" placeholder="Isi HANYA jika ini akun baru" />
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('pasiens.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                            <x-primary-button>{{ __('Simpan Pasien') }}</x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>