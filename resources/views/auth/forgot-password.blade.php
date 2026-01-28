<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password - Klinik Sehat</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Inter', sans-serif; }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-20px); } }
        @keyframes gradient-shift { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }
        @keyframes pulse-ring { 0% { transform: scale(0.8); opacity: 0; } 50% { opacity: 0.5; } 100% { transform: scale(1.3); opacity: 0; } }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-gradient { background-size: 200% 200%; animation: gradient-shift 8s ease infinite; }
        .animate-pulse-ring { animation: pulse-ring 2s ease-in-out infinite; }
        .glass-card { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); }
        .input-modern { transition: all 0.3s ease; }
        .input-modern:focus { transform: translateY(-2px); box-shadow: 0 10px 40px -10px rgba(251, 146, 60, 0.3); }
        .btn-gradient { background: linear-gradient(135deg, #f97316, #ea580c, #fb923c); background-size: 200% 200%; transition: all 0.4s ease; }
        .btn-gradient:hover { background-position: 100% 0; transform: translateY(-3px); box-shadow: 0 20px 40px -15px rgba(249, 115, 22, 0.5); }
        .decoration-circle { position: absolute; border-radius: 50%; filter: blur(60px); }
    </style>
</head>
<body class="min-h-screen overflow-hidden">
    <div class="fixed inset-0 bg-gradient-to-br from-orange-900 via-amber-900 to-yellow-800 animate-gradient">
        <div class="decoration-circle w-96 h-96 bg-orange-500/30 -top-20 -left-20 animate-float"></div>
        <div class="decoration-circle w-80 h-80 bg-amber-500/30 top-1/3 -right-10"></div>
        <div class="decoration-circle w-72 h-72 bg-yellow-500/30 bottom-10 left-1/4"></div>
    </div>

    <div class="relative min-h-screen flex items-center justify-center p-4 lg:p-8">
        <div class="w-full max-w-5xl flex flex-col lg:flex-row glass-card rounded-3xl shadow-2xl overflow-hidden border border-white/20">
            
            <!-- Left Side -->
            <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-orange-600 via-amber-600 to-yellow-600 animate-gradient"></div>
                <div class="absolute top-20 left-10 text-white/20 animate-float">
                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                </div>
                <div class="relative z-10 flex flex-col justify-center h-full p-12 text-white">
                    <div class="mb-8">
                        <div class="inline-flex items-center space-x-2 bg-white/10 backdrop-blur-sm rounded-2xl px-4 py-2">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-orange-600" fill="currentColor" viewBox="0 0 24 24"><path d="M10.5 13H8v-3h2.5V7.5h3V10H16v3h-2.5v2.5h-3V13zM12 2L4 5v6.09c0 5.05 3.41 9.76 8 10.91 4.59-1.15 8-5.86 8-10.91V5l-8-3z"/></svg>
                            </div>
                            <span class="font-bold text-xl">Klinik<span class="text-yellow-300">Sehat</span></span>
                        </div>
                    </div>
                    <!-- Icon with pulse ring -->
                    <div class="relative w-32 h-32 mx-auto mb-8">
                        <div class="absolute inset-0 rounded-full bg-white/20 animate-pulse-ring"></div>
                        <div class="absolute inset-4 rounded-full bg-white/30 animate-pulse-ring" style="animation-delay: 0.5s;"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-24 h-24 rounded-full bg-white/20 flex items-center justify-center">
                                <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12.65 10C11.83 7.67 9.61 6 7 6c-3.31 0-6 2.69-6 6s2.69 6 6 6c2.61 0 4.83-1.67 5.65-4H17v4h4v-4h2v-4H12.65zM7 14c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/></svg>
                            </div>
                        </div>
                    </div>
                    <h1 class="text-4xl font-extrabold mb-4 text-center">Lupa<br/><span class="bg-clip-text text-transparent bg-gradient-to-r from-yellow-300 to-white">Password?</span></h1>
                    <p class="text-lg text-white/80 text-center max-w-sm mx-auto">Jangan khawatir! Kami akan membantu Anda mengatur ulang password dengan mudah.</p>
                </div>
            </div>

            <!-- Right Side -->
            <div class="w-full lg:w-1/2 p-8 sm:p-12 lg:p-16 flex items-center justify-center bg-white">
                <div class="w-full max-w-md">
                    <div class="lg:hidden mb-8 text-center">
                        <div class="inline-flex items-center space-x-2">
                            <div class="w-12 h-12 bg-gradient-to-br from-orange-600 to-amber-600 rounded-xl flex items-center justify-center">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M10.5 13H8v-3h2.5V7.5h3V10H16v3h-2.5v2.5h-3V13zM12 2L4 5v6.09c0 5.05 3.41 9.76 8 10.91 4.59-1.15 8-5.86 8-10.91V5l-8-3z"/></svg>
                            </div>
                            <span class="font-bold text-2xl text-gray-800">Klinik<span class="text-orange-600">Sehat</span></span>
                        </div>
                    </div>

                    <!-- Info Box -->
                    <div class="mb-8 p-4 bg-orange-50 border border-orange-100 rounded-2xl">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Reset Password</h3>
                                <p class="text-sm text-gray-600 mt-1">Masukkan email terdaftar dan kami akan mengirim link untuk mengatur ulang password Anda.</p>
                            </div>
                        </div>
                    </div>

                    <x-auth-session-status class="mb-4 p-4 bg-green-50 text-green-700 rounded-xl" :status="session('status')" />

                    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                        @csrf
                        <div class="space-y-2">
                            <label for="email" class="text-sm font-medium text-gray-700">Alamat Email</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-orange-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                                </div>
                                <input id="email" name="email" type="email" autocomplete="email" required class="input-modern block w-full py-4 pl-12 pr-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 focus:bg-white text-sm" placeholder="nama@email.com" value="{{ old('email') }}" autofocus>
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="text-red-500 text-sm" />
                        </div>

                        <button type="submit" class="btn-gradient w-full py-4 px-6 text-white font-semibold rounded-xl shadow-lg group">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                Kirim Link Reset
                            </span>
                        </button>
                    </form>

                    <div class="mt-8 text-center">
                        <a href="{{ route('login') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-orange-600 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                            Kembali ke halaman login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
