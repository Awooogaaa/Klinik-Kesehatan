<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Pemeriksaan - {{ $kunjungan->pasien->nama }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen py-8 px-4">

    <div class="max-w-xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            
            <!-- Header -->
            <div class="border-b border-gray-100 p-6 text-center">
                <h1 class="text-xl font-bold text-gray-900">KLINIK KESEHATAN</h1>
                <p class="text-sm text-gray-500 mt-1">Jl. Sehat Sejahtera No. 99</p>
                <p class="text-xs text-gray-400">Telp: 0812-3456-7890</p>
            </div>

            <!-- Nota Info -->
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between text-sm">
                <div>
                    <span class="text-gray-500">No. Nota:</span>
                    <span class="font-semibold text-gray-800 ml-1">#{{ str_pad($kunjungan->id, 6, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div>
                    <span class="text-gray-500">Tanggal:</span>
                    <span class="font-semibold text-gray-800 ml-1">{{ $kunjungan->waktu_kunjungan ? \Carbon\Carbon::parse($kunjungan->waktu_kunjungan)->format('d/m/Y') : '-' }}</span>
                </div>
            </div>

            <!-- Patient & Doctor -->
            <div class="p-6 border-b border-gray-100">
                <div class="grid grid-cols-2 gap-6 text-sm">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Pasien</p>
                        <p class="font-semibold text-gray-900">{{ $kunjungan->pasien->nama }}</p>
                        <p class="text-gray-500 text-xs">RM: {{ $kunjungan->pasien->no_rekam_medis }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Dokter</p>
                        <p class="font-semibold text-gray-900">Dr. {{ $kunjungan->dokter->user->name ?? ($kunjungan->dokter->nama ?? '-') }}</p>
                        @if($kunjungan->dokter && $kunjungan->dokter->spesialisasi)
                            <p class="text-gray-500 text-xs">{{ $kunjungan->dokter->spesialisasi }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Diagnosis -->
            <div class="p-6 border-b border-gray-100">
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-2">Diagnosa</p>
                <p class="text-gray-800 font-medium">{{ $kunjungan->rekamMedis->diagnosa }}</p>
                @if($kunjungan->rekamMedis->tindakan)
                    <p class="text-gray-500 text-sm mt-1">Tindakan: {{ $kunjungan->rekamMedis->tindakan }}</p>
                @endif
            </div>

            <!-- Items -->
            <div class="p-6 border-b border-gray-100">
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-3">Rincian Biaya</p>
                <div class="space-y-3">
                    <!-- Jasa Dokter -->
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-700">Jasa Dokter</span>
                        <span class="text-gray-900 font-medium">Rp {{ number_format($kunjungan->dokter->biaya_jasa ?? 50000, 0, ',', '.') }}</span>
                    </div>
                    
                    <!-- Obat -->
                    @foreach($kunjungan->rekamMedis->obats as $obat)
                        <div class="flex justify-between text-sm">
                            <div>
                                <span class="text-gray-700">{{ $obat->nama_obat }}</span>
                                <span class="text-gray-400 text-xs ml-1">({{ $obat->pivot->jumlah }} {{ $obat->satuan }})</span>
                            </div>
                            <span class="text-gray-900 font-medium">Rp {{ number_format($obat->harga * $obat->pivot->jumlah, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Total -->
            <div class="p-6 bg-gray-900 text-white">
                <div class="flex justify-between items-center">
                    <span class="font-semibold">Total</span>
                    <span class="text-xl font-bold">Rp {{ number_format($kunjungan->pembayaran->total_harga ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Payment Status -->
            <div class="p-6 flex justify-between items-center text-sm">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                    <span class="text-green-700 font-semibold">LUNAS</span>
                </div>
                <div class="text-right text-gray-500 text-xs">
                    <p>{{ ucfirst($kunjungan->pembayaran->metode_pembayaran ?? 'Online') }}</p>
                    <p class="font-mono">{{ $kunjungan->pembayaran->order_id ?? '-' }}</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="border-t border-dashed border-gray-200 p-6 text-center">
                <p class="text-gray-600 text-sm">Terima kasih atas kunjungan Anda</p>
                <p class="text-gray-400 text-xs mt-2">{{ now()->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <!-- Actions -->
        <div class="mt-6 flex justify-center gap-4 no-print">
            <button onclick="window.print()" class="px-6 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition">
                Cetak
            </button>
            <a href="{{ route('pasiens.landingpage') }}" class="px-6 py-2.5 bg-white text-gray-700 text-sm font-medium rounded-lg border border-gray-300 hover:bg-gray-50 transition">
                Kembali
            </a>
        </div>
    </div>

</body>
</html>