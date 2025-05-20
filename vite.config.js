import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

// export default defineConfig({
//     plugins: [
//         laravel({
//             input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/messages.js'],
//             refresh: true,
//         }),
//         tailwindcss(),
//     ],
// });


export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/message.css',
                'resources/js/app.js',
                'resources/js/message.js',
            ],
            refresh: true,
        }),
    ],
});