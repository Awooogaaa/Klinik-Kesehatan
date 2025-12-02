<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun - Klinik Sehat</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
    </style>
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50">
    <div class="min-h-screen flex items-center justify-center p-4 lg:p-0">
        
        <div class="w-full max-w-5xl bg-white shadow-2xl rounded-2xl overflow-hidden flex transform transition-all duration-300">
            
            <!-- BAGIAN KIRI: Visual Branding (Identik dengan Login tapi beda teks) -->
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
                        Bergabunglah Bersama Kami!
                    </h2>
                    <p class="text-blue-100 text-lg mt-2">
                        Buat akun untuk mengakses layanan kesehatan terbaik bagi Anda dan keluarga.
                    </p>
                </div>
                
                <div class="relative z-10 flex space-x-2 justify-start">
                    <span class="w-3 h-3 bg-white rounded-full"></span>
                    <span class="w-3 h-3 bg-white/50 rounded-full"></span>
                    <span class="w-3 h-3 bg-white/30 rounded-full"></span>
                </div>
            </div>

            <!-- BAGIAN KANAN: Form Register -->
            <div class="w-full lg:w-1/2 p-8 sm:p-12 flex items-center justify-center bg-white">
                <div class="w-full max-w-sm">

                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Daftar Akun</h2>
                    <p class="text-sm text-gray-500 mb-8">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700 transition">Masuk di sini</a>
                    </p>

                    <form method="POST" action="{{ route('register') }}" class="space-y-5">
                        @csrf

                        <!-- Name -->
                        <div>
                            <label for="name" class="sr-only">Nama Lengkap</label>
                            <div class="relative">
                                <input id="name" name="name" type="text" required autofocus autocomplete="name"
                                    class="block w-full py-3 pl-10 pr-4 border-b border-gray-300 focus:outline-none focus:border-blue-600 text-sm transition duration-150 ease-in-out placeholder-gray-400" 
                                    placeholder="Nama Lengkap"
                                    value="{{ old('name') }}">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="sr-only">Email Address</label>
                            <div class="relative">
                                <input id="email" name="email" type="email" required autocomplete="username"
                                    class="block w-full py-3 pl-10 pr-4 border-b border-gray-300 focus:outline-none focus:border-blue-600 text-sm transition duration-150 ease-in-out placeholder-gray-400" 
                                    placeholder="Alamat Email"
                                    value="{{ old('email') }}">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="sr-only">Password</label>
                            <div class="relative">
                                <input id="password" name="password" type="password" required autocomplete="new-password"
                                    class="block w-full py-3 pl-10 pr-4 border-b border-gray-300 focus:outline-none focus:border-blue-600 text-sm transition duration-150 ease-in-out placeholder-gray-400" 
                                    placeholder="Password">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="sr-only">Konfirmasi Password</label>
                            <div class="relative">
                                <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                                    class="block w-full py-3 pl-10 pr-4 border-b border-gray-300 focus:outline-none focus:border-blue-600 text-sm transition duration-150 ease-in-out placeholder-gray-400" 
                                    placeholder="Ulangi Password">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <!-- Button -->
                        <div class="pt-6">
                            <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-base font-semibold rounded-full text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg shadow-blue-600/30 transition duration-300">
                                Daftar
                            </button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</body>
</html>