<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Atur Jadwal Kunjungan</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('kunjungans.update', $kunjungan) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-6 p-4 bg-gray-50 rounded border">
                        <p><strong>Pasien:</strong> {{ $kunjungan->pasien->nama }}</p>
                        <p><strong>Keluhan:</strong> {{ $kunjungan->keluhan_awal }}</p>
                        <input type="hidden" name="pasien_id" value="{{ $kunjungan->pasien_id }}">
                        <input type="hidden" name="keluhan_awal" value="{{ $kunjungan->keluhan_awal }}">
                    </div>

                    <div class="mb-4">
                        <x-input-label for="dokter_id" :value="__('Pilih Dokter')" />
                        <select name="dokter_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Pilih Dokter --</option>
                            @foreach($dokters as $dokter)
                                <option value="{{ $dokter->id }}" @if($kunjungan->dokter_id == $dokter->id) selected @endif>
                                    {{ $dokter->user->name }} ({{ $dokter->spesialisasi }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="waktu_kunjungan" :value="__('Tanggal & Jam Periksa')" />
                        <input type="datetime-local" name="waktu_kunjungan" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" 
                               value="{{ $kunjungan->waktu_kunjungan ? $kunjungan->waktu_kunjungan->format('Y-m-d\TH:i') : '' }}">
                    </div>

                    <div class="mb-4">
                        <x-input-label for="status" :value="__('Status Kunjungan')" />
                        <select name="status" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm bg-yellow-50">
                            <option value="menunggu" @if($kunjungan->status == 'menunggu') selected @endif>Menunggu</option>
                            <option value="disetujui" @if($kunjungan->status == 'disetujui') selected @endif>Disetujui / Dijadwalkan</option>
                            <option value="selesai" @if($kunjungan->status == 'selesai') selected @endif>Selesai Periksa</option>
                            <option value="batal" @if($kunjungan->status == 'batal') selected @endif>Batal</option>
                        </select>
                    </div>

                    <div class="flex justify-end mt-4">
                        <x-primary-button>Update Jadwal</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>