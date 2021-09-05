module.exports = {
    purge: [     './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',],
    darkMode: false,
    theme: {
        extend: {
            backgroundImage: theme => ({
                'hero-lg': "url('/storage/images/blog_app_background.png')",
            }),
            animation: {
                'bounce-custom': 'bounce 1.5s linear',
            }
        },
    },
    variants: {
        extend: {

        },
    },
    plugins: [],
}
