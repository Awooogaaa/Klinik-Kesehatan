<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Dokter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <a href="{{ route('dokters.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 disabled:opacity-25 transition mb-4">
                        + Tambah Dokter
                    </a>

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg border border-green-200">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Dokter</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Spesialisasi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($dokters as $dokter)
                                    <tr x-data="{ showDetail: false }">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($dokter->foto)
                                                <img src="{{ asset('storage/' . $dokter->foto) }}" alt="Foto" class="h-12 w-12 rounded-full object-cover border border-gray-300">
                                            @else
                                                <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-500 font-bold text-lg border border-blue-200">
                                                    {{ substr($dokter->user->name ?? 'D', 0, 1) }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $dokter->user->name ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ $dokter->spesialisasi }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="font-medium text-gray-700">{{ $dokter->no_telepon }}</div>
                                            <div class="text-xs text-gray-400">{{ $dokter->user->email ?? '-' }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                            {{ $dokter->alamat }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                            
                                            <button @click="showDetail = true" class="text-teal-600 hover:text-teal-900 bg-teal-50 hover:bg-teal-100 px-3 py-1 rounded transition">
                                                Lihat
                                            </button>

                                            <a href="{{ route('dokters.edit', $dokter) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1 rounded transition">Edit</a>
                                            
                                            <form action="{{ route('dokters.destroy', $dokter) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus dokter ini? Akun login juga akan terhapus.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1 rounded transition">Hapus</button>
                                            </form>

                                            <div x-show="showDetail" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                    
                                                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="showDetail = false"></div>

                                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                                                        
                                                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-4 py-6 sm:px-6 flex flex-col items-center">
                                                            <div class="mb-4 relative">
                                                                @if($dokter->foto)
                                                                    <img src="{{ asset('storage/' . $dokter->foto) }}" alt="Foto Dokter" class="h-24 w-24 rounded-full object-cover border-4 border-white shadow-md">
                                                                @else
                                                                    <div class="h-24 w-24 rounded-full bg-white flex items-center justify-center text-blue-500 font-bold text-4xl shadow-md border-4 border-blue-200">
                                                                        {{ substr($dokter->user->name ?? 'D', 0, 1) }}
                                                                    </div>
                                                                @endif
                                                                <div class="absolute bottom-0 right-0 bg-green-400 w-5 h-5 rounded-full border-2 border-white" title="Status Aktif"></div>
                                                            </div>
                                                            <h3 class="text-xl font-bold text-white text-center">{{ $dokter->user->name ?? 'Nama Tidak Tersedia' }}</h3>
                                                            <span class="bg-blue-800 text-blue-100 text-xs px-3 py-1 rounded-full mt-2 font-semibold tracking-wide">
                                                                {{ $dokter->spesialisasi }}
                                                            </span>
                                                        </div>

                                                        <div class="px-6 py-6 bg-white">
                                                            <div class="space-y-4">
                                                                <div class="flex items-start space-x-3">
                                                                    <div class="flex-shrink-0 mt-1">
                                                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                                        </svg>
                                                                    </div>
                                                                    <div>
                                                                        <p class="text-sm font-medium text-gray-900">Nomor Telepon</p>
                                                                        <p class="text-sm text-gray-500">{{ $dokter->no_telepon }}</p>
                                                                    </div>
                                                                </div>

                                                                <div class="flex items-start space-x-3">
                                                                    <div class="flex-shrink-0 mt-1">
                                                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                                        </svg>
                                                                    </div>
                                                                    <div>
                                                                        <p class="text-sm font-medium text-gray-900">Email Akun</p>
                                                                        <p class="text-sm text-gray-500">{{ $dokter->user->email ?? 'Tidak ada email' }}</p>
                                                                    </div>
                                                                </div>

                                                                <div class="flex items-start space-x-3">
                                                                    <div class="flex-shrink-0 mt-1">
                                                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                        </svg>
                                                                    </div>
                                                                    <div>
                                                                        <p class="text-sm font-medium text-gray-900">Alamat Praktik / Domisili</p>
                                                                        <p class="text-sm text-gray-500 leading-relaxed">{{ $dokter->alamat }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
                                                            <button type="button" class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="showDetail = false">
                                                                Tutup
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                            Tidak ada data dokter.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $dokters->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>