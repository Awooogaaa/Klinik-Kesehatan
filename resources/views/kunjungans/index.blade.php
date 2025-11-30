<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jadwal Kunjungan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('kunjungans.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md mb-4 inline-block hover:bg-blue-700">+ Daftar Kunjungan</a>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pasien</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keluhan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dokter & Jadwal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($kunjungans as $visit)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="font-bold">{{ $visit->pasien->nama }}</div>
                                        <div class="text-xs text-gray-500">{{ $visit->pasien->no_rekam_medis }}</div>
                                    </td>
                                    <td class="px-6 py-4">{{ Str::limit($visit->keluhan_awal, 30) }}</td>
                                    <td class="px-6 py-4">
                                        @if($visit->dokter)
                                            <div class="text-sm font-semibold">{{ $visit->dokter->user->name }}</div>
                                            <div class="text-xs text-gray-500">
                                                {{ $visit->waktu_kunjungan ? $visit->waktu_kunjungan->format('d M Y, H:i') : 'Belum dijadwalkan' }}
                                            </div>
                                        @else
                                            <span class="text-red-500 text-xs">Belum ada dokter</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $colors = [
                                                'menunggu' => 'bg-yellow-100 text-yellow-800',
                                                'disetujui' => 'bg-blue-100 text-blue-800',
                                                'selesai' => 'bg-green-100 text-green-800',
                                                'batal' => 'bg-red-100 text-red-800',
                                            ];
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $colors[$visit->status] }}">
                                            {{ ucfirst($visit->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-medium">
                                        <a href="{{ route('kunjungans.edit', $visit) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Atur/Edit</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $kunjungans->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>