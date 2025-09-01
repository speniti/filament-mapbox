/** @type {import('stylelint').Config} */
export default {
  extends: ['stylelint-config-standard', 'stylelint-config-tailwindcss'],
  rules: {
    'at-rule-no-deprecated': [
      true,
      { ignoreAtRules: ['tailwind', 'apply', 'layer', 'config'] },
    ],
    'at-rule-no-unknown': [true, { ignoreAtRules: ['reference'] }],
    'selector-class-pattern': ['', {}],
  },
};
