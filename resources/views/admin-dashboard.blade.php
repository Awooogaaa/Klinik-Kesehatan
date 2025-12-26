<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold">Selamat Datang, Admin!</h3>
                    <p>Anda memiliki akses penuh untuk mengelola User, Dokter, dan Pasien.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-blue-100 p-6 rounded-lg shadow-sm">
                    <h4 class="font-bold text-blue-800">Manajemen Pengguna</h4>
                    <ul class="mt-2 list-disc list-inside">
                        <li><a href="{{ route('dokters.index') }}" class="text-blue-600 hover:underline">Kelola Data Dokter</a></li>
                        <li><a href="{{ route('pasiens.index') }}" class="text-blue-600 hover:underline">Kelola Data Pasien</a></li>
                    </ul>
                </div>
                <div class="bg-green-100 p-6 rounded-lg shadow-sm">
                    <h4 class="font-bold text-green-800">Layanan Klinik</h4>
                    <ul class="mt-2 list-disc list-inside">
                        <li><a href="{{ route('obats.index') }}" class="text-green-600 hover:underline">Kelola Obat</a></li>
                        <li><a href="{{ route('kunjungans.index') }}" class="text-green-600 hover:underline">Lihat Kunjungan</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>