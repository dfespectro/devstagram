import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: '0.0.0.0'
      },
    plugins: [
        laravel([
            'resources/js/app.js'
        ]),
    ],
});
