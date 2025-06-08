const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .postCss('resources/css/app.css', 'public/css', [
       //
   ])
   .version();

mix.webpackConfig({
    stats: {
        children: true
    },
    resolve: {
        fallback: {
            "firebase/app": require.resolve("firebase/app"),
            "firebase/database": require.resolve("firebase/database")
        }
    }
});