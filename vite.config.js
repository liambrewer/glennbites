import { defineConfig } from 'vite';
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // Storefront assets
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
});
