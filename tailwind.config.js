const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: false,

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
            	black: {
					default: '#000'
				},

				grey: {
					lighter: '#aaa',
					default: '#212529'
				}
			}
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
