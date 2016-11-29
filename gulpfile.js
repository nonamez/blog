const elixir = require('laravel-elixir');

const BOWER_DIR = '../../../bower_components'

elixir(function(mix) {
	mix.copy('bower_components/fontawesome', 'public/plugins/fontawesome')
	mix.copy('bower_components/bootstrap/dist', 'public/plugins/bootstrap')
	mix.copy('bower_components/jquery/dist', 'public/plugins/jquery')
	mix.copy('bower_components/toastr', 'public/plugins/toastr')

	mix.copy('bower_components/fontawesome/fonts','public/build/fonts')

	mix.sass('app.scss')

	mix.sass('blog.scss', 'public/css/blog.css')

	mix.scripts([
		BOWER_DIR + '/bootstrap/dist/js/bootstrap.min.js',
		BOWER_DIR + '/highlightjs/highlight.pack.js',
		'blog.js',
	], 'public/js/blog.js')

	mix.scriptsIn('resources/assets/js/admin', 'public/js/admin.js')

	mix.version([
		'public/css/app.css',
		'public/css/blog.css',
		'public/js/blog.js',
		'public/js/admin.js',
	])
})