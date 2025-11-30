<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk Akun - Klinik Sehat</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        @keyframes blob {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            33% {
                transform: translate(30px, -50px) scale(1.1);
            }
            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50">
    <div class="min-h-screen flex items-center justify-center p-4 lg:p-0">
        
        <div class="w-full max-w-5xl bg-white shadow-2xl rounded-2xl overflow-hidden flex transform transition-all duration-300">
            
            <div class="hidden lg:flex lg:w-1/2 p-12 bg-blue-600 text-white relative flex-col justify-between overflow-hidden">
                
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute -top-10 -left-10 w-64 h-64 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"></div>
                    <div class="absolute -bottom-20 -right-20 w-96 h-96 bg-blue-800 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-2000"></div>
                </div>

                <div class="relative z-10">
                    <span class="font-bold text-3xl tracking-tight">Klinik<span class="text-blue-200">Sehat</span></span>
                </div>

                <div class="relative z-10 text-center space-y-4">
                    
                      
                    <h2 class="text-4xl font-extrabold tracking-tight">
                        Selamat Datang!
                    </h2>
                    <p class="text-blue-100 text-lg mt-2">
                        Platform kesehatan terintegrasi untuk pasien dan tenaga medis.
                    </p>
                </div>
                
                <div class="relative z-10 flex space-x-2 justify-start">
                    <span class="w-3 h-3 bg-white rounded-full"></span>
                    <span class="w-3 h-3 bg-white/50 rounded-full"></span>
                    <span class="w-3 h-3 bg-white/30 rounded-full"></span>
                </div>
            </div>

            <div class="w-full lg:w-1/2 p-8 sm:p-12 flex items-center justify-center bg-white">
                <div class="w-full max-w-sm">

                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Masuk</h2>
                    <p class="text-sm text-gray-500 mb-8">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-700 transition">Buat akun</a>
                    </p>

                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label for="email" class="sr-only">Email Address</label>
                            <div class="relative">
                                <input id="email" name="email" type="email" autocomplete="email" required 
                                    class="block w-full py-3 pl-10 pr-4 border-b border-gray-300 focus:outline-none focus:border-blue-600 text-sm transition duration-150 ease-in-out placeholder-gray-400" 
                                    placeholder="Masukkan Email Anda"
                                    value="{{ old('email') }}" autofocus>
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <label for="password" class="sr-only">Password</label>
                            <div class="relative">
                                <input id="password" name="password" type="password" autocomplete="current-password" required 
                                    class="block w-full py-3 pl-10 pr-4 border-b border-gray-300 focus:outline-none focus:border-blue-600 text-sm transition duration-150 ease-in-out placeholder-gray-400" 
                                    placeholder="Password Anda">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-between pt-2">
                            <div class="flex items-center">
                                
                                <label for="remember_me" class="ml-2 block text-sm text-gray-600">
                                    
                                </label>
                            </div>

                            @if (Route::has('password.request'))
                                <div class="text-sm">
                                    <a href="{{ route('password.request') }}" class="font-medium text-blue-600 hover:text-blue-500 transition">
                                        Lupa password?
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-base font-semibold rounded-full text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg shadow-blue-600/30 transition duration-300">
                                Masuk
                            </button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</body>
</html>