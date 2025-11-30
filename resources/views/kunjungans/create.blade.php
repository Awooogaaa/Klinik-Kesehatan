<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Kunjungan Baru</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('kunjungans.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <x-input-label for="pasien_id" :value="__('Pilih Pasien')" />
                        <select name="pasien_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            @foreach($pasiens as $pasien)
                                <option value="{{ $pasien->id }}">{{ $pasien->nama }} ({{ $pasien->no_rekam_medis }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="keluhan_awal" :value="__('Keluhan / Alasan Berobat')" />
                        <textarea name="keluhan_awal" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" rows="3" required></textarea>
                    </div>

                    <input type="hidden" name="status" value="menunggu">

                    <div class="flex justify-end mt-4">
                        <x-primary-button>Simpan</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>