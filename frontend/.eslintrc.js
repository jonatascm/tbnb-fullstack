module.exports = {
  parserOptions: {
    parser: 'babel-eslint',
  },
  env: {
    browser: true,
    node: true,
    jest: true,
  },
  globals: {
    expect: true,
  },
  extends: [
    'prettier',
    'plugin:vue/recommended',
    'plugin:prettier/recommended',
    'eslint:recommended',
  ],
  plugins: ['vue', 'prettier'],
  rules: {
    'vue/max-attributes-per-line': 'off',
    'vue/singleline-html-element-content-newline': 'off',
    'prettier/prettier': [
      'error',
      {
        singleQuote: true,
        semi: false,
        tabWidth: 2,
      },
    ],
    'no-console': 'off',
    'react/self-closing-comp': 'off',
  },
}
