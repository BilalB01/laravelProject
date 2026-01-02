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
                'primary': {
                    DEFAULT: '#00844A',
                    50: '#E6F5ED',
                    100: '#CCEBDB',
                    200: '#99D7B7',
                    300: '#66C393',
                    400: '#33AF6F',
                    500: '#00844A',
                    600: '#006A3B',
                    700: '#004F2C',
                    800: '#00351E',
                    900: '#001A0F',
                },
            },
        },
    },

    plugins: [forms],
};
