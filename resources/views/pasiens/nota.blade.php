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
<body class="bg-gray-100 p-8">

    <div class="max-w-2xl mx-auto bg-white p-8 shadow-md rounded-md">
        <div class="text-center border-b pb-4 mb-4">
            <h1 class="text-2xl font-bold text-gray-800">KLINIK KESEHATAN</h1>
            <p class="text-gray-600">Jl. Contoh Alamat Klinik No. 123, Kota Sehat</p>
            <p class="text-gray-600">Telp: 0812-3456-7890</p>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
            <div>
                <p class="text-gray-500">No. Rekam Medis:</p>
                <p class="font-semibold">{{ $kunjungan->pasien->no_rekam_medis }}</p>
                
                <p class="text-gray-500 mt-2">Nama Pasien:</p>
                <p class="font-semibold">{{ $kunjungan->pasien->nama }}</p>
            </div>
            <div class="text-right">
                <p class="text-gray-500">Tanggal:</p>
                <p class="font-semibold">{{ $kunjungan->waktu_kunjungan ? \Carbon\Carbon::parse($kunjungan->waktu_kunjungan)->format('d M Y') : '-' }}</p>
                
                <p class="text-gray-500 mt-2">Dokter Pemeriksa:</p>
                <p class="font-semibold">{{ $kunjungan->dokter->nama ?? '-' }}</p>
            </div>
        </div>

        <div class="mb-6">
            <h3 class="font-bold text-gray-700 border-b mb-2">Hasil Pemeriksaan</h3>
            <p><span class="font-semibold w-24 inline-block">Diagnosa:</span> {{ $kunjungan->rekamMedis->diagnosa }}</p>
            <p><span class="font-semibold w-24 inline-block">Tindakan:</span> {{ $kunjungan->rekamMedis->tindakan ?? '-' }}</p>
        </div>

        <div class="mb-6">
            <h3 class="font-bold text-gray-700 border-b mb-2">Resep Obat</h3>
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="text-gray-500">
                        <th class="py-1">Nama Obat</th>
                        <th class="py-1 text-center">Jumlah</th>
                        <th class="py-1 text-right">Dosis</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($kunjungan->rekamMedis->obats as $obat)
                        <tr>
                            <td class="py-2">{{ $obat->nama_obat }} ({{ $obat->satuan }})</td>
                            <td class="py-2 text-center">{{ $obat->pivot->jumlah }}</td>
                            <td class="py-2 text-right">{{ $obat->pivot->dosis }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-2 text-center text-gray-400 italic">Tidak ada resep obat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="text-center mt-12 pt-8 border-t text-sm text-gray-500">
            <p>Terima kasih atas kunjungan Anda.</p>
            <p>Semoga lekas sembuh.</p>
        </div>

        <div class="mt-8 text-center no-print">
            <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                Cetak Nota / PDF
            </button>
            <a href="{{ route('pasiens.landingpage') }}" class="ml-4 text-blue-600 hover:underline">Kembali</a>
        </div>
    </div>

</body>
</html>