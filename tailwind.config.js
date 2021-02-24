const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors')

module.exports = {
    darkMode: 'media', // or 'media' or 'class'
    theme: {
        extend: {
            width: {
                '1/7': '14.2857143%',
                '2/7': '28.5714286%',
                '3/7': '42.8571429%',
                '4/7': '57.1428571%',
                '5/7': '71.4285714%',
                '6/7': '85.7142857%',
            },
            maxHeight: {
                '1/2': '50vh',
            },
            fontSize: {
                '2xs': '.625rem',
                '3xs': '.5rem',
            },
            colors: {
                'fhosting-blue': {
                    50: '#98e2f3',
                    100: '#83dcf1',
                    200: '#6ed7ee',
                    300: '#5ad1ec',
                    400: '#45cbea',
                    500: '#31c6e8',
                    600: '#2cb2d0',
                    700: '#279eb9',
                    800: '#228aa2',
                    900: '#1d768b',
                    DEFAULT: '#31c6e8'
                },
                'fhosting-green': {
                    50: '#98f3cf',
                    100: '#83f1c5',
                    200: '#6eeebb',
                    300: '#5aecb2',
                    400: '#45eaa8',
                    500: '#31e89f',
                    600: '#2cd08f',
                    700: '#27b97f',
                    800: '#22a26f',
                    900: '#1d8b5f',
                    DEFAULT: '#31e89f'
                },
            },
            borderColor: {
                'fhosting-blue': '#31c6e8',
                'fhosting-green': '#31e89f'
            },

        },
        colors: {
            transparent: 'transparent',
            current: 'currentColor',
            amber: colors.amber,
            black: '#000',
            blue: colors.blue,
            blueGray: colors.blueGray,
            coolGray: colors.coolGray,
            cyan: colors.cyan,
            emerald: colors.emerald,
            fuchsia: colors.fuchsia,
            gray: colors.gray,
            green: colors.green,
            indigo: colors.indigo,
            lightBlue: colors.lightBlue,
            lime: colors.lime,
            orange: colors.orange,
            pink: colors.pink,
            purple: colors.purple,
            red: colors.red,
            rose: colors.rose,
            teal: colors.teal,
            trueGray: colors.trueGray,
            violet: colors.violet,
            warmGray: colors.warmGray,
            white: '#FFF',
            yellow: colors.yellow,
        },
    },
    variants: { // all the following default to ['responsive']
        backgroundImage: ['responsive'], // this is for the "bg-none" utility
        filter: ['responsive'], // defaults to ['responsive']
        backdropFilter: ['responsive'], // defaults to ['responsive']
        extend: {
            borderWidth: ['hover', 'focus', 'dark'],
        }
    },
    plugins: [
        // require('tailwindcss-filters'),
        // require('tailwindcss-plugins/pagination'),
    ],
}