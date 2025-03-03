import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/wire-elements/modal/resources/views/*.blade.php',
        './vendor/masmerise/livewire-toaster/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.tsx',
        './resources/**/*.vue',
    ],
    safelist: [
        {
            pattern: /max-w-(sm|md|lg|xl|2xl|3xl|4xl|5xl|6xl|7xl)/,
            variants: ['sm', 'md', 'lg', 'xl', '2xl']
        }
    ],
    theme: {
        extend: {
            fontFamily: {
                onest: ['Onest Variable', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [],
};
