import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    
    safelist: [
      'translate-x-1',
      'translate-x-6',
      'bg-green-500',
      'bg-slate-300',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Lato', ...defaultTheme.fontFamily.sans],
                serif: ['Playfair Display', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                slate: {
                    50:  '#f4f5f6',
                    100: '#e2e5e8',
                    200: '#c5ccd2',
                    300: '#9aaab4',
                    400: '#6d8494',
                    500: '#4a6070',
                    600: '#3a4d5c',
                    700: '#2A333D',
                    800: '#1e252c',
                    900: '#13181d',
                },
                sage: {
                    50:  '#f4f8f5',
                    100: '#e3efe6',
                    200: '#c5decc',
                    300: '#9FC8A9',
                    400: '#76ae84',
                    500: '#52945f',
                    600: '#3f744a',
                    700: '#305838',
                    800: '#223d28',
                    900: '#14231a',
                },
                blue: {
                    50:  '#f0f4fb',
                    100: '#dce7f5',
                    200: '#b9cfeb',
                    300: '#8aadd9',
                    400: '#5d8cc8',
                    500: '#3A629D',
                    600: '#2e4f7e',
                    700: '#233c60',
                    800: '#182941',
                    900: '#0e1826',
                },
                cream: {
                    50:  '#fdfcfb',
                    100: '#faf7f4',
                    200: '#f5ede6',
                    300: '#ede0d5',
                    400: '#e0cfc0',
                    500: '#d4beab',
                },
            },
        },
    },

    plugins: [forms],
};
