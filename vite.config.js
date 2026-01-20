import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    // TAMBAHKAN BAGIAN SERVER INI
    server: {
        // Mengizinkan semua host (penting untuk ngrok)
        host: '0.0.0.0', 
        // Mengaktifkan CORS agar browser tidak memblokir
        cors: true,
        hmr: {
            // Memaksa browser tetap menghubungi localhost untuk update real-time
            host: 'localhost', 
        },
    },
});