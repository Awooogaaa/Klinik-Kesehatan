<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50 py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">
            
            <div class="relative bg-white rounded-3xl p-8 md:p-12 shadow-lg border border-blue-100 overflow-hidden">
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-blue-50 rounded-full blur-3xl opacity-60 pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-60 h-60 bg-purple-50 rounded-full blur-3xl opacity-60 pointer-events-none"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
                    <div>
                        <span class="bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full mb-4 inline-block shadow-sm">
                            Dashboard Pasien
                        </span>
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 leading-tight">
                            Halo, <span class="text-blue-600 relative inline-block">
                                {{ Auth::user()->name }}! 👋
                                <svg class="absolute w-full h-2 -bottom-1 left-0 text-blue-200 -z-10" viewBox="0 0 100 10" preserveAspectRatio="none">
                                    <path d="M0 5 Q 50 10 100 5" stroke="currentColor" stroke-width="8" fill="none" />
                                </svg>
                            </span>
                        </h1>
                        <p class="text-gray-600 text-lg max-w-2xl leading-relaxed">
                            Kesehatan Anda adalah prioritas kami. Gunakan dashboard ini untuk mendaftar berobat, mengelola data keluarga, dan memantau riwayat pemeriksaan dengan mudah.
                        </p>
                    </div>
                    
                    <div class="flex gap-4">
                        <div class="bg-white p-5 rounded-2xl border border-blue-100 text-center min-w-[120px] shadow-sm hover:shadow-md transition duration-300">
                            <p class="text-3xl font-bold text-blue-600">{{ $keluarga->count() }}</p>
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wide mt-1">Anggota Keluarga</p>
                        </div>
                        <div class="bg-white p-5 rounded-2xl border border-green-100 text-center min-w-[120px] shadow-sm hover:shadow-md transition duration-300">
                            <p class="text-3xl font-bold text-green-600">{{ $riwayat->where('status', 'selesai')->count() }}</p>
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wide mt-1">Kunjungan Selesai</p>
                        </div>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-xl shadow-sm relative overflow-hidden flex items-center">
                    <div class="bg-green-100 p-2 rounded-full mr-3">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl shadow-sm relative overflow-hidden flex items-center">
                    <div class="bg-red-100 p-2 rounded-full mr-3">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="font-medium">{{ session('error') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2">
                    <div class="bg-white p-8 rounded-3xl shadow-sm hover:shadow-xl transition duration-500 border border-gray-100 h-full relative group">
                        
                        <div class="flex items-center gap-5 mb-8">
                            <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition duration-300 shadow-sm shadow-blue-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">Daftar Berobat Baru</h2>
                                <p class="text-gray-500 text-sm mt-1">Ajukan keluhan untuk diri sendiri atau keluarga dengan mudah</p>
                            </div>
                        </div>

                        @if($keluarga->isEmpty())
                            <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-8 text-center">
                                <div class="mx-auto w-16 h-16 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mb-4 shadow-sm">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Data Keluarga Kosong</h3>
                                <p class="text-gray-600 mb-6">Silakan tambahkan data anggota keluarga di kolom sebelah kanan terlebih dahulu untuk mulai berobat.</p>
                            </div>
                        @else
                            <form method="post" action="{{ route('pasiens.storeKunjungan') }}" class="space-y-6">
                                @csrf
                                <div>
                                    <x-input-label for="pasien_id" :value="__('Siapa yang sakit?')" class="text-gray-700 font-bold mb-2 ml-1 text-sm uppercase tracking-wide" />
                                    <div class="relative">
                                        <select id="pasien_id" name="pasien_id" class="block w-full border-gray-200 bg-gray-50 rounded-xl focus:border-blue-500 focus:ring-blue-500 py-3.5 pl-4 pr-10 transition duration-200 text-gray-700 font-medium">
                                            @foreach($keluarga as $anggota)
                                                <option value="{{ $anggota->id }}">{{ $anggota->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <x-input-label for="keluhan_awal" :value="__('Keluhan / Gejala')" class="text-gray-700 font-bold mb-2 ml-1 text-sm uppercase tracking-wide" />
                                    <textarea id="keluhan_awal" name="keluhan_awal" class="block w-full border-gray-200 bg-gray-50 rounded-xl focus:border-blue-500 focus:ring-blue-500 p-4 transition duration-200 text-gray-700" rows="4" required placeholder="Contoh: Demam tinggi sejak semalam, pusing, mual..."></textarea>
                                </div>
                                <div class="pt-4">
                                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-full shadow-lg shadow-blue-600/30 transform hover:-translate-y-1 transition duration-300 flex items-center justify-center gap-2 text-lg">
                                        <span>Ajukan Pendaftaran</span>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>

                <div class="space-y-8">
                    
                    <div class="bg-white p-8 rounded-3xl shadow-sm hover:shadow-xl transition duration-500 border border-gray-100 group relative overflow-hidden">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition duration-300 shadow-sm shadow-purple-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-gray-900">Tambah Keluarga</h2>
                        </div>

                        <form method="post" action="{{ route('pasiens.storeKeluarga') }}" class="space-y-4">
                            @csrf
                            <input type="text" name="nama" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:border-purple-500 focus:ring-purple-500 py-3 px-4 text-sm transition" placeholder="Nama Lengkap" required />
                            
                            <div class="grid grid-cols-2 gap-3">
                                <select name="jenis_kelamin" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:border-purple-500 focus:ring-purple-500 py-3 px-4 text-sm text-gray-600 transition">
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                                <input type="date" name="tanggal_lahir" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:border-purple-500 focus:ring-purple-500 py-3 px-4 text-sm text-gray-600 transition" required />
                            </div>
                            
                            <input type="text" name="no_telepon" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:border-purple-500 focus:ring-purple-500 py-3 px-4 text-sm transition" placeholder="No. HP / WhatsApp" required />
                            
                            <textarea name="alamat" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:border-purple-500 focus:ring-purple-500 py-3 px-4 text-sm transition" rows="2" placeholder="Alamat Domisili" required></textarea>
                            
                            <button type="submit" class="w-full bg-white text-purple-600 border-2 border-purple-600 font-bold py-3 rounded-full hover:bg-purple-600 hover:text-white transition duration-300 shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                                Simpan Data
                            </button>
                        </form>
                    </div>

                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-900 mb-4 flex items-center text-sm uppercase tracking-wider">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                            Anggota Terdaftar
                        </h3>
                        <div class="space-y-3 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                            @forelse($keluarga as $item)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-2xl hover:bg-blue-50 transition duration-200 cursor-default group border border-transparent hover:border-blue-100">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold text-white shadow-sm {{ $item->jenis_kelamin == 'Laki-laki' ? 'bg-blue-500' : 'bg-pink-500' }}">
                                            {{ substr($item->nama, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-800 group-hover:text-blue-700 transition">{{ $item->nama }}</p>
                                            <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">{{ $item->jenis_kelamin }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <p class="text-gray-400 text-sm italic">Belum ada data keluarga.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm hover:shadow-lg transition duration-500 border border-gray-100 overflow-hidden">
                <div class="p-8 border-b border-gray-100 flex justify-between items-center bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-teal-100 text-teal-600 rounded-2xl flex items-center justify-center shadow-sm shadow-teal-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Riwayat & Status Kunjungan</h2>
                            <p class="text-gray-500 text-sm">Pantau perkembangan status medis Anda</p>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-8 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal Request</th>
                                <th class="px-8 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pasien</th>
                                <th class="px-8 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-8 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($riwayat as $kunjungan)
                            <tr x-data="{ openJadwal: false, openRekam: false }" class="hover:bg-blue-50/30 transition duration-200 group">
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $kunjungan->created_at->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500 mt-0.5">{{ $kunjungan->created_at->format('H:i') }} WIB</div>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500 mr-3 border border-gray-200 group-hover:bg-blue-100 group-hover:text-blue-600 transition">
                                            {{ substr($kunjungan->pasien->nama, 0, 1) }}
                                        </div>
                                        <div class="text-sm font-medium text-gray-900">{{ $kunjungan->pasien->nama }}</div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    @if($kunjungan->status == 'menunggu')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 border border-yellow-200 shadow-sm">
                                            <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2 animate-pulse"></span> Menunggu
                                        </span>
                                    @elseif($kunjungan->status == 'disetujui')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700 border border-blue-200 shadow-sm">
                                            <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span> Dijadwalkan
                                        </span>
                                    @elseif($kunjungan->status == 'selesai')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200 shadow-sm">
                                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span> Selesai
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200 shadow-sm">
                                            Batal
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap text-sm font-medium">
                                    
                                    {{-- TOMBOL AKSI --}}
                                    @if($kunjungan->status == 'menunggu')
                                        <form action="{{ route('pasiens.destroyKunjungan', $kunjungan->id) }}" method="POST" onsubmit="return confirm('Batalkan?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-white hover:bg-red-600 border border-red-200 px-4 py-2 rounded-full transition duration-300 text-xs font-bold shadow-sm hover:shadow-md">
                                                Batalkan
                                            </button>
                                        </form>

                                    @elseif($kunjungan->status == 'disetujui')
                                        <button @click="openJadwal = true" class="text-blue-600 hover:text-white hover:bg-blue-600 border border-blue-200 px-4 py-2 rounded-full transition duration-300 text-xs font-bold shadow-sm hover:shadow-md">
                                            Lihat Jadwal
                                        </button>

                                        <div x-show="openJadwal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4">
                                            <div class="fixed inset-0 bg-black/20 backdrop-blur-sm transition-opacity" @click="openJadwal = false"></div>
                                            <div class="bg-white rounded-2xl shadow-2xl transform transition-all sm:w-full sm:max-w-md relative z-10 overflow-hidden">
                                                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-white text-center relative overflow-hidden">
                                                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10 blur-xl"></div>
                                                    <h3 class="text-lg font-bold relative z-10">Jadwal Pemeriksaan</h3>
                                                    <p class="text-blue-100 text-sm relative z-10 mt-1">Detail janji temu Anda</p>
                                                </div>
                                                <div class="p-6 space-y-5">
                                                    <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                                                        <span class="text-gray-500 text-sm font-medium">Pasien</span>
                                                        <span class="font-bold text-gray-900">{{ $kunjungan->pasien->nama }}</span>
                                                    </div>
                                                    <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                                                        <span class="text-gray-500 text-sm font-medium">Dokter</span>
                                                        <span class="font-bold text-blue-600">{{ $kunjungan->dokter->nama ?? $kunjungan->dokter->user->name ?? 'Belum ditentukan' }}</span>
                                                    </div>
                                                    @if($kunjungan->dokter && $kunjungan->dokter->spesialis)
                                                    <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                                                        <span class="text-gray-500 text-sm font-medium">Spesialis</span>
                                                        <span class="font-bold text-gray-900">{{ $kunjungan->dokter->spesialis }}</span>
                                                    </div>
                                                    @endif
                                                    <div class="bg-blue-50 p-4 rounded-xl text-center border border-blue-100 mt-2">
                                                        <p class="text-xs text-blue-600 uppercase font-bold tracking-wider mb-1">Waktu Temu</p>
                                                        <p class="text-xl font-bold text-blue-800">
                                                            {{ $kunjungan->waktu_kunjungan ? \Carbon\Carbon::parse($kunjungan->waktu_kunjungan)->translatedFormat('l, d F Y - H:i') : '-' }} WIB
                                                        </p>
                                                    </div>
                                                    <div class="flex items-center justify-center gap-2 text-xs text-gray-400 italic bg-gray-50 p-2 rounded-lg">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                        *Harap datang 15 menit lebih awal.
                                                    </div>
                                                </div>
                                                <div class="bg-gray-50 px-6 py-4 flex justify-center border-t border-gray-100">
                                                    <button type="button" class="w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2.5 bg-white text-sm font-bold text-gray-700 hover:bg-gray-50 hover:text-gray-900 focus:outline-none transition duration-200" @click="openJadwal = false">Tutup</button>
                                                </div>
                                            </div>
                                        </div>

                                    @elseif($kunjungan->status == 'selesai')
                                        <div class="flex space-x-2">
                                            <button @click="openRekam = true" class="text-indigo-600 hover:text-white hover:bg-indigo-600 border border-indigo-200 px-4 py-2 rounded-full transition duration-300 text-xs font-bold shadow-sm hover:shadow-md">
                                                Cek Medis
                                            </button>
                                            <a href="{{ route('pasiens.nota', $kunjungan->id) }}" class="text-green-600 hover:text-white hover:bg-green-600 border border-green-200 px-4 py-2 rounded-full transition duration-300 text-xs font-bold flex items-center gap-1 shadow-sm hover:shadow-md">
                                                <span>Nota</span>
                                            </a>
                                        </div>

                                        <div x-show="openRekam" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4">
                                            <div class="fixed inset-0 bg-black/20 backdrop-blur-sm transition-opacity" @click="openRekam = false"></div>
                                            <div class="bg-white rounded-2xl shadow-2xl transform transition-all sm:w-full sm:max-w-md relative z-10 max-h-[90vh] overflow-y-auto">
                                                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-6 text-white flex justify-between items-center relative overflow-hidden">
                                                    <div class="absolute top-0 left-0 w-24 h-24 bg-white/10 rounded-full -ml-10 -mt-10 blur-xl"></div>
                                                    <div class="relative z-10">
                                                        <h3 class="text-lg font-bold">Detail Rekam Medis</h3>
                                                        <p class="text-indigo-100 text-xs mt-1">{{ $kunjungan->created_at->format('d M Y') }}</p>
                                                    </div>
                                                    <span class="bg-white/20 px-3 py-1 rounded-full text-xs font-bold backdrop-blur-sm relative z-10">Selesai</span>
                                                </div>
                                                
                                                <div class="p-6 space-y-6">
                                                    @if($kunjungan->rekamMedis)
                                                        <div class="space-y-5">
                                                            <div>
                                                                <p class="text-xs text-gray-400 uppercase font-bold mb-1.5 ml-1 tracking-wide">Keluhan Awal</p>
                                                                <div class="bg-gray-50 p-3.5 rounded-xl border border-gray-100">
                                                                    <p class="text-gray-800 text-sm font-medium">{{ $kunjungan->rekamMedis->keluhan }}</p>
                                                                </div>
                                                            </div>
                                                            
                                                            <div>
                                                                <p class="text-xs text-gray-400 uppercase font-bold mb-1.5 ml-1 tracking-wide">Diagnosa</p>
                                                                <div class="bg-indigo-50 border-l-4 border-indigo-500 p-3.5 rounded-r-xl">
                                                                    <p class="text-indigo-900 font-bold text-sm">{{ $kunjungan->rekamMedis->diagnosa }}</p>
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <p class="text-xs text-gray-400 uppercase font-bold mb-1.5 ml-1 tracking-wide">Tindakan</p>
                                                                <p class="text-gray-800 text-sm ml-1 font-medium">{{ $kunjungan->rekamMedis->tindakan ?? '-' }}</p>
                                                            </div>

                                                            <div class="border-t border-gray-100 pt-5">
                                                                <h4 class="font-bold text-gray-800 text-sm mb-3 flex items-center gap-2">
                                                                    <span class="bg-purple-100 p-1.5 rounded-lg text-purple-600">💊</span> Resep Obat
                                                                </h4>
                                                                @if($kunjungan->rekamMedis->obats->isNotEmpty())
                                                                    <ul class="space-y-2">
                                                                        @foreach($kunjungan->rekamMedis->obats as $obat)
                                                                            <li class="flex justify-between items-center bg-gray-50 px-3.5 py-2.5 rounded-xl border border-gray-100 text-sm hover:border-purple-200 transition duration-200 group">
                                                                                <div>
                                                                                    <span class="font-bold text-gray-800 block group-hover:text-purple-700 transition">{{ $obat->nama_obat }}</span>
                                                                                    <span class="text-xs text-gray-500">{{ $obat->pivot->jumlah }} {{ $obat->satuan }}</span>
                                                                                </div>
                                                                                <span class="text-[10px] font-bold text-purple-600 bg-white px-2 py-1 rounded-lg border border-purple-100 shadow-sm">
                                                                                    {{ $obat->pivot->dosis }}
                                                                                </span>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @else
                                                                    <div class="text-center py-3 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                                                                        <p class="text-gray-400 italic text-xs">Tidak ada resep obat.</p>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="text-center py-10">
                                                            <div class="bg-red-50 w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-3 text-red-500 animate-pulse">
                                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                            </div>
                                                            <p class="text-gray-500 font-medium">Data detail belum tersedia.</p>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="bg-gray-50 px-6 py-4 flex justify-center rounded-b-2xl border-t border-gray-100">
                                                    <button type="button" class="w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2.5 bg-white text-sm font-bold text-gray-700 hover:bg-gray-50 hover:text-gray-900 focus:outline-none transition duration-200" @click="openRekam = false">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-16 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="bg-gray-50 p-5 rounded-full mb-4 shadow-sm">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <p class="font-medium text-lg text-gray-600">Belum ada riwayat kunjungan.</p>
                                        <p class="text-sm text-gray-400 mt-1">Mulai dengan mendaftar berobat baru.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>