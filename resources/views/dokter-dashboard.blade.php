<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Dokter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold">Halo, Dr. {{ Auth::user()->name }}</h3>
                    <p>Selamat bertugas. Silakan cek antrian kunjungan dan rekam medis pasien.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('kunjungans.index') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Data Kunjungan</h5>
                    <p class="font-normal text-gray-700">Lihat daftar pasien yang berkunjung hari ini.</p>
                </a>

                <a href="{{ route('rekam_medis.index') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Rekam Medis</h5>
                    <p class="font-normal text-gray-700">Input dan kelola riwayat kesehatan pasien.</p>
                </a>

                <a href="{{ route('obats.index') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Stok Obat</h5>
                    <p class="font-normal text-gray-700">Cek ketersediaan obat untuk resep.</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>