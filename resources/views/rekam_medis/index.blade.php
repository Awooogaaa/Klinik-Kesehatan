<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Rekam Medis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <a href="{{ route('rekam_medis.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 mb-4">
                        + Periksa Pasien Baru
                    </a>

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Kunjungan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pasien</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dokter Pemeriksa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Diagnosa</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($rekamMedis as $rm)
                                    <tr>
                                        {{-- Tgl Kunjungan --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $rm->kunjungan->waktu_kunjungan ? $rm->kunjungan->waktu_kunjungan->format('d M Y H:i') : '-' }}
                                        </td>
                                        
                                        {{-- Nama Pasien (dari tabel pasiens) --}}
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                            {{ $rm->pasien->nama }}
                                            <div class="text-xs text-gray-500">RM: {{ $rm->pasien->no_rekam_medis }}</div>
                                        </td>

                                        {{-- Nama Dokter (dari tabel users via relasi dokter) --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $rm->dokter->user->name }}
                                        </td>

                                        {{-- Diagnosa --}}
                                        <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">
                                            {{ Str::limit($rm->diagnosa, 40) }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('rekam_medis.show', $rm) }}" class="text-green-600 hover:text-green-900 mr-2">Detail</a>
                                            <a href="{{ route('rekam_medis.edit', $rm) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                                            <form action="{{ route('rekam_medis.destroy', $rm) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus data ini?');">
                                                @csrf @method('DELETE')
                                                <button class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center py-4 text-gray-500">Belum ada rekam medis.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $rekamMedis->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>