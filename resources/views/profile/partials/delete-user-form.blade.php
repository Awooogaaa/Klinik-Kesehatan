<section class="bg-white rounded-2xl border border-red-100 overflow-hidden">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-red-500 to-rose-600 px-6 py-5">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-white">
                    {{ __('Hapus Akun') }}
                </h2>
                <p class="text-red-100 text-sm">
                    {{ __('Tindakan ini tidak dapat dibatalkan.') }}
                </p>
            </div>
        </div>
    </div>

    <div class="p-6">
        <!-- Warning Box -->
        <div class="p-4 bg-gradient-to-r from-red-50 to-rose-50 border-2 border-dashed border-red-200 rounded-xl mb-6">
            <div class="flex items-start space-x-3">
                <div class="p-2 bg-red-100 rounded-lg">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-red-800">Peringatan!</p>
                    <p class="text-xs text-red-600 mt-1">
                        {{ __('Setelah akun dihapus, semua data dan informasi akan dihapus secara permanen. Pastikan Anda sudah mengunduh data yang ingin disimpan sebelum melanjutkan.') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Delete Button -->
        <button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-500 to-rose-600 text-white font-bold rounded-xl shadow-lg shadow-red-500/30 hover:shadow-xl hover:from-red-600 hover:to-rose-700 transform hover:-translate-y-0.5 transition-all duration-200"
        >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            {{ __('Hapus Akun Saya') }}
        </button>
    </div>

    <!-- Delete Confirmation Modal -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-0">
            @csrf
            @method('delete')

            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-red-500 to-rose-600 px-6 py-5">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-white/20 rounded-xl">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">
                            {{ __('Konfirmasi Hapus Akun') }}
                        </h2>
                        <p class="text-red-100 text-sm">
                            {{ __('Tindakan ini permanen dan tidak dapat dibatalkan') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-4">
                <div class="p-4 bg-red-50 border border-red-100 rounded-xl">
                    <p class="text-sm text-red-700">
                        {{ __('Setelah akun dihapus, semua data akan hilang secara permanen. Masukkan password Anda untuk mengkonfirmasi penghapusan akun.') }}
                    </p>
                </div>

                <div class="space-y-2">
                    <label for="password" class="flex items-center text-sm font-bold text-gray-700">
                        <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        {{ __('Password') }}
                    </label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-red-500 focus:ring-red-500 transition-all duration-200"
                        placeholder="{{ __('Masukkan password untuk konfirmasi') }}"
                    />
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end space-x-3">
                <button 
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="inline-flex items-center px-5 py-2.5 bg-white border-2 border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all duration-200"
                >
                    {{ __('Batal') }}
                </button>
                <button 
                    type="submit"
                    class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-red-500 to-rose-600 text-white font-semibold rounded-xl shadow-lg shadow-red-500/30 hover:shadow-xl hover:from-red-600 hover:to-rose-700 transition-all duration-200"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    {{ __('Ya, Hapus Akun') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
