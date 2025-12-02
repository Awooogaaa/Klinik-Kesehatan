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

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg border border-green-200">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg border border-red-200">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-4">
                        <a href="{{ route('rekam_medis.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 disabled:opacity-25 transition">
                            + Periksa Pasien Baru
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pasien</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokter</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diagnosa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Obat (Jml)</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($rekamMedis as $rm)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($rm->kunjungan->waktu_kunjungan ?? $rm->created_at)->format('d M Y') }}
                                            <div class="text-xs text-gray-400">
                                                {{ $rm->created_at->format('H:i') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                            {{ $rm->pasien->name ?? $rm->pasien->nama ?? 'N/A' }}
                                            <div class="text-xs text-gray-500">No. RM: {{ $rm->pasien->no_rekam_medis ?? '-' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $rm->dokter->user->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">
                                            {{ Str::limit($rm->diagnosa, 30) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            @if ($rm->obats->count() > 0)
                                                <ul class="list-disc list-inside text-xs">
                                                    @foreach ($rm->obats as $obat)
                                                        <li>
                                                            <span class="font-semibold">{{ $obat->nama_obat }}</span>
                                                            ({{ $obat->pivot->jumlah }} {{ $obat->satuan ?? '' }})
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <span class="text-gray-400 italic text-xs">- Tidak ada obat -</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button type="button" onclick="openDetailModal({{ $rm->id }})" class="text-blue-600 hover:text-blue-900 mr-3 focus:outline-none">
                                                Detail
                                            </button>
                                            <a href="{{ route('rekam_medis.edit', $rm->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                            <form action="{{ route('rekam_medis.destroy', $rm->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus data ini? PERINGATAN: Stok obat yang sudah diambil TIDAK AKAN kembali.');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada data rekam medis.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $rekamMedis->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    <x-modal name="detail-modal" focusable>
        <div class="p-6">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h2 class="text-lg font-medium text-gray-900">Detail Rekam Medis</h2>
                <button x-on:click="$dispatch('close')" class="text-gray-400 hover:text-gray-500">
                    <span class="text-2xl">&times;</span>
                </button>
            </div>

            <div id="modal-loading" class="text-center py-8">
                <svg class="animate-spin h-8 w-8 text-blue-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="mt-2 text-sm text-gray-500">Memuat data...</p>
            </div>

            <div id="modal-content" class="hidden space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <div>
                            <span class="text-xs text-gray-500 uppercase font-bold block">Pasien</span>
                            <span id="d-pasien" class="text-gray-900 font-medium"></span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-500 uppercase font-bold block">Dokter</span>
                            <span id="d-dokter" class="text-gray-900 font-medium"></span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-500 uppercase font-bold block">Tanggal Kunjungan</span>
                            <span id="d-tanggal" class="text-gray-900 font-medium"></span>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <span class="text-xs text-gray-500 uppercase font-bold block">Diagnosa</span>
                            <p id="d-diagnosa" class="text-gray-900 bg-gray-50 p-2 rounded border"></p>
                        </div>
                        <div>
                            <span class="text-xs text-gray-500 uppercase font-bold block">Keluhan</span>
                            <p id="d-keluhan" class="text-gray-900 italic"></p>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <span class="text-xs text-gray-500 uppercase font-bold block mb-1">Resep Obat</span>
                    <div class="border rounded overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Obat</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Jml</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Dosis</th>
                                </tr>
                            </thead>
                            <tbody id="d-obat-list" class="bg-white divide-y divide-gray-200 text-sm"></tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">Tutup</x-secondary-button>
                </div>
            </div>
        </div>
    </x-modal>

    @push('scripts')
    <script>
        function openDetailModal(id) {
            if (typeof Alpine === 'undefined') {
                console.error('Error: Alpine.js tidak terdeteksi.');
                return;
            }

            const modalLoading = document.getElementById('modal-loading');
            const modalContent = document.getElementById('modal-content');

            modalLoading.classList.remove('hidden');
            modalContent.classList.add('hidden');
            
            // Buka Modal
            window.dispatchEvent(new CustomEvent('open-modal', { detail: 'detail-modal' }));

            fetch(`/rekam_medis/${id}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                const rm = data.rekam_medis || data; 

                // 1. ISI DATA
                document.getElementById('d-pasien').textContent = rm.pasien?.name || rm.pasien?.nama || '-';
                
                // Mengambil nama dokter dari relasi user (pastikan controller sudah load 'dokter.user')
                document.getElementById('d-dokter').textContent = rm.dokter?.user?.name || rm.dokter?.nama || '-';

                // Mengambil tanggal dari relasi kunjungan
                if (rm.kunjungan?.waktu_kunjungan) {
                    const dateObj = new Date(rm.kunjungan.waktu_kunjungan);
                    document.getElementById('d-tanggal').textContent = dateObj.toLocaleDateString('id-ID', {
                        day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit'
                    });
                } else {
                    document.getElementById('d-tanggal').textContent = '-';
                }

                document.getElementById('d-diagnosa').textContent = rm.diagnosa || '-';
                document.getElementById('d-keluhan').textContent = rm.keluhan || '-';
                
                // 2. ISI TABEL OBAT
                const obatBody = document.getElementById('d-obat-list');
                obatBody.innerHTML = '';

                if(rm.obats && rm.obats.length > 0) {
                    rm.obats.forEach(obat => {
                        const row = `
                            <tr>
                                <td class="px-3 py-2 border-b">${obat.nama_obat}</td>
                                <td class="px-3 py-2 border-b">${obat.pivot?.jumlah || '-'}</td>
                                <td class="px-3 py-2 border-b">${obat.pivot?.dosis || '-'}</td>
                            </tr>`;
                        obatBody.innerHTML += row;
                    });
                } else {
                    obatBody.innerHTML = `<tr><td colspan="3" class="px-3 py-2 text-center text-gray-400 italic">Tidak ada resep obat</td></tr>`;
                }

                modalLoading.classList.add('hidden');
                modalContent.classList.remove('hidden');
            })
            .catch(err => {
                console.error(err);
                alert('Gagal memuat data.');
                window.dispatchEvent(new CustomEvent('close-modal', { detail: 'detail-modal' }));
            });
        }
    </script>
    @endpush
</x-app-layout>