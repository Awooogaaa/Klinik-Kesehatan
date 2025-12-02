<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Klinik Kesehatan - Layanan Medis Terpercaya</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-700 bg-white">

    <nav class="fixed w-full z-50 bg-white/95 backdrop-blur-md shadow-sm border-b border-gray-100 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-2">
                    <div class="bg-blue-600 p-2 rounded-lg text-white shadow-lg shadow-blue-600/20">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                    <span class="font-bold text-2xl tracking-tight text-gray-900">Klinik<span class="text-blue-600">Sehat</span></span>
                </div>

                <div class="hidden md:flex space-x-8 items-center">
                    <a href="#home" class="text-sm font-semibold text-gray-600 hover:text-blue-600 transition duration-300">Beranda</a>
                    <a href="#about" class="text-sm font-semibold text-gray-600 hover:text-blue-600 transition duration-300">Tentang</a>
                    <a href="#services" class="text-sm font-semibold text-gray-600 hover:text-blue-600 transition duration-300">Layanan</a>
                    <a href="#doctors" class="text-sm font-semibold text-gray-600 hover:text-blue-600 transition duration-300">Dokter</a>
                    <a href="#faq" class="text-sm font-semibold text-gray-600 hover:text-blue-600 transition duration-300">FAQ</a>
                </div>

                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-blue-600">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="hidden md:block text-gray-600 hover:text-blue-600 font-medium text-sm">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-full text-sm font-bold transition shadow-lg shadow-blue-600/30 transform hover:-translate-y-0.5">
                                    Daftar Sekarang
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <section id="home" class="pt-32 pb-20 bg-gradient-to-br from-blue-50 via-white to-blue-50 overflow-hidden relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="relative z-10 order-2 md:order-1">
                    <span class="bg-blue-100 text-blue-700 text-xs font-bold px-4 py-1.5 rounded-full mb-6 inline-flex items-center gap-2 shadow-sm">
                        <span class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></span>
                        Klinik Kesehatan Terpercaya No. 1
                    </span>
                    <h1 class="text-5xl md:text-6xl font-bold leading-tight mb-6 text-gray-900">
                        Kesehatan Anda Adalah <span class="text-blue-600 relative inline-block">
                            Prioritas
                            <svg class="absolute w-full h-3 -bottom-1 left-0 text-blue-200 -z-10" viewBox="0 0 100 10" preserveAspectRatio="none">
                                <path d="M0 5 Q 50 10 100 5" stroke="currentColor" stroke-width="8" fill="none" />
                            </svg>
                        </span> Utama Kami
                    </h1>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed max-w-lg">
                        Kami menyediakan layanan kesehatan terbaik dengan pendekatan personal, teknologi modern, dan tenaga medis profesional untuk keluarga Anda.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('login') }}" class="px-8 py-4 bg-blue-600 text-white rounded-full font-bold shadow-xl shadow-blue-600/20 hover:bg-blue-700 hover:shadow-blue-600/40 transition transform hover:-translate-y-1 text-center">
                            Buat Janji Temu
                        </a>
                        <a href="#services" class="px-8 py-4 bg-white text-gray-700 border border-gray-200 rounded-full font-bold hover:border-blue-600 hover:text-blue-600 transition text-center shadow-sm hover:bg-blue-50">
                            Lihat Layanan
                        </a>
                    </div>
                    
                    <div class="mt-12 flex gap-10 border-t border-gray-200 pt-8">
                        <div>
                            <p class="text-3xl font-bold text-gray-900">24/7</p>
                            <p class="text-sm text-gray-500 font-medium">Layanan IGD</p>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-gray-900">50+</p>
                            <p class="text-sm text-gray-500 font-medium">Dokter Spesialis</p>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-gray-900">15k+</p>
                            <p class="text-sm text-gray-500 font-medium">Pasien Sembuh</p>
                        </div>
                    </div>
                </div>
                
                <div class="relative order-1 md:order-2">
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-gradient-to-r from-blue-200 to-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"></div>
                    <img src="{{ asset('images/dokter.png') }}" 
                         alt="Dokter Profesional" 
                         class="relative rounded-3xl shadow-2xl z-10 w-full max-w-96 mx-auto object-cover transform hover:scale-[1.02] transition duration-500 border-4 border-white">
                    
                    <div class="absolute bottom-10 -left-4 bg-white/90 backdrop-blur p-4 rounded-2xl shadow-xl z-20 hidden md:flex items-center gap-4 animate-bounce-slow border border-white">
                        <div class="bg-green-100 p-3 rounded-full text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">Terverifikasi</p>
                            <p class="text-xs text-gray-500">ISO 9001:2015</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                <div class="relative">
                    <div class="absolute -top-4 -left-4 w-24 h-24 bg-blue-100 rounded-full -z-10"></div>
                    <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-yellow-50 rounded-full -z-10"></div>
                    <div class="aspect-video bg-gray-200 rounded-2xl overflow-hidden shadow-lg relative">
                         <img src="{{asset('images/rumahsakit.png')}}" alt="Tentang Kami" class="w-full h-full object-cover">
                    </div>
                </div>
                <div>
                    <h2 class="text-blue-600 font-bold tracking-wide uppercase text-sm mb-2">Tentang Kami</h2>
                    <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Dedikasi Penuh untuk Kesehatan Masyarakat</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Sejak didirikan pada tahun 2010, Klinik Sehat telah berkomitmen untuk memberikan akses kesehatan yang mudah, terjangkau, dan berkualitas tinggi bagi masyarakat. Kami menggabungkan keahlian medis dengan teknologi terkini.
                    </p>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-gray-700">Peralatan medis berstandar internasional.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-gray-700">Sistem rekam medis digital yang terintegrasi.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-gray-700">Lingkungan klinik yang nyaman dan higienis.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="services" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-blue-600 font-bold tracking-wide uppercase text-sm">Layanan Kami</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2 mb-4">Solusi Kesehatan Menyeluruh</h2>
                <p class="text-gray-600">Kami menyediakan berbagai layanan medis komprehensif untuk memenuhi kebutuhan kesehatan Anda dari hulu ke hilir.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="group p-8 bg-white rounded-2xl shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 hover:-translate-y-1">
                    <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">Poli Umum</h3>
                    <p class="text-gray-600 mb-4 text-sm leading-relaxed">Pemeriksaan kesehatan umum, diagnosis penyakit ringan hingga kronis, dan konsultasi kesehatan keluarga.</p>
                    <a href="#" class="text-blue-600 font-bold text-sm group-hover:text-blue-700 inline-flex items-center transition">
                        Pelajari Lebih Lanjut <span class="ml-2">→</span>
                    </a>
                </div>

                <div class="group p-8 bg-white rounded-2xl shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 hover:-translate-y-1">
                    <div class="w-14 h-14 bg-teal-100 text-teal-600 rounded-xl flex items-center justify-center mb-6 group-hover:bg-teal-600 group-hover:text-white transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">Rekam Medis Digital</h3>
                    <p class="text-gray-600 mb-4 text-sm leading-relaxed">Sistem pencatatan riwayat kesehatan yang terintegrasi, aman, dan mudah diakses oleh pasien melalui aplikasi.</p>
                    <a href="#" class="text-teal-600 font-bold text-sm group-hover:text-teal-700 inline-flex items-center transition">
                        Pelajari Lebih Lanjut <span class="ml-2">→</span>
                    </a>
                </div>

                <div class="group p-8 bg-white rounded-2xl shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 hover:-translate-y-1">
                    <div class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 group-hover:text-white transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">Farmasi Lengkap</h3>
                    <p class="text-gray-600 mb-4 text-sm leading-relaxed">Layanan obat-obatan lengkap dengan apoteker berlisensi yang siap melayani kebutuhan resep Anda dengan cepat.</p>
                    <a href="#" class="text-indigo-600 font-bold text-sm group-hover:text-indigo-700 inline-flex items-center transition">
                        Pelajari Lebih Lanjut <span class="ml-2">→</span>
                    </a>
                </div>
                 <div class="group p-8 bg-white rounded-2xl shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 hover:-translate-y-1">
                    <div class="w-14 h-14 bg-red-100 text-red-600 rounded-xl flex items-center justify-center mb-6 group-hover:bg-red-600 group-hover:text-white transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">Poli Gigi</h3>
                    <p class="text-gray-600 mb-4 text-sm leading-relaxed">Perawatan gigi dan mulut oleh dokter gigi spesialis dengan peralatan modern dan minim rasa sakit.</p>
                    <a href="#" class="text-red-600 font-bold text-sm group-hover:text-red-700 inline-flex items-center transition">
                        Pelajari Lebih Lanjut <span class="ml-2">→</span>
                    </a>
                </div>
                 <div class="group p-8 bg-white rounded-2xl shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 hover:-translate-y-1">
                    <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center mb-6 group-hover:bg-purple-600 group-hover:text-white transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">Laboratorium</h3>
                    <p class="text-gray-600 mb-4 text-sm leading-relaxed">Cek darah dan pemeriksaan laboratorium lengkap dengan hasil yang akurat dan cepat.</p>
                    <a href="#" class="text-purple-600 font-bold text-sm group-hover:text-purple-700 inline-flex items-center transition">
                        Pelajari Lebih Lanjut <span class="ml-2">→</span>
                    </a>
                </div>
                 <div class="group p-8 bg-white rounded-2xl shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 hover:-translate-y-1">
                    <div class="w-14 h-14 bg-yellow-100 text-yellow-600 rounded-xl flex items-center justify-center mb-6 group-hover:bg-yellow-600 group-hover:text-white transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">IGD 24 Jam</h3>
                    <p class="text-gray-600 mb-4 text-sm leading-relaxed">Layanan gawat darurat yang siap siaga 24 jam dengan ambulan dan tim medis responsif.</p>
                    <a href="#" class="text-yellow-600 font-bold text-sm group-hover:text-yellow-700 inline-flex items-center transition">
                        Pelajari Lebih Lanjut <span class="ml-2">→</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    

    <section class="py-20 bg-blue-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Apa Kata Pasien Kami</h2>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-2xl shadow-sm">
                    <div class="flex text-yellow-400 mb-4">★★★★★</div>
                    <p class="text-gray-600 mb-6 italic">"Pelayanan sangat ramah dan cepat. Dokternya menjelaskan penyakit dengan sangat detail sehingga saya paham betul."</p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center font-bold text-gray-500">R</div>
                        <div class="ml-3">
                            <p class="font-bold text-gray-900">Rina Wati</p>
                            <p class="text-xs text-gray-500">Pasien Poli Umum</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-sm">
                    <div class="flex text-yellow-400 mb-4">★★★★★</div>
                    <p class="text-gray-600 mb-6 italic">"Fasilitas lengkap dan bersih. Anak saya tidak takut saat diperiksa karena dokternya sangat sabar."</p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center font-bold text-gray-500">A</div>
                        <div class="ml-3">
                            <p class="font-bold text-gray-900">Ahmad Zaki</p>
                            <p class="text-xs text-gray-500">Orang Tua Pasien Anak</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-sm">
                    <div class="flex text-yellow-400 mb-4">★★★★★</div>
                    <p class="text-gray-600 mb-6 italic">"Sistem antrian onlinenya sangat membantu, tidak perlu menunggu lama di klinik. Sangat recommended!"</p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center font-bold text-gray-500">D</div>
                        <div class="ml-3">
                            <p class="font-bold text-gray-900">Dewi Sartika</p>
                            <p class="text-xs text-gray-500">Pasien Gigi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="faq" class="py-20 bg-white">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900">Pertanyaan Umum</h2>
            </div>
            <div class="space-y-4">
                <div class="border border-gray-200 rounded-xl p-6 hover:border-blue-300 transition cursor-pointer bg-gray-50">
                    <h3 class="font-bold text-lg text-gray-900">Apakah menerima BPJS Kesehatan?</h3>
                    <p class="text-gray-600 mt-2">Ya, Klinik Sehat bekerja sama dengan BPJS Kesehatan dan berbagai asuransi swasta lainnya.</p>
                </div>
                <div class="border border-gray-200 rounded-xl p-6 hover:border-blue-300 transition cursor-pointer bg-gray-50">
                    <h3 class="font-bold text-lg text-gray-900">Bagaimana cara membuat janji temu?</h3>
                    <p class="text-gray-600 mt-2">Anda dapat membuat janji temu melalui website ini dengan login terlebih dahulu, atau menghubungi kami via WhatsApp.</p>
                </div>
                <div class="border border-gray-200 rounded-xl p-6 hover:border-blue-300 transition cursor-pointer bg-gray-50">
                    <h3 class="font-bold text-lg text-gray-900">Jam berapa klinik buka?</h3>
                    <p class="text-gray-600 mt-2">Poli umum buka Senin-Sabtu 08.00 - 21.00. Layanan IGD tersedia 24 Jam setiap hari.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-blue-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-6">Siap Untuk Memeriksakan Kesehatan Anda?</h2>
            <p class="text-blue-100 text-lg mb-8 max-w-2xl mx-auto">Jangan tunda kesehatan Anda. Segera konsultasikan keluhan Anda dengan dokter ahli kami.</p>
            <div class="flex justify-center gap-4">
                <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-blue-600 rounded-full font-bold shadow-lg hover:bg-gray-100 transition">
                    Daftar Sekarang
                </a>
                <a href="#" class="px-8 py-4 bg-transparent border-2 border-white text-white rounded-full font-bold hover:bg-white/10 transition">
                    Hubungi WhatsApp
                </a>
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-gray-300 pt-16 pb-8 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-2 mb-6">
                         <div class="bg-blue-600 p-2 rounded-lg text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </div>
                        <span class="font-bold text-2xl text-white">Klinik<span class="text-blue-500">Sehat</span></span>
                    </div>
                    <p class="text-gray-400 leading-relaxed max-w-sm mb-6">
                        Memberikan pelayanan kesehatan terbaik dengan hati. Kesehatan Anda adalah kebahagiaan kami. Terpercaya sejak 2010.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition bg-gray-800 p-2 rounded-full"><span class="sr-only">Facebook</span>FB</a>
                        <a href="#" class="text-gray-400 hover:text-white transition bg-gray-800 p-2 rounded-full"><span class="sr-only">Instagram</span>IG</a>
                        <a href="#" class="text-gray-400 hover:text-white transition bg-gray-800 p-2 rounded-full"><span class="sr-only">Twitter</span>TW</a>
                    </div>
                </div>
                
                <div>
                    <h4 class="font-bold text-white text-lg mb-6">Layanan</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="hover:text-blue-500 transition flex items-center gap-2"><span class="text-blue-500">›</span> Poli Umum</a></li>
                        <li><a href="#" class="hover:text-blue-500 transition flex items-center gap-2"><span class="text-blue-500">›</span> Poli Gigi</a></li>
                        <li><a href="#" class="hover:text-blue-500 transition flex items-center gap-2"><span class="text-blue-500">›</span> Cek Lab</a></li>
                        <li><a href="#" class="hover:text-blue-500 transition flex items-center gap-2"><span class="text-blue-500">›</span> Farmasi</a></li>
                        <li><a href="#" class="hover:text-blue-500 transition flex items-center gap-2"><span class="text-blue-500">›</span> IGD 24 Jam</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-bold text-white text-lg mb-6">Kontak Kami</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <span class="mt-1">📍</span>
                            <span>Jl. Kesehatan No. 123<br>Jakarta Selatan, Indonesia</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span>📞</span>
                            <span>(021) 1234-5678</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span>📧</span>
                            <span>info@kliniksehat.com</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">
                <p>&copy; {{ date('Y') }} Klinik Sehat. All rights reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="hover:text-blue-500 transition">Privacy Policy</a>
                    <a href="#" class="hover:text-blue-500 transition">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>