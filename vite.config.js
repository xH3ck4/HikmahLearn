import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import {svelte} from "@sveltejs/vite-plugin-svelte";
import envCompatible from 'vite-plugin-env-compatible';
 
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
          svelte(),
          envCompatible(),
        ],
});