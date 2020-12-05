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
    .sass('resources/sass/ui_custom.scss', 'public/css')
    .sass('resources/sass/home.scss', 'public/css')
    .sass('resources/sass/search_products.scss', 'public/css')
    .sass('resources/sass/product_details.scss', 'public/css')
    .sass('resources/sass/order_confirm.scss', 'public/css')
    .sass('resources/sass/user_orders.scss', 'public/css')
    .sass('resources/sass/user_order_details.scss', 'public/css')
    .sass('resources/sass/admin_orders.scss', 'public/css')
    .sass('resources/sass/admin_order_details.scss', 'public/css')
    .sass('resources/sass/admin_search_products.scss', 'public/css').sourceMaps();