/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./app/components/**/*.{js,vue,ts}",
    "./app/layouts/**/*.vue",
    "./app/pages/**/*.vue",
    "./app/plugins/**/*.{js,ts}",
    "./app/app.vue",
    "./app/error.vue",
  ],
  theme: {
    extend: {
      colors: {
        apple: {
          primary: '#0066cc',
          'primary-focus': '#0071e3',
          'primary-on-dark': '#2997ff',
          ink: '#1d1d1f',
          body: '#1d1d1f',
          'body-on-dark': '#ffffff',
          'body-muted': '#cccccc',
          'ink-muted-80': '#333333',
          'ink-muted-48': '#7a7a7a',
          'divider-soft': '#f0f0f0',
          hairline: '#e0e0e0',
          canvas: '#ffffff',
          parchment: '#f5f5f7',
          pearl: '#fafafc',
          'tile-1': '#272729',
          'tile-2': '#2a2a2c',
          'tile-3': '#252527',
          black: '#000000',
          'chip-translucent': 'rgba(210, 210, 215, 0.64)'
        }
      },
      fontFamily: {
        display: ['"SF Pro Display"', 'system-ui', '-apple-system', 'sans-serif'],
        body: ['"SF Pro Text"', 'system-ui', '-apple-system', 'sans-serif'],
      },
      letterSpacing: {
        'tight-display': '-0.022em', // approximates -0.374px on 17px
        'tight-hero': '-0.005em', // approximates -0.28px on 56px
        'tight-caption': '-0.016em', // approximates -0.224px on 14px
      },
      lineHeight: {
        'apple-body': '1.47',
        'apple-display': '1.07',
        'apple-dense': '2.41',
      },
      borderRadius: {
        'apple-sm': '8px',
        'apple-md': '11px',
        'apple-lg': '18px',
        'apple-pill': '9999px',
      },
      boxShadow: {
        'apple-product': '0px 5px 30px 0px rgba(0, 0, 0, 0.22)',
      }
    },
  },
  plugins: [],
}
