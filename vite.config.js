import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    resolve: {
        extensions: ['.svg', '.png']
    },
    build: {
        manifest: true, // production build uchun kerak
        outDir: 'public/build', // bu default, lekin yozib qo‘yish aniqroq bo‘ladi
        emptyOutDir: true
    }
});
