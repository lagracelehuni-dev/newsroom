import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: '0.0.0.0',
        port: 5173,
        hmr: {
        host: '127.0.0.1', // ← ton IP ici aussi
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/scss/styles.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
