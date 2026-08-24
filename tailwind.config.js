/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
  ],
  theme: {
    extend: {
      colors: {
        // Sunset Auditorium palette
        maroon: {
          50:  '#FBEDE8',
          100: '#F3D0C4',
          200: '#E4A28A',
          300: '#D07350',
          400: '#A8461E',
          500: '#7C2D12', // primary brand
          600: '#66240E',
          700: '#4F1B0B',
          800: '#391307',
          900: '#230B04',
        },
        amber: {
          50:  '#FFFBEB',
          100: '#FEF3C7',
          200: '#FDE68A',
          300: '#FCD34D',
          400: '#FBBF24',
          500: '#F59E0B', // accent brand
          600: '#D97706',
          700: '#B45309',
        },
        sky: {
          400: '#38BDF8',
          500: '#0EA5E9', // secondary CTA / links
          600: '#0284C7',
        },
        parchment: {
          50: '#FFF8F0', // background
          100: '#FDF1E3',
        },
        ink: {
          900: '#2A1810', // main text
          700: '#4A2E20',
        },
        // Role-accent system layered on the same maroon base
        role: {
          participant: '#22C55E', // green
          organizer: '#F59E0B',   // amber
          admin: '#EC4899',       // pink
        },
      },
      fontFamily: {
        sans: ['"Inter"', 'ui-sans-serif', 'system-ui'],
        display: ['"Fraunces"', 'ui-serif', 'Georgia'], // for headings/banner text - event-poster feel
      },
    },
  },
  plugins: [],
}
