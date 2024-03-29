import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from "@vitejs/plugin-vue";
import { fileURLToPath, URL } from 'url';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
    resolve: {
        alias: [
            { find: '@views', replacement: fileURLToPath(new URL('./resources/views', import.meta.url)) },
            { find: '@stores', replacement: fileURLToPath(new URL('./resources/js/stores', import.meta.url)) },
            { find: '@assets', replacement: fileURLToPath(new URL('./public', import.meta.url)) },
            { find: '@components', replacement: fileURLToPath(new URL('./resources/js/components', import.meta.url)) },
        ]
    }
});
