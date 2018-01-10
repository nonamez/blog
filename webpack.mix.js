const { mix } = require('laravel-mix');

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

// mix.sass('admin.scss')
// mix.sass('resources/assets/sass/blog.scss', 'public/css/blog.css')
// mix.sass('portfolio.scss')

mix.sass('resources/assets/sass/blog/style.scss', 'public/css/blog.css')
mix.js('resources/assets/js/blog.js', 'public/js/blog.js')

mix.sass('resources/assets/sass/admin.scss', 'public/css/admin.css')

mix.js('resources/assets/js/admin/bootstrap.js', 'public/js/admin/basis.js');
mix.js('resources/assets/js/admin/components/posts/post.js', 'public/js/admin/post.js');

mix.version()