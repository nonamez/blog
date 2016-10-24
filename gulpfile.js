'use strict'

var elixir = require('laravel-elixir')

const BOWER_DIR = '../../../bower_components'

elixir(function(mix) {
	mix.copy('bower_components/fontawesome', 'public/plugins/fontawesome')
	mix.copy('bower_components/bootstrap/dist', 'public/plugins/bootstrap')
	mix.copy('bower_components/jquery/dist', 'public/plugins/jquery')

	mix.copy('node_modules/font-awesome/fonts','public/build/fonts')

	mix.styles([
		BOWER_DIR + '/bootstrap/dist/css/bootstrap.min.css',
		BOWER_DIR + '/fontawesome/css/font-awesome.css',
		BOWER_DIR + '/highlightjs/styles/ascetic.css',
		'blog/styles.css'
	], 'public/css/blog.css')

	mix.scripts([
		BOWER_DIR + '/bootstrap/dist/js/bootstrap.min.js',
		BOWER_DIR + '/highlightjs/highlight.pack.js',
		'blog.js',
	], 'public/js/blog.js')

	mix.scripts('global.js')

	mix.scripts('admin/posts.js', 'public/js/admin/posts.js')

	mix.version([
		'public/css/blog.css',
		'public/js/blog.js',
		'public/js/global.js',
		'public/js/admin/posts.js',
	])
})