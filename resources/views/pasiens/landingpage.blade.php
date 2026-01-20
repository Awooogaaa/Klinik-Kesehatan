<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-sky-50 via-white to-blue-50 py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- WELCOME HEADER --}}
            <div class="relative bg-gradient-to-r from-sky-500 via-blue-500 to-indigo-500 rounded-3xl p-8 shadow-2xl overflow-hidden">
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-60 h-60 bg-white/10 rounded-full blur-3xl"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="flex items-center space-x-5">
                        <div class="h-20 w-20 rounded-2xl bg-white/20 flex items-center justify-center shadow-xl border-4 border-white/30">
                            <span class="text-white font-bold text-3xl">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</span>
                        </div>
                        <div>
                            <p class="text-sky-100 text-sm font-medium">Selamat datang kembali,</p>
                            <h1 class="text-3xl md:text-4xl font-bold text-white">{{ Auth::user()->name }} 👋</h1>
                            <p class="text-sky-100 mt-1">Semoga sehat selalu! Kami siap membantu Anda.</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-4">
                        <div class="bg-white/20 backdrop-blur-sm p-5 rounded-2xl text-center min-w-[130px] border border-white/30">
                            <p class="text-4xl font-bold text-white">{{ $keluarga->count() }}</p>
                            <p class="text-xs text-sky-100 font-semibold uppercase tracking-wide mt-1">Anggota Keluarga</p>
                        </div>
                        <div class="bg-white/20 backdrop-blur-sm p-5 rounded-2xl text-center min-w-[130px] border border-white/30">
                            <p class="text-4xl font-bold text-white">{{ $riwayat->where('status', 'selesai')->count() }}</p>
                            <p class="text-xs text-sky-100 font-semibold uppercase tracking-wide mt-1">Selesai Berobat</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ALERT MESSAGES --}}
            @if (session('success'))
                <div class="bg-gradient-to-r from-emerald-50 to-green-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-2xl shadow-lg flex items-center">
                    <div class="bg-emerald-100 p-3 rounded-xl mr-4">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <p class="font-semibold">{{ session('success') }}</p>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 text-red-700 p-4 rounded-2xl shadow-lg flex items-center">
                    <div class="bg-red-100 p-3 rounded-xl mr-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="font-semibold">{{ session('error') }}</p>
                </div>
            @endif

            {{-- QUICK ACTION CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="#daftar-berobat" class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl hover:border-blue-200 transform hover:-translate-y-1 transition-all duration-300 group">
                    <div class="flex items-center space-x-4">
                        <div class="p-4 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600">Daftar Berobat</h3>
                            <p class="text-sm text-gray-500">Ajukan pendaftaran baru</p>
                        </div>
                    </div>
                </a>
                
                <a href="#tambah-keluarga" class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl hover:border-purple-200 transform hover:-translate-y-1 transition-all duration-300 group">
                    <div class="flex items-center space-x-4">
                        <div class="p-4 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl shadow-lg shadow-purple-500/30 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-purple-600">Tambah Keluarga</h3>
                            <p class="text-sm text-gray-500">Daftarkan anggota keluarga</p>
                        </div>
                    </div>
                </a>
                
                <a href="#riwayat-medis" class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl hover:border-teal-200 transform hover:-translate-y-1 transition-all duration-300 group">
                    <div class="flex items-center space-x-4">
                        <div class="p-4 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-2xl shadow-lg shadow-teal-500/30 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-teal-600">Riwayat Kunjungan</h3>
                            <p class="text-sm text-gray-500">Lihat status & rekam medis</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- FORM PENDAFTARAN BEROBAT --}}
                <div id="daftar-berobat" class="lg:col-span-2">
                    <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="p-4 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">Daftar Berobat Baru</h2>
                                <p class="text-gray-500 text-sm">Ajukan pendaftaran untuk diri sendiri atau keluarga</p>
                            </div>
                        </div>

                        @if ($keluarga->isEmpty())
                            <div class="bg-gradient-to-r from-amber-50 to-yellow-50 border-2 border-dashed border-amber-200 rounded-2xl p-8 text-center">
                                <div class="mx-auto w-20 h-20 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Data Keluarga Kosong</h3>
                                <p class="text-gray-600 mb-4">Silakan tambahkan data anggota keluarga terlebih dahulu untuk mulai berobat.</p>
                                <a href="#tambah-keluarga" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-600 text-white font-bold rounded-full shadow-lg hover:shadow-xl transition-all">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                    </svg>
                                    Tambah Keluarga Sekarang
                                </a>
                            </div>
                        @else
                            <form method="post" action="{{ route('pasiens.storeKunjungan') }}" class="space-y-6">
                                @csrf
                                
                                {{-- Pilih Pasien --}}
                                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-2xl border border-blue-100">
                                    <label class="block text-sm font-bold text-gray-700 mb-3">
                                        <span class="flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            Siapa yang akan berobat?
                                        </span>
                                    </label>
                                    
                                    {{-- Search Bar for Family Members --}}
                                    @if($keluarga->count() > 4)
                                    <div class="mb-4">
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                                </svg>
                                            </div>
                                            <input type="text" id="searchKeluarga" onkeyup="filterKeluarga()" placeholder="Cari nama anggota keluarga..." 
                                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border-2 border-blue-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-sm transition-all bg-white">
                                        </div>
                                    </div>
                                    @endif
                                    
                                    <div id="keluargaList" class="grid grid-cols-2 md:grid-cols-3 gap-3 max-h-64 overflow-y-auto">
                                        @foreach ($keluarga as $index => $anggota)
                                            <label class="relative cursor-pointer keluarga-item" data-nama="{{ strtolower($anggota->nama) }}">
                                                <input type="radio" name="pasien_id" value="{{ $anggota->id }}" class="peer sr-only" {{ $index == 0 ? 'checked' : '' }}>
                                                <div class="p-4 border-2 border-gray-200 rounded-2xl text-center transition-all duration-200 peer-checked:border-blue-500 peer-checked:bg-white peer-checked:shadow-lg hover:border-gray-300 bg-white">
                                                    <div class="w-12 h-12 mx-auto mb-2 rounded-full flex items-center justify-center text-lg font-bold text-white shadow {{ $anggota->jenis_kelamin == 'Laki-laki' ? 'bg-gradient-to-br from-blue-400 to-indigo-500' : 'bg-gradient-to-br from-pink-400 to-rose-500' }}">
                                                        {{ strtoupper(substr($anggota->nama, 0, 1)) }}
                                                    </div>
                                                    <p class="font-bold text-gray-800 text-sm truncate">{{ $anggota->nama }}</p>
                                                    <p class="text-xs text-gray-500">{{ $anggota->jenis_kelamin }}</p>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                    
                                    <script>
                                        function filterKeluarga() {
                                            const search = document.getElementById('searchKeluarga').value.toLowerCase();
                                            const items = document.querySelectorAll('.keluarga-item');
                                            items.forEach(item => {
                                                const nama = item.getAttribute('data-nama');
                                                item.style.display = nama.includes(search) ? '' : 'none';
                                            });
                                        }
                                    </script>
                                </div>
                                
                                {{-- Keluhan --}}
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-3">
                                        <span class="flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            Apa keluhan yang dirasakan?
                                        </span>
                                    </label>
                                    <textarea 
                                        id="keluhan_awal" 
                                        name="keluhan_awal" 
                                        class="block w-full border-2 border-gray-200 rounded-2xl focus:border-blue-500 focus:ring-blue-500 p-4 text-gray-700 transition-all" 
                                        rows="4" 
                                        required 
                                        placeholder="Contoh: Demam tinggi sejak semalam, pusing, mual..."></textarea>
                                    <p class="text-xs text-gray-400 mt-2 ml-1">💡 Jelaskan keluhan dengan detail agar dokter dapat mempersiapkan pemeriksaan dengan baik.</p>
                                </div>
                                
                                <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-bold py-4 px-6 rounded-2xl shadow-xl shadow-blue-500/30 transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2 text-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Ajukan Pendaftaran Berobat
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                {{-- SIDEBAR KELUARGA --}}
                <div id="tambah-keluarga" class="space-y-6">
                    {{-- Form Tambah Keluarga --}}
                    <div class="bg-white p-6 rounded-3xl shadow-xl border border-gray-100">
                        <div class="flex items-center space-x-3 mb-5">
                            <div class="p-3 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                            </div>
                            <h2 class="text-lg font-bold text-gray-900">Tambah Keluarga</h2>
                        </div>

                        <form method="post" action="{{ route('pasiens.storeKeluarga') }}" class="space-y-4">
                            @csrf
                            <input type="text" name="nama" class="w-full rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-purple-500 py-3 px-4 text-sm transition" placeholder="Nama Lengkap" required />
                            <div class="grid grid-cols-2 gap-3">
                                <select name="jenis_kelamin" class="w-full rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-purple-500 py-3 px-4 text-sm text-gray-600 transition">
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                                <div>
                                    <input type="date" name="tanggal_lahir" class="w-full rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-purple-500 py-3 px-4 text-sm text-gray-600 transition" required />
                                    <p class="text-xs text-gray-400 mt-1 ml-1">📅 Tanggal Lahir</p>
                                </div>
                            </div>
                            <div>
                                <input type="tel" name="no_telepon" pattern="[0-9]*" inputmode="numeric" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="w-full rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-purple-500 py-3 px-4 text-sm transition" placeholder="No. HP / WhatsApp (angka saja)" required />
                                <p class="text-xs text-gray-400 mt-1 ml-1">📱 Hanya boleh angka, contoh: 08123456789</p>
                            </div>
                            <textarea name="alamat" class="w-full rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-purple-500 py-3 px-4 text-sm transition" rows="2" placeholder="Alamat Domisili" required></textarea>
                            <button type="submit" class="w-full bg-gradient-to-r from-purple-500 to-pink-600 text-white font-bold py-3 rounded-xl shadow-lg shadow-purple-500/30 hover:shadow-xl transform hover:-translate-y-0.5 transition-all">
                                <span class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Simpan Data Keluarga
                                </span>
                            </button>
                        </form>
                    </div>

                    {{-- Daftar Anggota Keluarga --}}
                    <div class="bg-white p-6 rounded-3xl shadow-xl border border-gray-100">
                        <h3 class="font-bold text-gray-900 mb-4 flex items-center text-sm">
                            <span class="w-2.5 h-2.5 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                            Anggota Keluarga Terdaftar ({{ $keluarga->count() }})
                        </h3>
                        <div class="space-y-3 max-h-64 overflow-y-auto">
                            @forelse($keluarga as $item)
                                <div class="flex items-center justify-between p-3 bg-gradient-to-r from-gray-50 to-white rounded-xl hover:from-blue-50 hover:to-white transition-all duration-200 border border-gray-100 hover:border-blue-200 group">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-sm font-bold text-white shadow {{ $item->jenis_kelamin == 'Laki-laki' ? 'bg-gradient-to-br from-blue-400 to-indigo-500' : 'bg-gradient-to-br from-pink-400 to-rose-500' }}">
                                            {{ strtoupper(substr($item->nama, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-800 group-hover:text-blue-700 transition">{{ $item->nama }}</p>
                                            <p class="text-xs text-gray-500">{{ $item->jenis_kelamin }} • {{ \Carbon\Carbon::parse($item->tanggal_lahir)->age }} thn</p>
                                        </div>
                                    </div>
                                    <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-bold bg-gray-100 text-gray-600">
                                        {{ $item->no_rekam_medis }}
                                    </span>
                                </div>
                            @empty
                                <div class="text-center py-8 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <p class="text-gray-400 text-sm">Belum ada data keluarga.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIWAYAT & STATUS KUNJUNGAN --}}
            <div id="riwayat-medis" class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-xl shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-900">Riwayat & Status Kunjungan</h2>
                                <p class="text-gray-500 text-sm">Pantau perkembangan status kesehatan Anda</p>
                            </div>
                        </div>
                        
                        {{-- Search Bar for Riwayat --}}
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                                <input type="text" id="searchRiwayat" onkeyup="filterRiwayat()" placeholder="Cari nama atau tanggal..." 
                                    class="w-full md:w-64 pl-10 pr-4 py-2 rounded-xl border-2 border-gray-200 focus:border-teal-500 focus:ring-2 focus:ring-teal-200 text-sm transition-all">
                            </div>
                            
                            {{-- Legend Status --}}
                            <div class="hidden lg:flex items-center space-x-4 text-xs">
                                <span class="flex items-center"><span class="w-2 h-2 bg-yellow-500 rounded-full mr-1.5"></span>Menunggu</span>
                                <span class="flex items-center"><span class="w-2 h-2 bg-blue-500 rounded-full mr-1.5"></span>Dijadwalkan</span>
                                <span class="flex items-center"><span class="w-2 h-2 bg-green-500 rounded-full mr-1.5"></span>Selesai</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <script>
                    function filterRiwayat() {
                        const search = document.getElementById('searchRiwayat').value.toLowerCase();
                        const rows = document.querySelectorAll('.riwayat-row');
                        rows.forEach(row => {
                            const text = row.textContent.toLowerCase();
                            row.style.display = text.includes(search) ? '' : 'none';
                        });
                    }
                </script>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pasien</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Pembayaran</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($riwayat as $kunjungan)
                                <tr x-data="{ openJadwal: false, openRekam: false }" class="hover:bg-blue-50/50 transition duration-200 group riwayat-row">
                                    
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">{{ $kunjungan->created_at->format('d M Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $kunjungan->created_at->format('H:i') }} WIB</div>
                                    </td>

                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-sm font-bold text-white mr-3 shadow {{ $kunjungan->pasien->jenis_kelamin == 'Laki-laki' ? 'bg-gradient-to-br from-blue-400 to-indigo-500' : 'bg-gradient-to-br from-pink-400 to-rose-500' }}">
                                                {{ strtoupper(substr($kunjungan->pasien->nama, 0, 1)) }}
                                            </div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $kunjungan->pasien->nama }}</div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-5 whitespace-nowrap">
                                        @if ($kunjungan->status == 'menunggu')
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-gradient-to-r from-yellow-100 to-amber-100 text-yellow-700 border border-yellow-200 shadow-sm">
                                                <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2 animate-pulse"></span> Menunggu Konfirmasi
                                            </span>
                                        @elseif($kunjungan->status == 'disetujui')
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-700 border border-blue-200 shadow-sm">
                                                <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span> Dijadwalkan
                                            </span>
                                        @elseif($kunjungan->status == 'selesai')
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-gradient-to-r from-green-100 to-emerald-100 text-green-700 border border-green-200 shadow-sm">
                                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span> Selesai
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                                                Batal
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-5 whitespace-nowrap text-center">
                                        @if($kunjungan->status == 'selesai')
                                            @php $pembayaran = $kunjungan->pembayaran; @endphp
                                            @if($pembayaran)
                                                @if($pembayaran->status_pembayaran == 'lunas')
                                                    <div class="flex flex-col items-center gap-2">
                                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-green-100 to-emerald-100 text-green-700 border border-green-200">
                                                            ✓ LUNAS
                                                        </span>
                                                        <a href="{{ route('pasiens.nota', $kunjungan->id) }}" target="_blank" class="text-green-600 hover:text-green-800 text-xs font-bold underline flex items-center gap-1">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                            </svg>
                                                            Lihat Nota
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="flex flex-col items-center gap-2">
                                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 border border-yellow-200 animate-pulse">
                                                            Menunggu Bayar
                                                        </span>
                                                        <a href="{{ route('pembayarans.show', $pembayaran->id) }}" class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-amber-500 to-orange-600 text-white text-xs font-bold rounded-full shadow hover:shadow-lg transition-all">
                                                            Bayar Sekarang
                                                        </a>
                                                    </div>
                                                @endif
                                            @else
                                                <span class="text-xs text-gray-400 italic">Belum ditagih</span>
                                            @endif
                                        @else
                                            <span class="text-gray-300">-</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-5 whitespace-nowrap text-center text-sm font-medium">
                                        @if ($kunjungan->status == 'menunggu')
                                            <form action="{{ route('pasiens.destroyKunjungan', $kunjungan->id) }}" method="POST" onsubmit="return confirm('Batalkan pendaftaran ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-white border-2 border-red-200 text-red-600 rounded-xl text-xs font-bold hover:bg-red-50 hover:border-red-300 transition-all">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                    Batalkan
                                                </button>
                                            </form>
                                        @elseif($kunjungan->status == 'disetujui')
                                            <button x-on:click="openJadwal = true" type="button" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl text-xs font-bold shadow-lg hover:shadow-xl transition-all cursor-pointer">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                Lihat Jadwal
                                            </button>

                                            {{-- MODAL JADWAL --}}
                                            <div x-show="openJadwal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 text-left">
                                                <div class="fixed inset-0 bg-black/30 backdrop-blur-sm transition-opacity" x-on:click="openJadwal = false"></div>
                                                <div class="bg-white rounded-3xl shadow-2xl transform transition-all sm:w-full sm:max-w-md relative z-10 overflow-hidden">
                                                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6 text-white text-center">
                                                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                                                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                            </svg>
                                                        </div>
                                                        <h3 class="text-xl font-bold">Jadwal Pemeriksaan</h3>
                                                        <p class="text-blue-100 text-sm mt-1">Detail janji temu Anda</p>
                                                    </div>
                                                    <div class="p-6 space-y-4">
                                                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                                            <span class="text-gray-500 text-sm">Pasien</span>
                                                            <span class="font-bold text-gray-900">{{ $kunjungan->pasien->nama }}</span>
                                                        </div>
                                                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                                            <span class="text-gray-500 text-sm">Dokter</span>
                                                            <span class="font-bold text-blue-600">{{ $kunjungan->dokter->nama ?? ($kunjungan->dokter->user->name ?? 'Belum ditentukan') }}</span>
                                                        </div>
                                                        @if ($kunjungan->dokter && $kunjungan->dokter->spesialis)
                                                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                                                <span class="text-gray-500 text-sm">Spesialis</span>
                                                                <span class="font-bold text-gray-900">{{ $kunjungan->dokter->spesialis }}</span>
                                                            </div>
                                                        @endif
                                                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-5 rounded-2xl text-center border border-blue-100">
                                                            <p class="text-xs text-blue-600 uppercase font-bold tracking-wider mb-1">Waktu Temu</p>
                                                            <p class="text-xl font-bold text-blue-800">
                                                                {{ $kunjungan->waktu_kunjungan ? \Carbon\Carbon::parse($kunjungan->waktu_kunjungan)->translatedFormat('l, d F Y') : '-' }}
                                                            </p>
                                                            <p class="text-lg font-bold text-indigo-600">
                                                                {{ $kunjungan->waktu_kunjungan ? \Carbon\Carbon::parse($kunjungan->waktu_kunjungan)->format('H:i') . ' WIB' : '' }}
                                                            </p>
                                                        </div>
                                                        <div class="flex items-center justify-center gap-2 text-xs text-amber-600 bg-amber-50 p-3 rounded-xl border border-amber-100">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                            </svg>
                                                            Harap datang 15 menit lebih awal
                                                        </div>
                                                    </div>
                                                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                                                        <button type="button" class="w-full py-3 bg-white border-2 border-gray-200 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50 transition" x-on:click="openJadwal = false">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($kunjungan->status == 'selesai')
                                            <button x-on:click="openRekam = true" type="button" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl text-xs font-bold shadow-lg hover:shadow-xl transition-all cursor-pointer">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                Lihat Rekam Medis
                                            </button>

                                            {{-- MODAL REKAM MEDIS --}}
                                            <div x-show="openRekam" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 text-left">
                                                <div class="fixed inset-0 bg-black/30 backdrop-blur-sm transition-opacity" x-on:click="openRekam = false"></div>
                                                <div class="bg-white rounded-3xl shadow-2xl transform transition-all sm:w-full sm:max-w-lg relative z-10 max-h-[90vh] overflow-y-auto">
                                                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6 text-white">
                                                        <div class="flex justify-between items-center">
                                                            <div>
                                                                <h3 class="text-xl font-bold">Rekam Medis</h3>
                                                                <p class="text-indigo-100 text-sm">{{ $kunjungan->created_at->format('d M Y') }}</p>
                                                            </div>
                                                            <span class="bg-white/20 px-3 py-1 rounded-full text-xs font-bold backdrop-blur-sm">✓ Selesai</span>
                                                        </div>
                                                    </div>

                                                    <div class="p-6 space-y-5">
                                                        @if ($kunjungan->rekamMedis)
                                                            <div class="space-y-4">
                                                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                                                    <p class="text-xs text-gray-400 uppercase font-bold mb-2">Keluhan</p>
                                                                    <p class="text-gray-800 font-medium">{{ $kunjungan->rekamMedis->keluhan }}</p>
                                                                </div>
                                                                <div class="bg-gradient-to-r from-indigo-50 to-purple-50 p-4 rounded-xl border-l-4 border-indigo-500">
                                                                    <p class="text-xs text-indigo-600 uppercase font-bold mb-2">Diagnosa</p>
                                                                    <p class="text-indigo-900 font-bold text-lg">{{ $kunjungan->rekamMedis->diagnosa }}</p>
                                                                </div>
                                                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                                                    <p class="text-xs text-gray-400 uppercase font-bold mb-2">Tindakan</p>
                                                                    <p class="text-gray-800 font-medium">{{ $kunjungan->rekamMedis->tindakan ?? 'Tidak ada tindakan khusus' }}</p>
                                                                </div>
                                                                
                                                                <div class="border-t border-gray-100 pt-4">
                                                                    <h4 class="font-bold text-gray-800 text-sm mb-3 flex items-center gap-2">
                                                                        <span class="bg-purple-100 p-1.5 rounded-lg text-purple-600">💊</span> Resep Obat
                                                                    </h4>
                                                                    @if ($kunjungan->rekamMedis->obats->isNotEmpty())
                                                                        <div class="space-y-2">
                                                                            @foreach ($kunjungan->rekamMedis->obats as $obat)
                                                                                <div class="flex justify-between items-center bg-white px-4 py-3 rounded-xl border border-gray-100 shadow-sm">
                                                                                    <div>
                                                                                        <span class="font-bold text-gray-800 block">{{ $obat->nama_obat }}</span>
                                                                                        <span class="text-xs text-gray-500">{{ $obat->pivot->jumlah }} {{ $obat->satuan }}</span>
                                                                                    </div>
                                                                                    <span class="text-xs font-bold text-purple-600 bg-purple-50 px-3 py-1 rounded-lg border border-purple-100">{{ $obat->pivot->dosis }}</span>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    @else
                                                                        <div class="text-center py-4 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                                                                            <p class="text-gray-400 italic text-sm">Tidak ada resep obat</p>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="text-center py-10">
                                                                <div class="bg-gray-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-400">
                                                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                                    </svg>
                                                                </div>
                                                                <p class="text-gray-500 font-medium">Data rekam medis belum tersedia</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                                                        <button type="button" class="w-full py-3 bg-white border-2 border-gray-200 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50 transition" x-on:click="openRekam = false">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="bg-gray-100 p-6 rounded-full mb-4">
                                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                </svg>
                                            </div>
                                            <p class="font-bold text-lg text-gray-600 mb-1">Belum ada riwayat kunjungan</p>
                                            <p class="text-sm text-gray-400">Mulai dengan mendaftar berobat baru di atas</p>
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