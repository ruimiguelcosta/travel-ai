import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './app/Filament/**/*.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                background: 'hsl(240 10% 98%)',
                foreground: 'hsl(240 10% 10%)',
                card: {
                    DEFAULT: 'hsl(0 0% 100%)',
                    foreground: 'hsl(240 10% 10%)',
                },
                popover: {
                    DEFAULT: 'hsl(0 0% 100%)',
                    foreground: 'hsl(240 10% 10%)',
                },
                primary: {
                    DEFAULT: 'hsl(262 83% 58%)',
                    foreground: 'hsl(0 0% 100%)',
                },
                secondary: {
                    DEFAULT: 'hsl(220 70% 50%)',
                    foreground: 'hsl(0 0% 100%)',
                },
                muted: {
                    DEFAULT: 'hsl(240 5% 96%)',
                    foreground: 'hsl(240 4% 46%)',
                },
                accent: {
                    DEFAULT: 'hsl(270 100% 97%)',
                    foreground: 'hsl(262 83% 58%)',
                },
                destructive: {
                    DEFAULT: 'hsl(0 84.2% 60.2%)',
                    foreground: 'hsl(0 0% 100%)',
                },
                border: 'hsl(240 6% 90%)',
                input: 'hsl(240 6% 90%)',
                ring: 'hsl(262 83% 58%)',
                sidebar: {
                    background: 'hsl(240 10% 3.9%)',
                    foreground: 'hsl(240 5% 84%)',
                    primary: 'hsl(262 83% 58%)',
                    'primary-foreground': 'hsl(0 0% 100%)',
                    accent: 'hsl(240 4% 15.9%)',
                    'accent-foreground': 'hsl(240 5% 84%)',
                    border: 'hsl(240 4% 15.9%)',
                    ring: 'hsl(262 83% 58%)',
                },
            },
        },
    },

    plugins: [forms],
};
