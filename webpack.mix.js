const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
.sass('resources/sass/app.scss', 'public/css')
.copy('resources/js/manifest.json', 'public/manifest.json');

mix.webpackConfig({
    resolve: {
        alias: {
            '@module-setting': path.resolve(__dirname, 'Modules/Setting/Resources/assets/js'),
            '@module-catering': path.resolve(__dirname, 'Modules/Catering/Resources/assets/js'),
            '@': path.resolve(__dirname, 'resources/js'),
        }
    },
}).sourceMaps()

mix.browserSync({
    proxy: 'http://sedifood.test',
    open: false,
});
