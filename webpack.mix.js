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

mix.js('resources/js/app.js', 'public/js');
mix.js('resources/js/global.js', 'public/js');
mix.js('resources/js/tasks.js', 'public/js');
mix.js('resources/js/objects.js', 'public/js');
mix.js('resources/js/users.js', 'public/js');
mix.js('resources/js/dashboard.js', 'public/js');
mix.js('resources/js/dt-custom-init.js', 'public/js');
mix.sass('resources/sass/app.scss', 'public/css');

if (mix.inProduction()) {
    mix.version();
}
