<section class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-violet-500 to-purple-600 px-6 py-5">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-white">
                    {{ __('Informasi Profil') }}
                </h2>
                <p class="text-violet-100 text-sm">
                    {{ __("Perbarui informasi profil dan alamat email akun Anda.") }}
                </p>
            </div>
        </div>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="p-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Avatar Preview -->
        <div class="flex items-center space-x-5 pb-6 border-b border-gray-100">
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center text-white text-3xl font-bold shadow-xl shadow-violet-500/30">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900">{{ $user->name }}</h3>
                <p class="text-gray-500 text-sm">{{ $user->email }}</p>
                <span class="inline-flex items-center mt-2 px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-violet-100 to-purple-100 text-violet-700 border border-violet-200">
                    {{ ucfirst($user->role) }}
                </span>
            </div>
        </div>

        <!-- Name Input -->
        <div class="space-y-2">
            <label for="name" class="flex items-center text-sm font-bold text-gray-700">
                <svg class="w-4 h-4 mr-2 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                {{ __('Nama Lengkap') }}
            </label>
            <input 
                id="name" 
                name="name" 
                type="text" 
                class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-violet-500 focus:ring-violet-500 transition-all duration-200 text-gray-700 font-medium" 
                value="{{ old('name', $user->name) }}" 
                required 
                autofocus 
                autocomplete="name"
                placeholder="Masukkan nama lengkap Anda"
            />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email Input -->
        <div class="space-y-2">
            <label for="email" class="flex items-center text-sm font-bold text-gray-700">
                <svg class="w-4 h-4 mr-2 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                {{ __('Alamat Email') }}
            </label>
            <input 
                id="email" 
                name="email" 
                type="email" 
                class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-violet-500 focus:ring-violet-500 transition-all duration-200 text-gray-700 font-medium" 
                value="{{ old('email', $user->email) }}" 
                required 
                autocomplete="username"
                placeholder="contoh@email.com"
            />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 p-4 bg-gradient-to-r from-amber-50 to-yellow-50 border border-amber-200 rounded-xl">
                    <div class="flex items-start space-x-3">
                        <div class="p-2 bg-amber-100 rounded-lg">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-amber-800">
                                {{ __('Email belum terverifikasi') }}
                            </p>
                            <p class="text-xs text-amber-600 mt-1">
                                <button form="send-verification" class="font-bold text-amber-700 hover:text-amber-900 underline transition-colors">
                                    {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                                </button>
                            </p>
                        </div>
                    </div>

                    @if (session('status') === 'verification-link-sent')
                        <div class="mt-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                            <p class="text-sm font-medium text-green-600 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ __('Link verifikasi baru telah dikirim ke email Anda.') }}
                            </p>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-100">
            <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-violet-500 to-purple-600 text-white font-bold rounded-xl shadow-lg shadow-violet-500/30 hover:shadow-xl hover:from-violet-600 hover:to-purple-700 transform hover:-translate-y-0.5 transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ __('Simpan Perubahan') }}
            </button>

            @if (session('status') === 'profile-updated')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform translate-x-4"
                    x-transition:enter-end="opacity-100 transform translate-x-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    x-init="setTimeout(() => show = false, 3000)"
                    class="inline-flex items-center px-4 py-2 bg-green-50 border border-green-200 rounded-xl"
                >
                    <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-semibold text-green-600">{{ __('Tersimpan!') }}</span>
                </div>
            @endif
        </div>
    </form>
</section>
