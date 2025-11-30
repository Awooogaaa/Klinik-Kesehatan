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
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. RM</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pasien</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akun Login (Email)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Telepon</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($pasiens as $pasien)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $pasien->no_rekam_medis }}</td>
                                        
                                        {{-- PERBAIKAN 1: Ambil nama dari tabel pasien, bukan user --}}
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                            {{ $pasien->nama }}
                                        </td>

                                        {{-- PERBAIKAN 2: Cek dulu apakah pasien punya akun user --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if($pasien->user)
                                                <div class="flex flex-col">
                                                    <span class="text-gray-900">{{ $pasien->user->email }}</span>
                                                    <span class="text-xs text-green-600 font-semibold bg-green-100 px-2 py-0.5 rounded-full w-fit mt-1">
                                                        Terhubung
                                                    </span>
                                                </div>
                                            @else
                                                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">
                                                    Tidak ada akun
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">{{ $pasien->no_telepon }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ Str::limit($pasien->alamat, 20) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('pasiens.edit', $pasien) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            
                                            <form action="{{ route('pasiens.destroy', $pasien) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus data pasien ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 ml-4">Hapus</button>
                                            </form>
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