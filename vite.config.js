import { defineConfig } from 'vite';
import { resolve } from 'path';
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // Storefront assets
                'resources/js/storefront/app.js',
                'resources/js/storefront/app.tsx',
                'resources/css/storefront/app.css',

                // POS assets
                'resources/js/pos/app.js',
                'resources/css/pos/app.css',
            ],
            ssr: 'resources/js/storefront/ssr.tsx',
            refresh: true,
        }),
        react(),
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
