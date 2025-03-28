import type { Config } from 'tailwindcss';

export default {
  content: ['./resources/**/*.blade.php', './resources/**/*.ts'],
  darkMode: 'class',
  theme: {
    extend: {}
  },
  plugins: []
} satisfies Config;
