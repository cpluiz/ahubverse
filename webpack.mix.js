const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.sass('resources/css/twitch/config.scss', 'public/css/frontend/twitch')
    .minify('public/css/frontend/twitch/config.css')
    .sourceMaps()

mix.sass('resources/css/admin/admin.scss', 'public/css/admin')
    .minify('public/css/admin/admin.css')
    .sourceMaps();

mix.js('resources/js/admin/admin.js', 'public/js/admin/')
    .minify('public/js/admin/admin.js')
    .sourceMaps();


mix.js('resources/js/frontend.js', 'public/js')
    .minify('public/js/frontend.js')
    .sourceMaps()

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css');
