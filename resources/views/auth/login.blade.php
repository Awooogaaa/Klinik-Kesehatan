<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk Akun - Klinik Sehat</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        
        @keyframes float-reverse {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(20px) rotate(-5deg); }
        }
        
        @keyframes pulse-glow {
            0%, 100% { opacity: 0.5; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
        }
        
        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-reverse { animation: float-reverse 7s ease-in-out infinite; }
        .animate-pulse-glow { animation: pulse-glow 4s ease-in-out infinite; }
        .animate-gradient { 
            background-size: 200% 200%;
            animation: gradient-shift 8s ease infinite; 
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        
        .input-modern {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .input-modern:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 40px -10px rgba(59, 130, 246, 0.3);
        }
        
        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #6B8DD6 100%);
            background-size: 200% 200%;
            transition: all 0.4s ease;
        }
        
        .btn-gradient:hover {
            background-position: 100% 0;
            transform: translateY(-3px);
            box-shadow: 0 20px 40px -15px rgba(102, 126, 234, 0.5);
        }
        
        .decoration-circle {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
        }
        
        .medical-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 5v50M5 30h50' stroke='%23ffffff' stroke-width='2' fill='none' opacity='0.1'/%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="min-h-screen overflow-hidden">
    <!-- Animated Background -->
    <div class="fixed inset-0 bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-800 animate-gradient">
        <!-- Decorative Elements -->
        <div class="decoration-circle w-96 h-96 bg-blue-500/30 -top-20 -left-20 animate-float"></div>
        <div class="decoration-circle w-80 h-80 bg-purple-500/30 top-1/3 -right-10 animate-float-reverse"></div>
        <div class="decoration-circle w-72 h-72 bg-pink-500/30 bottom-10 left-1/4 animate-pulse-glow"></div>
        <div class="decoration-circle w-64 h-64 bg-indigo-500/30 -bottom-10 right-1/3 animate-float"></div>
        
        <!-- Grid Pattern Overlay -->
        <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>

    <div class="relative min-h-screen flex items-center justify-center p-4 lg:p-8">
        <div class="w-full max-w-6xl flex flex-col lg:flex-row glass-card rounded-3xl shadow-2xl overflow-hidden border border-white/20">
            
            <!-- Left Side - Branding -->
            <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden">
                <!-- Gradient Background -->
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 animate-gradient"></div>
                
                <!-- Medical Pattern -->
                <div class="absolute inset-0 medical-pattern"></div>
                
                <!-- Floating Medical Icons -->
                <div class="absolute top-20 left-10 text-white/20 animate-float">
                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
                    </svg>
                </div>
                <div class="absolute top-40 right-16 text-white/15 animate-float-reverse">
                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 3c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm7 13H5v-.23c0-.62.28-1.2.76-1.58C7.47 15.82 9.64 15 12 15s4.53.82 6.24 2.19c.48.38.76.97.76 1.58V19z"/>
                    </svg>
                </div>
                <div class="absolute bottom-32 left-20 text-white/20 animate-pulse-glow">
                    <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M10.5 13H8v-3h2.5V7.5h3V10H16v3h-2.5v2.5h-3V13zM12 2L4 5v6.09c0 5.05 3.41 9.76 8 10.91 4.59-1.15 8-5.86 8-10.91V5l-8-3z"/>
                    </svg>
                </div>
                <div class="absolute bottom-20 right-10 text-white/10 animate-float">
                    <svg class="w-14 h-14" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </div>
                
                <!-- Content -->
                <div class="relative z-10 flex flex-col justify-center h-full p-12 text-white">
                    <!-- Logo -->
                    <div class="mb-8">
                        <div class="inline-flex items-center space-x-2 bg-white/10 backdrop-blur-sm rounded-2xl px-4 py-2">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-indigo-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M10.5 13H8v-3h2.5V7.5h3V10H16v3h-2.5v2.5h-3V13zM12 2L4 5v6.09c0 5.05 3.41 9.76 8 10.91 4.59-1.15 8-5.86 8-10.91V5l-8-3z"/>
                                </svg>
                            </div>
                            <span class="font-bold text-xl">Klinik<span class="text-pink-300">Sehat</span></span>
                        </div>
                    </div>
                    
                    <!-- Main Text -->
                    <h1 class="text-5xl font-extrabold mb-4 leading-tight">
                        Selamat<br/>
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-pink-300 to-yellow-300">Datang!</span>
                    </h1>
                    <p class="text-lg text-white/80 mb-8 max-w-md">
                        Platform kesehatan terintegrasi untuk mengelola rekam medis, jadwal kunjungan, dan layanan kesehatan Anda.
                    </p>
                    
                    <!-- Features -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                                </svg>
                            </div>
                            <span class="text-white/90">Rekam medis digital & aman</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                                </svg>
                            </div>
                            <span class="text-white/90">Jadwal kunjungan mudah</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                                </svg>
                            </div>
                            <span class="text-white/90">Akses 24/7 dari mana saja</span>
                        </div>
                    </div>
                    
                    <!-- Decorative Dots -->
                    <div class="absolute bottom-8 left-12 flex space-x-2">
                        <span class="w-3 h-3 bg-white rounded-full"></span>
                        <span class="w-3 h-3 bg-white/50 rounded-full"></span>
                        <span class="w-3 h-3 bg-white/25 rounded-full"></span>
                    </div>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="w-full lg:w-1/2 p-8 sm:p-12 lg:p-16 flex items-center justify-center bg-white">
                <div class="w-full max-w-md">
                    <!-- Mobile Logo -->
                    <div class="lg:hidden mb-8 text-center">
                        <div class="inline-flex items-center space-x-2">
                            <div class="w-12 h-12 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M10.5 13H8v-3h2.5V7.5h3V10H16v3h-2.5v2.5h-3V13zM12 2L4 5v6.09c0 5.05 3.41 9.76 8 10.91 4.59-1.15 8-5.86 8-10.91V5l-8-3z"/>
                                </svg>
                            </div>
                            <span class="font-bold text-2xl text-gray-800">Klinik<span class="text-purple-600">Sehat</span></span>
                        </div>
                    </div>

                    <!-- Header -->
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">Masuk ke Akun</h2>
                        <p class="text-gray-500">
                            Belum punya akun? 
                            <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-purple-600 transition-colors duration-300">Buat akun baru</a>
                        </p>
                    </div>

                    <x-auth-session-status class="mb-4 p-4 bg-green-50 text-green-700 rounded-xl" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email -->
                        <div class="space-y-2">
                            <label for="email" class="text-sm font-medium text-gray-700">Email</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </div>
                                <input id="email" name="email" type="email" autocomplete="email" required 
                                    class="input-modern block w-full py-4 pl-12 pr-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white text-sm placeholder-gray-400" 
                                    placeholder="nama@email.com"
                                    value="{{ old('email') }}" autofocus>
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="text-red-500 text-sm" />
                        </div>

                        <!-- Password -->
                        <div class="space-y-2">
                            <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <input id="password" name="password" type="password" autocomplete="current-password" required 
                                    class="input-modern block w-full py-4 pl-12 pr-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white text-sm placeholder-gray-400" 
                                    placeholder="••••••••">
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="text-red-500 text-sm" />
                        </div>

                        <!-- Remember & Forgot -->
                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="flex items-center cursor-pointer">
                                <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm font-medium text-indigo-600 hover:text-purple-600 transition-colors">
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-gradient w-full py-4 px-6 text-white font-semibold rounded-xl shadow-lg relative overflow-hidden group">
                            <span class="relative z-10 flex items-center justify-center">
                                Masuk
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </span>
                        </button>
                    </form>

                    <!-- Divider -->
                  
                </div>
            </div>
        </div>
    </div>
</body>
</html>