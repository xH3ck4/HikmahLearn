/** @type {import('tailwindcss').Config} */
const config = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.svelte',
    "./node_modules/flowbite-svelte/**/*.{html,js,svelte,ts}",
  ],
  theme: {
    extend: {
      animation: {
        'ease-in-out': 'easeInOut 1s ease-in-out',
        'slide-left': 'slideLeft 1s ease-in-out',
        'slide-right': 'slideRight 1s ease-in-out',
      },
      keyframes: {
        easeInOut: {
          '0%': { opacity: 0 },
          '100%': { opacity: 1 },
        },
        slideLeft: {
          '0%': { transform: 'translateX(100%)', opacity: 0 },
          '100%': { transform: 'translateX(0)', opacity: 1 },
        },
        slideRight: {
          '0%': { transform: 'translateX(-100%)', opacity: 0 },
          '100%': { transform: 'translateX(0)', opacity: 1 },
        },
      },
    },
  },
  plugins: [
    require("tailwindcss-animate"),
    require('flowbite/plugin')
  ],
}


module.exports = config;

