/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['roboto-slab'],
                'roboto-slab': ['roboto-slab', 'sans-serif'],
            },
            colors: {
                primary: '',
                secondary: '',
                tertiary: '',
                bgColorPrimary: '#3d3d3d',
                bgColorSecondary: '#575757',
                bgColorTertiary: '',
            },
        },
    },
    plugins: [
        require('@tailwindcss/typography'),
        require('@tailwindcss/forms'),
    ],
}

