import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            typography: ({ theme }) => ({
                DEFAULT: {
                  css: {
                    '--tw-prose-counters': theme('colors.red.400'),
                    '--tw-prose-bullets': theme('colors.red.400'),
                    '--tw-prose-headings': theme('colors.red.700'),
                    '--tw-prose-bold': theme('colors.red.800'),
                    li: {
                        p: {
                            margin: 0
                        }
                    },
                  },
                },
            }),
        },
    },

    plugins: [forms, typography],
};
