import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Space Grotesk', 'Plus Jakarta Sans', 'Inter', ...defaultTheme.fontFamily.sans],
                display: ['Syncopate', 'Plus Jakarta Sans', 'sans-serif'],
                body: ['Space Grotesk', 'Plus Jakarta Sans', 'sans-serif'],
            },
            colors: {
                border: 'hsl(214.3 31.8% 91.4%)',
                input: 'hsl(214.3 31.8% 91.4%)',
                ring: 'hsl(221.2 83.2% 53.3%)',
                background: 'hsl(0 0% 100%)',
                foreground: 'hsl(222.2 84% 4.9%)',
                primary: {
                    DEFAULT: '#FF5F1F', // Stitch Neon Orange
                    admin: '#FF6B00',   // Admin Orange
                    foreground: 'hsl(210 40% 98%)',
                    50: '#eff6ff',
                    100: '#dbeafe',
                    200: '#bfdbfe',
                    300: '#93c5fd',
                    400: '#60a5fa',
                    500: '#3b82f6',
                    600: '#2563eb',
                    700: '#1d4ed8',
                    800: '#1e40af',
                    900: '#1e3a8a',
                },
                secondary: {
                    DEFAULT: '#39FF14', // Stitch Cyber Green
                    admin: '#22C55E',   // Admin Green
                    foreground: 'hsl(222.2 47.4% 11.2%)',
                },
                "background-light": "#F8F9FA",
                "background-dark": "#0A0A0A",
                "card-dark": "#161616",
                "surface-light": "#FFFFFF",
                "surface-dark": "#1E293B",
                destructive: {
                    DEFAULT: 'hsl(0 84.2% 60.2%)',
                    foreground: 'hsl(210 40% 98%)',
                },
                muted: {
                    DEFAULT: 'hsl(210 40% 96.1%)',
                    foreground: 'hsl(215.4 16.3% 46.9%)',
                },
                accent: {
                    DEFAULT: 'hsl(210 40% 96.1%)',
                    foreground: 'hsl(222.2 47.4% 11.2%)',
                },
                card: {
                    DEFAULT: 'hsl(0 0% 100%)',
                    foreground: 'hsl(222.2 84% 4.9%)',
                },
            },
            borderRadius: {
                lg: '0.5rem',
                md: '0.375rem',
                sm: '0.25rem',
                'xl': "12px",
            },
            boxShadow: {
                'soft': '0 1px 2px 0 rgb(0 0 0 / 0.05)',
                'card': '0 4px 12px 0 rgb(0 0 0 / 0.08), 0 2px 4px -1px rgb(0 0 0 / 0.08)',
                'elevated': '0 10px 25px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1)',
                'lg': '0 20px 40px -10px rgb(0 0 0 / 0.15)',
                'xl': '0 25px 50px -12px rgb(0 0 0 / 0.15)',
                'glow': '0 0 20px rgba(59, 130, 246, 0.4)',
                'glow-lg': '0 0 40px rgba(59, 130, 246, 0.5)',
            },
            keyframes: {
                'slide-in-right': {
                    '0%': { transform: 'translateX(100%)', opacity: '0' },
                    '100%': { transform: 'translateX(0)', opacity: '1' },
                },
                'slide-out-right': {
                    '0%': { transform: 'translateX(0)', opacity: '1' },
                    '100%': { transform: 'translateX(100%)', opacity: '0' },
                },
                'fade-in': {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                'bounce-in': {
                    '0%': { opacity: '0', transform: 'scale(0.9)' },
                    '50%': { opacity: '1', transform: 'scale(1.05)' },
                    '100%': { transform: 'scale(1)' },
                },
                'slide-in-up': {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                'glow-pulse': {
                    '0%, 100%': { boxShadow: '0 0 10px rgba(59, 130, 246, 0.3)' },
                    '50%': { boxShadow: '0 0 20px rgba(59, 130, 246, 0.5)' },
                },
            },
            animation: {
                'slide-in-right': 'slide-in-right 0.3s ease-out',
                'slide-out-right': 'slide-out-right 0.3s ease-in',
                'fade-in': 'fade-in 0.2s ease-out',
                'bounce-in': 'bounce-in 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)',
                'slide-in-up': 'slide-in-up 0.5s ease-out',
                'glow-pulse': 'glow-pulse 2s ease-in-out infinite',
            },
        },
    },

    plugins: [forms],
};
