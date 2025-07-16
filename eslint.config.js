import eslint from '@eslint/js';
import globals from 'globals';
import prettierConfig from 'eslint-config-prettier';
import tslint from 'typescript-eslint';

export default tslint.config(
  {
    ignores: ['**/.gitlab-ci-local/', '**/dist/', '**/vendor/'],
  },
  {
    files: ['resources/**/*.ts'],
    extends: [
      eslint.configs.recommended,
      tslint.configs.strictTypeChecked,
      tslint.configs.stylisticTypeChecked,
      prettierConfig,
      {
        languageOptions: {
          globals: { ...globals.node },
          parserOptions: {
            projectService: true,
            tsconfigRootDir: import.meta.dirname,
          },
        },
      },
    ],
  },
  {
    files: ['esbuild.js', '*.config.js'],
    extends: [tslint.configs.disableTypeChecked],
  },
);
