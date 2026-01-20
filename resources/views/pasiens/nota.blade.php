<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Pemeriksaan - {{ $kunjungan->pasien->nama }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .print-shadow { box-shadow: none !important; }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-100 via-gray-100 to-slate-200 min-h-screen py-8 px-4">

    <div class="max-w-2xl mx-auto">
        <!-- Main Nota Card -->
        <div class="bg-white rounded-3xl shadow-2xl print-shadow overflow-hidden border border-gray-100">
            
            <!-- Header with Logo & Clinic Info -->
            <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 p-8 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full -ml-24 -mb-24 blur-3xl"></div>
                
                <div class="relative z-10 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 rounded-2xl backdrop-blur-sm mb-4 border border-white/30 shadow-xl">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-extrabold tracking-tight">KLINIK KESEHATAN</h1>
                    <p class="text-blue-100 text-sm mt-2 font-medium">Jl. Sehat Sejahtera No. 99, Indonesia</p>
                    <div class="flex items-center justify-center gap-4 mt-3 text-xs text-blue-200">
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            0812-3456-7890
                        </span>
                        <span>•</span>
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            admin@klinik.com
                        </span>
                    </div>
                </div>
            </div>

            <!-- Nota Number & Date Banner -->
            <div class="bg-gradient-to-r from-gray-50 to-slate-50 px-8 py-4 border-b border-gray-100">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">No. Nota</p>
                        <p class="text-lg font-bold text-gray-800 font-mono">#{{ str_pad($kunjungan->id, 6, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">Tanggal Kunjungan</p>
                        <p class="text-lg font-bold text-gray-800">{{ $kunjungan->waktu_kunjungan ? \Carbon\Carbon::parse($kunjungan->waktu_kunjungan)->format('d M Y') : '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Patient & Doctor Info -->
            <div class="p-8">
                <div class="grid grid-cols-2 gap-8 mb-8">
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-5 rounded-2xl border border-blue-100">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                {{ strtoupper(substr($kunjungan->pasien->nama, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-xs text-blue-500 uppercase font-bold tracking-wider">Data Pasien</p>
                                <p class="font-bold text-gray-900 text-lg">{{ $kunjungan->pasien->nama }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600 bg-white px-3 py-2 rounded-xl">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            No. RM: <span class="font-bold text-blue-600">{{ $kunjungan->pasien->no_rekam_medis }}</span>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-5 rounded-2xl border border-purple-100">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-purple-500 uppercase font-bold tracking-wider">Dokter</p>
                                <p class="font-bold text-gray-900 text-lg">Dr. {{ $kunjungan->dokter->user->name ?? ($kunjungan->dokter->nama ?? '-') }}</p>
                            </div>
                        </div>
                        @if($kunjungan->dokter && $kunjungan->dokter->spesialisasi)
                        <div class="text-sm text-gray-600 bg-white px-3 py-2 rounded-xl">
                            <span class="text-purple-600 font-semibold">{{ $kunjungan->dokter->spesialisasi }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Examination Results -->
                <div class="mb-8">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="p-2 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-xl shadow">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-800 text-lg">Hasil Pemeriksaan</h3>
                    </div>
                    <div class="bg-gradient-to-r from-gray-50 to-slate-50 p-6 rounded-2xl border border-gray-100 space-y-4">
                        <div class="flex">
                            <span class="font-semibold w-28 text-gray-500 flex-shrink-0">Diagnosa</span>
                            <span class="text-gray-800 font-medium">: {{ $kunjungan->rekamMedis->diagnosa }}</span>
                        </div>
                        <div class="flex">
                            <span class="font-semibold w-28 text-gray-500 flex-shrink-0">Tindakan</span>
                            <span class="text-gray-800">: {{ $kunjungan->rekamMedis->tindakan ?? 'Tidak ada tindakan khusus' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Cost Details -->
                <div class="mb-8">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="p-2 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl shadow">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-800 text-lg">Rincian Biaya</h3>
                    </div>
                    
                    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gradient-to-r from-gray-50 to-slate-50 border-b border-gray-200">
                                    <th class="py-3 px-4 text-left font-bold text-gray-600 uppercase text-xs tracking-wider">Deskripsi</th>
                                    <th class="py-3 px-4 text-center font-bold text-gray-600 uppercase text-xs tracking-wider">Qty</th>
                                    <th class="py-3 px-4 text-right font-bold text-gray-600 uppercase text-xs tracking-wider">Harga</th>
                                    <th class="py-3 px-4 text-right font-bold text-gray-600 uppercase text-xs tracking-wider">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <!-- Jasa Dokter -->
                                <tr class="hover:bg-blue-50/50 transition-colors">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                            <span class="font-medium text-gray-800">Jasa Dokter (Konsultasi)</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-center text-gray-600">1</td>
                                    <td class="py-4 px-4 text-right text-gray-600">Rp {{ number_format($kunjungan->dokter->biaya_jasa ?? 50000, 0, ',', '.') }}</td>
                                    <td class="py-4 px-4 text-right font-semibold text-gray-800">Rp {{ number_format($kunjungan->dokter->biaya_jasa ?? 50000, 0, ',', '.') }}</td>
                                </tr>

                                <!-- Obat-obatan -->
                                @foreach($kunjungan->rekamMedis->obats as $obat)
                                    <tr class="hover:bg-purple-50/50 transition-colors">
                                        <td class="py-4 px-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <span class="font-medium text-gray-800 block">{{ $obat->nama_obat }}</span>
                                                    <span class="text-xs text-purple-600 bg-purple-50 px-2 py-0.5 rounded-full">{{ $obat->pivot->dosis }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 text-center text-gray-600">{{ $obat->pivot->jumlah }} {{ $obat->satuan }}</td>
                                        <td class="py-4 px-4 text-right text-gray-600">Rp {{ number_format($obat->harga, 0, ',', '.') }}</td>
                                        <td class="py-4 px-4 text-right font-semibold text-gray-800">Rp {{ number_format($obat->harga * $obat->pivot->jumlah, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        <!-- Total -->
                        <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 p-5">
                            <div class="flex justify-between items-center text-white">
                                <span class="text-lg font-bold">TOTAL TAGIHAN</span>
                                <span class="text-2xl font-extrabold">Rp {{ number_format($kunjungan->pembayaran->total_harga ?? 0, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Status -->
                <div class="bg-gradient-to-r from-emerald-50 to-green-50 p-6 rounded-2xl border-2 border-emerald-200 mb-8">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/30">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-emerald-600 uppercase font-bold tracking-wider">Status Pembayaran</p>
                                <p class="text-2xl font-extrabold text-emerald-700">LUNAS</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-emerald-600 uppercase font-bold tracking-wider mb-1">Metode Pembayaran</p>
                            <span class="inline-flex items-center px-4 py-2 bg-white rounded-xl text-emerald-700 font-bold text-sm border border-emerald-200 shadow-sm">
                                {{ ucfirst($kunjungan->pembayaran->metode_pembayaran ?? 'Online') }}
                            </span>
                            <p class="text-xs text-emerald-500 mt-2 font-mono">ID: {{ $kunjungan->pembayaran->order_id ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Footer Message -->
                <div class="text-center border-t-2 border-dashed border-gray-200 pt-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-pink-100 to-rose-100 rounded-full mb-4">
                        <span class="text-3xl">🙏</span>
                    </div>
                    <p class="text-gray-700 font-semibold text-lg">Terima kasih atas kepercayaan Anda</p>
                    <p class="text-gray-500 mt-1">Semoga lekas sembuh dan sehat selalu!</p>
                    <div class="mt-6 flex items-center justify-center gap-2 text-xs text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Dicetak pada: {{ now()->format('d M Y, H:i') }} WIB
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex flex-wrap items-center justify-center gap-4 no-print">
            <button onclick="window.print()" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-2xl shadow-xl shadow-blue-500/30 hover:shadow-2xl hover:shadow-blue-500/40 transform hover:-translate-y-1 transition-all duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak / Simpan PDF
            </button>
            <a href="{{ route('pasiens.landingpage') }}" class="inline-flex items-center px-6 py-3 bg-white border-2 border-gray-200 text-gray-700 font-semibold rounded-2xl hover:bg-gray-50 hover:border-gray-300 transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Dashboard
            </a>
        </div>
    </div>

</body>
</html>