import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import theme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views//*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            // colors: {
            //     // Warna kustom untuk tema
            //     primary: '#60A5FA', // Biru cerah
            //     secondary: '#083344', // Biru muda
            //     accent: '#F59E0B', // Oranye cerah
            //     neutral: '#4B5563', // Abu-abu netral
            //     info: '#3B82F6', // Biru (untuk info)
            //     success: '#10B981', // Hijau (untuk sukses)
            //     warning: '#F59E0B', // Kuning (untuk peringatan)
            //     error: '#EF4444', // Merah (untuk error)
            // }
        },
    },

    plugins: [
        forms,
        require('daisyui'),
    ],
    daisyui: {
    themes: [
      {
        mytheme: {
          "primary": "#60A5FA",
          "secondary": "#083344",
          "accent": "#37cdbe",
          "neutral": "#3d4451",
          "base-100": "#ffffff",
        },
      },
      "dark",
    ],
  },
};