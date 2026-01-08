<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Pemeriksaan - {{ $kunjungan->pasien->nama }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
            body { -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body class="bg-gray-100 p-8 text-gray-800">

    <div class="max-w-2xl mx-auto bg-white p-10 shadow-lg rounded-lg border border-gray-200">
        
        <div class="text-center border-b-2 border-gray-100 pb-6 mb-6">
            <h1 class="text-3xl font-extrabold text-blue-900 tracking-wide uppercase">Klinik Kesehatan</h1>
            <p class="text-gray-500 text-sm mt-1">Jl. Sehat Sejahtera No. 99, Indonesia</p>
            <p class="text-gray-500 text-sm">Telp: 0812-3456-7890 | Email: admin@klinik.com</p>
        </div>

        <div class="grid grid-cols-2 gap-8 mb-8 text-sm">
            <div>
                <p class="text-gray-400 text-xs uppercase font-bold tracking-wider mb-1">Data Pasien</p>
                <p class="font-bold text-lg text-gray-800">{{ $kunjungan->pasien->nama }}</p>
                <p class="text-gray-600">RM: #{{ $kunjungan->pasien->no_rekam_medis }}</p>
            </div>
            <div class="text-right">
                <p class="text-gray-400 text-xs uppercase font-bold tracking-wider mb-1">Detail Kunjungan</p>
                <p class="font-bold text-gray-800">{{ $kunjungan->waktu_kunjungan ? \Carbon\Carbon::parse($kunjungan->waktu_kunjungan)->format('d M Y') : '-' }}</p>
                <p class="text-gray-600">Dr. {{ $kunjungan->dokter->nama ?? '-' }}</p>
            </div>
        </div>

        <div class="mb-8 bg-gray-50 p-6 rounded-xl border border-gray-100">
            <h3 class="font-bold text-gray-900 border-b border-gray-200 pb-2 mb-4 text-sm uppercase">Hasil Pemeriksaan</h3>
            <div class="grid grid-cols-1 gap-3 text-sm">
                <div class="flex">
                    <span class="font-semibold w-24 text-gray-500">Diagnosa</span>
                    <span class="text-gray-800">: {{ $kunjungan->rekamMedis->diagnosa }}</span>
                </div>
                <div class="flex">
                    <span class="font-semibold w-24 text-gray-500">Tindakan</span>
                    <span class="text-gray-800">: {{ $kunjungan->rekamMedis->tindakan ?? '-' }}</span>
                </div>
            </div>
        </div>

        <div class="mb-8">
            <h3 class="font-bold text-gray-900 border-b border-gray-200 pb-2 mb-4 text-sm uppercase">Rincian Biaya & Obat</h3>
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="text-gray-400 border-b border-gray-100">
                        <th class="py-2 font-medium">Deskripsi</th>
                        <th class="py-2 text-center font-medium">Qty</th>
                        <th class="py-2 text-right font-medium">Harga</th>
                        <th class="py-2 text-right font-medium">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    {{-- Biaya Jasa Dokter --}}
                    <tr>
                        <td class="py-3 text-gray-800">Jasa Dokter (Konsultasi)</td>
                        <td class="py-3 text-center text-gray-500">1</td>
                        <td class="py-3 text-right text-gray-500">Rp {{ number_format($kunjungan->dokter->biaya_jasa ?? 50000, 0, ',', '.') }}</td>
                        <td class="py-3 text-right font-medium text-gray-800">Rp {{ number_format($kunjungan->dokter->biaya_jasa ?? 50000, 0, ',', '.') }}</td>
                    </tr>

                    {{-- Obat-obatan --}}
                    @foreach($kunjungan->rekamMedis->obats as $obat)
                        <tr>
                            <td class="py-3">
                                <span class="text-gray-800 block">{{ $obat->nama_obat }}</span>
                                <span class="text-xs text-gray-400 italic">{{ $obat->pivot->dosis }}</span>
                            </td>
                            <td class="py-3 text-center text-gray-500">{{ $obat->pivot->jumlah }} {{ $obat->satuan }}</td>
                            <td class="py-3 text-right text-gray-500">Rp {{ number_format($obat->harga, 0, ',', '.') }}</td>
                            <td class="py-3 text-right font-medium text-gray-800">Rp {{ number_format($obat->harga * $obat->pivot->jumlah, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-t-2 border-gray-100">
                        <td colspan="3" class="py-4 text-right font-bold text-gray-900 text-lg">TOTAL TAGIHAN</td>
                        <td class="py-4 text-right font-bold text-blue-600 text-lg">
                            Rp {{ number_format($kunjungan->pembayaran->total_harga ?? 0, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="mb-8 flex justify-between items-center bg-green-50 border border-green-200 p-4 rounded-lg">
            <div>
                <p class="text-xs text-green-600 uppercase font-bold tracking-wider">Status Pembayaran</p>
                <p class="text-lg font-bold text-green-800 mt-1">LUNAS</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-green-600 uppercase font-bold tracking-wider">Metode Pembayaran</p>
                <p class="text-base font-semibold text-green-800 mt-1 uppercase">
                    {{ $kunjungan->pembayaran->metode_pembayaran ?? 'Online' }}
                </p>
                <p class="text-xs text-green-600 mt-1 font-mono">
                    ID: {{ $kunjungan->pembayaran->order_id ?? '-' }}
                </p>
            </div>
        </div>

        <div class="text-center mt-12 pt-8 border-t border-dashed border-gray-300 text-sm text-gray-500">
            <p>Terima kasih atas kepercayaan Anda.</p>
            <p>Semoga lekas sembuh.</p>
            <p class="text-xs text-gray-400 mt-4">Dicetak pada: {{ now()->format('d M Y H:i') }} WIB</p>
        </div>

        <div class="mt-8 text-center no-print space-x-4">
            <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-full shadow-lg transition transform hover:-translate-y-1">
                🖨️ Cetak Nota / Simpan PDF
            </button>
            <a href="{{ route('pasiens.landingpage') }}" class="text-gray-600 hover:text-blue-600 font-medium underline">
                Kembali ke Dashboard
            </a>
        </div>
    </div>

</body>
</html>