import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/sass/admin.scss',
                'resources/sass/profile.scss',
                'resources/sass/front.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});