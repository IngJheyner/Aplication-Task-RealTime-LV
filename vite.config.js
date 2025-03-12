import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
// import tailwindcss from '@tailwindcss/vite';
import vue from "@vitejs/plugin-vue";
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.ts"],
            refresh: true,
        }),
        // tailwindcss(),
        vue(),
    ],
    resolve: {
        alias: {
            "@": path.resolve(__dirname, "./resources/js/src"),
        },
    },
    css: {
        devSourcemap: false // Deshabilita los source maps para CSS
    },
});
