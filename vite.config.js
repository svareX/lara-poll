import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import path from 'path'

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/js/app.js', 'resources/css/app.css' ],
      refresh: true,
    }),
    vue({
      template: {
        base: null,
        includeAbsolute: false,
      },
    }),
  ],
  resolve: {
    alias: {
      ziggy: path.resolve('vendor/tightenco/ziggy/dist/vue.es.js'),
    },
  },
})
