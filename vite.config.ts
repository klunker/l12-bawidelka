import { fileURLToPath, URL } from 'node:url';
import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import tailwindcss from '@tailwindcss/vite';
import react from '@vitejs/plugin-react';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite-plus';

export default defineConfig({
    staged: {
        '*': 'vp check --fix',
    },
    lint: {
        plugins: ['oxc', 'typescript', 'unicorn', 'react', 'import'],
        categories: { correctness: 'warn' },
        env: { builtin: true },
        ignorePatterns: [
            'vendor/**',
            'node_modules/**',
            'public/**',
            'bootstrap/ssr/**',
            'tailwind.config.js',
            'vite.config.ts',
            'resources/js/actions/**',
            'resources/js/components/ui/*',
            'resources/js/routes/**',
        ],
        rules: {
            // Ваши правила оставлены без изменений, так как они специфичны для вашего проекта
            'react-hooks/rules-of-hooks': 'error',
            '@typescript-eslint/consistent-type-imports': [
                'error',
                { prefer: 'type-imports', fixStyle: 'separate-type-imports' },
            ],
            'import/consistent-type-specifier-style': [
                'error',
                'prefer-top-level',
            ],
        },
        options: {
            typeAware: true,
            typeCheck: true,
        },
    },
    fmt: {
        semi: true,
        singleQuote: true,
        tabWidth: 4,
        printWidth: 80,
        sortTailwindcss: {
            stylesheet: 'resources/css/app.css',
            functions: ['clsx', 'cn', 'cva'],
        },
        ignorePatterns: [
            'resources/js/components/ui/*',
            'resources/views/mail/*',
        ],
    },
    server: {
        host: '0.0.0.0',
        hmr: {
            host: process.env.VITE_DEV_SERVER_HOST || 'localhost',
        },
        // Ускоряем холодный старт, предварительно сканируя зависимости
        warmup: {
            clientFiles: ['./resources/js/app.tsx', './resources/css/app.css'],
        },
    },
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('./resources/js', import.meta.url)),
            '@images': fileURLToPath(
                new URL('./resources/assets/images', import.meta.url),
            ),
        },
    },
    build: {
        target: 'esnext',
        chunkSizeWarningLimit: 1200,
        rolldownOptions: {
            output: {
                manualChunks(id) {
                    if (!id.includes('node_modules')) return;

                    if (
                        id.includes('node_modules/react/') ||
                        id.includes('node_modules/react-dom/') ||
                        id.includes('node_modules/@inertiajs/')
                    ) {
                        return 'vendor-core';
                    }
                    if (
                        id.includes('node_modules/@radix-ui/') ||
                        id.includes('node_modules/lucide-react/') ||
                        id.includes('node_modules/swiper/') ||
                        id.includes('node_modules/@headlessui/')
                    ) {
                        return 'vendor-ui';
                    }
                    if (
                        id.includes('node_modules/axios/') ||
                        id.includes('node_modules/clsx/') ||
                        id.includes('node_modules/tailwind-merge/')
                    ) {
                        return 'vendor-utils';
                    }
                },
            },
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.tsx',
                'resources/scss/Theme.scss',
            ],
            ssr: 'resources/js/ssr.tsx',
            refresh: [
                'resources/views/**',
                'routes/**',
                'app/Http/Controllers/**',
                'app/Http/Responses/**',
            ],
        }),
        tailwindcss(),
        react({
            babel: {
                plugins: [['babel-plugin-react-compiler', { target: '19' }]],
            },
        }),
        wayfinder({
            formVariants: true,
        }),
    ],
    // Оптимизация обработки CSS
    css: {
        devSourcemap: true,
        preprocessorOptions: {
            scss: {
                api: 'modern-compiler' as any, // Используем новый быстрый компилятор Sass
            } as any,
        },
    },
});
