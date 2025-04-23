import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';


export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js','resources/js/AdminUserManagement.js','resources/js/AdminUserInfo.js','resources/js/Vacataire/AddAssessments.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
