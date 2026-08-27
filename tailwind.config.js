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
        // Compatibility aliases for the existing Blade templates.
        maroon: {
          50: '#F5F3FF',
          100: '#EDE9FE',
          200: '#DDD6FE',
          500: '#4F46E5',
          600: '#4338CA',
          700: '#3730A3',
        },
        parchment: {
          50: '#F4F5F9',
        },
        coral: {
          300: '#FF9B9B',
          400: '#FF8585',
          500: '#FF6B6B',
          600: '#E85555',
        },
        // "Nova" palette — dark, premium, tech-forward
        base: {
          950: '#0B0E17', // deepest background
          900: '#11141F', // main background
          800: '#181C2A', // card background
          700: '#242A3D', // borders/dividers
          600: '#3A4258',
        },
        violet: {
          400: '#A78BFA',
          500: '#8B5CF6', // primary brand
          600: '#7C3AED',
          700: '#6D28D9',
        },
        cyan: {
          300: '#67E8F9',
          400: '#22D3EE', // accent brand
          500: '#06B6D4',
        },
        rose: {
          400: '#FB7185', // danger/reject
          500: '#F43F5E',
        },
        lime: {
          400: '#A3E635', // success/approve
          500: '#84CC16',
        },
        amber: {
          400: '#FBBF24', // pending/warning
        },
        ink: {
          50: '#F4F5F9',  // main text on dark bg
          300: '#9CA3B8', // muted text
          500: '#6B7280',
        },
        // Role-accent system for the 3 panels
        role: {
          participant: '#A3E635', // lime
          organizer: '#FBBF24',   // amber
          admin: '#EC4899',       // pink
        },
      },
      fontFamily: {
        sans: ['"Sora"', 'ui-sans-serif', 'system-ui'],
        display: ['"Space Grotesk"', 'ui-sans-serif', 'system-ui'],
      },
      boxShadow: {
        glow: '0 0 24px -6px rgba(139, 92, 246, 0.35)',
        'glow-cyan': '0 0 24px -6px rgba(34, 211, 238, 0.35)',
      },
    },
  },
  plugins: [],
}
