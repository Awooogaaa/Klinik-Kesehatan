<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <a href="{{ route('pasiens.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 disabled:opacity-25 transition mb-4">
                        + Tambah Pasien
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. RM</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pasien</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akun Login</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Telepon</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($pasiens as $pasien)
                                    <tr x-data="{ showDetail: false }">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pasien->no_rekam_medis }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $pasien->nama }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if($pasien->user)
                                                <div class="flex flex-col">
                                                    <span class="text-gray-900">{{ $pasien->user->email }}</span>
                                                    <span class="text-xs text-green-600 font-semibold bg-green-100 px-2 py-0.5 rounded-full w-fit mt-1">Terhubung</span>
                                                </div>
                                            @else
                                                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Tidak ada akun</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pasien->no_telepon }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ Str::limit($pasien->alamat, 20) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                            
                                            <button @click="showDetail = true" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded transition">
                                                Lihat
                                            </button>

                                            <a href="{{ route('pasiens.edit', $pasien) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1 rounded transition">Edit</a>
                                            
                                            <form action="{{ route('pasiens.destroy', $pasien) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus data pasien ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1 rounded transition">Hapus</button>
                                            </form>

                                            <div x-show="showDetail" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                    
                                                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="showDetail = false"></div>

                                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full">
                                                        
                                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 border-b border-gray-100">
                                                            <div class="sm:flex sm:items-start">
                                                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                                                    <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                                    </svg>
                                                                </div>
                                                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                                                        Detail Pasien
                                                                    </h3>
                                                                    <div class="mt-2 text-sm text-gray-500">
                                                                        Informasi lengkap mengenai data diri pasien.
                                                                    </div>
                                                                </div>
                                                                <button @click="showDetail = false" class="text-gray-400 hover:text-gray-500">
                                                                    <span class="sr-only">Close</span>
                                                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>

                                                        <div class="px-6 py-6 bg-gray-50">
                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                                                                <div class="space-y-4">
                                                                    <div>
                                                                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide">Nama Lengkap</label>
                                                                        <p class="mt-1 text-gray-900 font-semibold text-lg">{{ $pasien->nama }}</p>
                                                                    </div>
                                                                    <div>
                                                                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide">No. Rekam Medis</label>
                                                                        <p class="mt-1 text-blue-600 font-mono font-bold">{{ $pasien->no_rekam_medis }}</p>
                                                                    </div>
                                                                    <div>
                                                                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide">Jenis Kelamin</label>
                                                                        <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $pasien->jenis_kelamin == 'Laki-laki' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                                                            {{ $pasien->jenis_kelamin }}
                                                                        </span>
                                                                    </div>
                                                                </div>

                                                                <div class="space-y-4">
                                                                    <div>
                                                                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide">Tanggal Lahir / Usia</label>
                                                                        <p class="mt-1 text-gray-900">
                                                                            {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d M Y') }} 
                                                                            <span class="text-gray-500">({{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->age }} Tahun)</span>
                                                                        </p>
                                                                    </div>
                                                                    <div>
                                                                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide">Nomor Telepon</label>
                                                                        <p class="mt-1 text-gray-900">{{ $pasien->no_telepon }}</p>
                                                                    </div>
                                                                    <div>
                                                                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide">Alamat</label>
                                                                        <p class="mt-1 text-gray-900 leading-relaxed">{{ $pasien->alamat }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="mt-6 pt-4 border-t border-gray-200">
                                                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Informasi Akun</label>
                                                                @if($pasien->user)
                                                                    <div class="bg-white p-3 rounded border border-gray-200 flex items-center justify-between">
                                                                        <div>
                                                                            <p class="text-gray-900 font-medium">{{ $pasien->user->name }}</p>
                                                                            <p class="text-gray-500 text-xs">{{ $pasien->user->email }}</p>
                                                                        </div>
                                                                        <span class="text-green-600 bg-green-50 px-2 py-1 rounded text-xs font-bold">Aktif</span>
                                                                    </div>
                                                                @else
                                                                    <p class="text-gray-500 text-xs italic">Pasien ini belum ditautkan ke akun pengguna manapun.</p>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="bg-white px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
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
                                            Tidak ada data pasien.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $pasiens->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>