import { defineConfig } from 'vite';
import { resolve } from 'path';
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // Storefront assets
                'resources/js/storefront/app.js',
                'resources/css/storefront/app.css',

                // POS assets
                'resources/js/pos/app.js',
                'resources/css/pos/app.css',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@pos': resolve(__dirname, './resources/js/pos'),
            '@storefront': resolve(__dirname, './resources/js/storefront'),
            '@shared': resolve(__dirname, './resources/js/shared'),
            'ziggy-js': resolve(__dirname, './vendor/tightenco/ziggy')
        }
    },
});
