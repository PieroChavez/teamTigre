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
            // **********************************************
            // INICIO: CONFIGURACIÓN FUSIONADA DE ANIMACIONES
            // **********************************************
            animation: {
                // Para la animación de entrada del texto (H1, P, Botones)
                fadeInUp: 'fadeInUp 1s ease-out forwards', 
                // Para el efecto de pulso sutil del botón principal
                'pulse-subtle': 'pulse-subtle 2s cubic-bezier(0.4, 0, 0.6, 1) infinite', 
            },
            keyframes: {
                fadeInUp: {
                    '0%': {
                        opacity: '0',
                        transform: 'translateY(20px)',
                    },
                    '100%': {
                        opacity: '1',
                        transform: 'translateY(0)',
                    },
                },
                'pulse-subtle': {
                    '0%, 100%': {
                        opacity: '1',
                        transform: 'scale(1)',
                    },
                    '50%': {
                        opacity: '0.95',
                        transform: 'scale(1.01)',
                    },
                },
            },
            transitionDelay: {
                '300': '300ms',
                '500': '500ms',
            }
            // **********************************************
            // FIN: CONFIGURACIÓN FUSIONADA DE ANIMACIONES
            // **********************************************
        },
    },

    plugins: [forms],
};