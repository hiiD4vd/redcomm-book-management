/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./app/components/**/*.{js,vue,ts}",
    "./app/layouts/**/*.vue",
    "./app/pages/**/*.vue",
    "./app/plugins/**/*.{js,ts}",
    "./app.vue",
    "./error.vue",
  ],
  theme: {
    extend: {
      colors: {
        neo: {
          bg: '#fdfaf6',
          yellow: '#ffc900',
          pink: '#ff90e8',
          blue: '#3b82f6',
          green: '#22c55e',
          red: '#ff5c5c',
          black: '#000000',
        }
      },
      boxShadow: {
        neo: '4px 4px 0px 0px rgba(0,0,0,1)',
        'neo-sm': '2px 2px 0px 0px rgba(0,0,0,1)',
      },
      borderWidth: {
        neo: '3px',
      },
      borderRadius: {
        neo: '8px',
      }
    },
  },
  plugins: [],
}
