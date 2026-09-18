import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                    // Optimized fallbacks need the optional "fontaine" package, which
                    // is not installed. Opting out keeps the build output clean and
                    // deterministic instead of warning on every run.
                    optimizedFallbacks: false,
                }),
            ],
        }),
        tailwindcss(),
    ],
    build: {
        /*
         * Browser support floor. Chrome/Edge 111, Firefox 128 and Safari 16.4
         * are the first versions that ship the CSS features Tailwind 4 emits
         * (oklch colours, color-mix, @property), so targeting anything older
         * would produce JavaScript that runs in browsers the stylesheet cannot
         * support anyway. Declaring it explicitly keeps the output predictable
         * instead of depending on the bundler default.
         */
        target: ['chrome111', 'edge111', 'firefox128', 'safari16.4'],
        cssTarget: ['chrome111', 'edge111', 'firefox128', 'safari16.4'],
        // Surface bundle growth early on a mobile-first, data-conscious audience.
        chunkSizeWarningLimit: 600,
    },
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
