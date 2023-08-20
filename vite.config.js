import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    base: '/vendor/',
    plugins: [
        laravel({
            input: ['resources/js/app.js', 'resources/css/app.css' ],
            refresh: true,
        }),
        vue({
            template: {
                compilerOptions: {
                    isCustomElement: (tag) => ['md-linedivider'].includes(tag),
                },
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
          ziggy: path.resolve('vendor/tightenco/ziggy/dist/vue.es.js'),
        },
      },
});
