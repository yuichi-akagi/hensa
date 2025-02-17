import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
/*
    build: {
      outDir: 'public/hensa_build'
    },
*/
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/main.jsx'],
            refresh: true,
        }),
    ],
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    react: ['recharts','react', 'react-dom'], // React関連を別のチャンクに分離
                },
            },
        },
    },
});
