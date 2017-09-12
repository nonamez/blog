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

// mix.copy('bower_components/fontawesome', 'public/plugins/fontawesome')
// mix.copy('bower_components/bootstrap/dist', 'public/plugins/bootstrap')
// mix.copy('bower_components/jquery/dist', 'public/plugins/jquery')
// mix.copy('bower_components/toastr', 'public/plugins/toastr')
// mix.copy('bower_components/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css', 'public/plugins/abc')

// mix.sass('admin.scss')
// mix.sass('resources/assets/sass/blog.scss', 'public/css/blog.css')
// mix.sass('portfolio.scss')

mix.sass('resources/assets/sass/admin.scss', 'public/css/admin.css').version()
mix.sass('resources/assets/sass/blog/style.scss', 'public/css/blog.css').version()
mix.sass('resources/assets/sass/portfolio.scss', 'public/css/portfolio.css').version()

mix.js('resources/assets/js/blog.js', 'public/js/blog.js').version()
mix.js('resources/assets/js/admin/admin.js', 'public/js/admin.js').version()
mix.copy('resources/assets/js/admin/old_components/portfolio/works.js', 'public/js/admin/portfolio/works.js').version()

