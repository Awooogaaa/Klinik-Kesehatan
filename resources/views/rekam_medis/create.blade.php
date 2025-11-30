<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Rekam Medis Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if($kunjungans->isEmpty())
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                            <p class="text-sm text-yellow-700">
                                Tidak ada pasien dalam antrian (Status: Disetujui). 
                                Silakan atur jadwal kunjungan terlebih dahulu.
                            </p>
                        </div>
                    @else
                        <form action="{{ route('rekam-medis.store') }}" method="POST">
                            @csrf
                            
                            <div class="mb-4">
                                <x-input-label for="kunjungan_id" :value="__('Pilih Pasien / Jadwal Kunjungan')" />
                                <select name="kunjungan_id" id="kunjungan_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required onchange="fillKeluhan()">
                                    <option value="">-- Pilih Antrian --</option>
                                    @foreach($kunjungans as $k)
                                        <option value="{{ $k->id }}" data-keluhan="{{ $k->keluhan_awal }}">
                                            {{ $k->waktu_kunjungan->format('H:i') }} - {{ $k->pasien->nama }} (Dr. {{ $k->dokter->user->name }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <x-input-label for="keluhan" :value="__('Keluhan')" />
                                <textarea id="keluhan" name="keluhan" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" rows="2" required></textarea>
                            </div>

                            <div class="mb-4">
                                <x-input-label for="diagnosa" :value="__('Diagnosa Dokter')" />
                                <textarea id="diagnosa" name="diagnosa" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" rows="3" required></textarea>
                            </div>

                            <div class="mb-4">
                                <x-input-label for="tindakan" :value="__('Tindakan / Resep')" />
                                <textarea id="tindakan" name="tindakan" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" rows="3"></textarea>
                            </div>

                            <div class="flex justify-end mt-4">
                                <x-primary-button>Simpan & Selesaikan Pemeriksaan</x-primary-button>
                            </div>
                        </form>
                        
                        <script>
                            function fillKeluhan() {
                                var select = document.getElementById('kunjungan_id');
                                var keluhan = select.options[select.selectedIndex].getAttribute('data-keluhan');
                                document.getElementById('keluhan').value = keluhan ? keluhan : '';
                            }
                        </script>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>