const defaultTheme = require('tailwindcss/defaultTheme')
const plugin = require('tailwindcss/plugin')

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                light: '0 0 15px 0 rgba(255, 255, 255, .1)'
            }
        },
        screens: {
            'md': '640px',
            'lg': '768px',
            'xl': '1024px'
        },
        variants: {
            textColor: ['responsive', 'hover', 'focus', 'important'],
            backgroundColor: ['responsive', 'hover', 'focus', 'important'],
            borderWidth: ['responsive', 'important'],
        },
    },

    plugins: [require('@tailwindcss/forms'),
    plugin(function({ addVariant }) {
      addVariant('important', ({ container }) => {
        container.walkRules(rule => {
          rule.selector = `.\\!${rule.selector.slice(1)}`
          rule.walkDecls(decl => {
            decl.important = true
          })
        })
      })
    })
    ],
};
