<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Rekam Medis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <a href="{{ route('rekam-medis.index') }}" class="text-blue-600 hover:text-blue-900 mb-4 inline-block">&larr; Kembali ke Daftar</a>

                    <h3 class="font-semibold text-lg mb-2">Data Kunjungan</h3>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div><strong>Pasien:</strong> {{ $rekamMedis->pasien->name ?? 'N/A' }}</div>
                        <div><strong>No. RM:</strong> {{ $rekamMedis->pasien->pasien->no_rekam_medis ?? 'N/A' }}</div>
                        <div><strong>Dokter:</strong> {{ $rekamMedis->dokter->name ?? 'N/A' }}</div>
                        <div><strong>Tanggal:</strong> {{ $rekamMedis->tanggal_kunjungan }}</div>
                    </div>

                    <h3 class="font-semibold text-lg mb-2">Detail Medis</h3>
                    <div class="space-y-4 mb-6">
                        <div>
                            <strong class="block">Keluhan:</strong>
                            <p class="border p-2 rounded-md bg-gray-50">{{ $rekamMedis->keluhan }}</p>
                        </div>
                        <div>
                            <strong class="block">Diagnosa:</strong>
                            <p class="border p-2 rounded-md bg-gray-50">{{ $rekamMedis->diagnosa }}</p>
                        </div>
                        @if($rekamMedis->tindakan)
                        <div>
                            <strong class="block">Tindakan:</strong>
                            <p class="border p-2 rounded-md bg-gray-50">{{ $rekamMedis->tindakan }}</p>
                        </div>
                        @endif
                    </div>

                    <h3 class="font-semibold text-lg mb-2">Resep Obat</h3>
                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Obat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dosis</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($rekamMedis->obats as $obat)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $obat->nama_obat }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $obat->pivot->jumlah }} {{ $obat->satuan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $obat->pivot->dosis }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                        Tidak ada resep obat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('rekam-medis.edit', $rekamMedis) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-600 disabled:opacity-25 transition">
                            Edit
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>