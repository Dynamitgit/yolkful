import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                gold: {
                    50: '#fdf8ec',
                    100: '#fbeecb',
                    300: '#f0cd7e',
                    400: '#e8b84b',
                    500: '#dda52f',
                    600: '#c18a24',
                    700: '#9c6c1e',
                },
            },
        },
    },

    plugins: [forms],
};
