import {defineConfig} from "laravel-vite";
import vue from "@vitejs/plugin-vue";
import styleImport from 'vite-plugin-style-import'
import viteImagemin from 'vite-plugin-imagemin';

export default defineConfig({
    css: {
        preprocessorOptions: {
            scss: {
                // example : additionalData: `@import "./src/design/styles/variables";`
                // dont need include file extend .scss
                additionalData: `@import "@/sass/variables.scss";`
            },
        },
    },
})
    .withPlugins(vue,
        styleImport({
            libs: [{
                libraryName: 'element-plus',
                esModule: true,
                ensureStyleFile: true,
                resolveStyle: (name) => {
                    name = name.slice(3)
                    return `element-plus/packages/theme-chalk/src/${name}.scss`;
                },
                resolveComponent: (name) => {
                    return `element-plus/lib/${name}`;
                },
            }]
        }),
        viteImagemin({
            gifsicle: {
                optimizationLevel: 7,
                interlaced: false,
            },
            optipng: {
                optimizationLevel: 7,
            },
            webp: {
                quality: 75,
            },
            mozjpeg: {
                quality: 65,
            },
            pngquant: {
                quality: [0.65, 0.9],
                speed: 4,
            },
            svgo: {
                plugins: [
                    {
                        removeViewBox: false,
                    },
                    {
                        removeEmptyAttrs: false,
                    },
                ],
            },
        }));
