<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun - Klinik Sehat</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Inter', sans-serif; }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-20px); } }
        @keyframes gradient-shift { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-gradient { background-size: 200% 200%; animation: gradient-shift 8s ease infinite; }
        .glass-card { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); }
        .input-modern { transition: all 0.3s ease; }
        .input-modern:focus { transform: translateY(-2px); box-shadow: 0 10px 40px -10px rgba(16, 185, 129, 0.3); }
        .btn-gradient { background: linear-gradient(135deg, #10b981, #059669, #34d399); background-size: 200% 200%; transition: all 0.4s ease; }
        .btn-gradient:hover { background-position: 100% 0; transform: translateY(-3px); box-shadow: 0 20px 40px -15px rgba(16, 185, 129, 0.5); }
        .decoration-circle { position: absolute; border-radius: 50%; filter: blur(60px); }
        .step-active { background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 0 20px rgba(16, 185, 129, 0.4); }
    </style>
</head>
<body class="min-h-screen overflow-hidden">
    <div class="fixed inset-0 bg-gradient-to-br from-emerald-900 via-teal-900 to-cyan-800 animate-gradient">
        <div class="decoration-circle w-96 h-96 bg-emerald-500/30 -top-20 -left-20 animate-float"></div>
        <div class="decoration-circle w-80 h-80 bg-teal-500/30 top-1/3 -right-10"></div>
        <div class="decoration-circle w-72 h-72 bg-cyan-500/30 bottom-10 left-1/4"></div>
    </div>

    <div class="relative min-h-screen flex items-center justify-center p-4 lg:p-8">
        <div class="w-full max-w-6xl flex flex-col lg:flex-row glass-card rounded-3xl shadow-2xl overflow-hidden border border-white/20">
            
            <!-- Left Side -->
            <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-600 animate-gradient"></div>
                <div class="absolute top-20 left-10 text-white/20 animate-float">
                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg>
                </div>
                <div class="relative z-10 flex flex-col justify-center h-full p-12 text-white">
                    <div class="mb-8">
                        <div class="inline-flex items-center space-x-2 bg-white/10 backdrop-blur-sm rounded-2xl px-4 py-2">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-emerald-600" fill="currentColor" viewBox="0 0 24 24"><path d="M10.5 13H8v-3h2.5V7.5h3V10H16v3h-2.5v2.5h-3V13zM12 2L4 5v6.09c0 5.05 3.41 9.76 8 10.91 4.59-1.15 8-5.86 8-10.91V5l-8-3z"/></svg>
                            </div>
                            <span class="font-bold text-xl">Klinik<span class="text-cyan-300">Sehat</span></span>
                        </div>
                    </div>
                    <h1 class="text-5xl font-extrabold mb-4">Bergabung<br/><span class="bg-clip-text text-transparent bg-gradient-to-r from-cyan-300 to-yellow-300">Bersama Kami!</span></h1>
                    <p class="text-lg text-white/80 mb-8 max-w-md">Buat akun untuk mengakses layanan kesehatan terbaik bagi Anda dan keluarga.</p>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3 bg-white/5 rounded-xl p-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-cyan-400 to-emerald-400 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                            </div>
                            <span class="text-white/90">Rekam medis digital terpusat</span>
                        </div>
                        <div class="flex items-center space-x-3 bg-white/5 rounded-xl p-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-teal-400 to-green-400 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                            </div>
                            <span class="text-white/90">Kelola kesehatan keluarga</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side -->
            <div class="w-full lg:w-1/2 p-8 sm:p-12 lg:p-16 flex items-center justify-center bg-white overflow-y-auto max-h-screen">
                <div class="w-full max-w-md">
                    <div class="lg:hidden mb-8 text-center">
                        <div class="inline-flex items-center space-x-2">
                            <div class="w-12 h-12 bg-gradient-to-br from-emerald-600 to-teal-600 rounded-xl flex items-center justify-center">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M10.5 13H8v-3h2.5V7.5h3V10H16v3h-2.5v2.5h-3V13zM12 2L4 5v6.09c0 5.05 3.41 9.76 8 10.91 4.59-1.15 8-5.86 8-10.91V5l-8-3z"/></svg>
                            </div>
                            <span class="font-bold text-2xl text-gray-800">Klinik<span class="text-emerald-600">Sehat</span></span>
                        </div>
                    </div>
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">Buat Akun Baru</h2>
                        <p class="text-gray-500">Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold text-emerald-600 hover:text-teal-600">Masuk di sini</a></p>
                    </div>
                    <form method="POST" action="{{ route('register') }}" class="space-y-5">
                        @csrf
                        <div class="space-y-2">
                            <label for="name" class="text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                </div>
                                <input id="name" name="name" type="text" required autofocus autocomplete="name" class="input-modern block w-full py-4 pl-12 pr-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:bg-white text-sm" placeholder="Masukkan nama lengkap" value="{{ old('name') }}">
                            </div>
                            <x-input-error :messages="$errors->get('name')" class="text-red-500 text-sm" />
                        </div>
                        <div class="space-y-2">
                            <label for="email" class="text-sm font-medium text-gray-700">Alamat Email</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                                </div>
                                <input id="email" name="email" type="email" required autocomplete="username" class="input-modern block w-full py-4 pl-12 pr-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:bg-white text-sm" placeholder="nama@email.com" value="{{ old('email') }}">
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="text-red-500 text-sm" />
                        </div>
                        <div class="space-y-2">
                            <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                </div>
                                <input id="password" name="password" type="password" required autocomplete="new-password" class="input-modern block w-full py-4 pl-12 pr-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:bg-white text-sm" placeholder="Minimal 8 karakter">
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="text-red-500 text-sm" />
                        </div>
                        <div class="space-y-2">
                            <label for="password_confirmation" class="text-sm font-medium text-gray-700">Konfirmasi Password</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" class="input-modern block w-full py-4 pl-12 pr-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:bg-white text-sm" placeholder="Ulangi password Anda">
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="text-red-500 text-sm" />
                        </div>
                        <div class="pt-4">
                            <button type="submit" class="btn-gradient w-full py-4 px-6 text-white font-semibold rounded-xl shadow-lg group">
                                <span class="flex items-center justify-center">Daftar Sekarang <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg></span>
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</body>
</html>