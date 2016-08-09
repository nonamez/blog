'use strict'

var elixir = require('laravel-elixir')

const BOWER_DIR = '../../../bower_components'

elixir(function(mix) {
	mix.copy(
		'bower_components/fontawesome/fonts',
		'public/assets/fonts'
	)

	mix.styles([
		BOWER_DIR + '/fontawesome/css/font-awesome.css',
		BOWER_DIR + '/bootstrap/dist/css/bootstrap.css',
		BOWER_DIR + '/highlightjs/styles/ascetic.css',
		'resources/assets/css/blog.css'
	], 'public/assets/css/blog.css')

	mix.scripts([
		BOWER_DIR + '/highlightjs/highlight.pack.js',
		'resources/assets/js/blog/site.js',
		'resources/assets/js/blog/post.js',
	], 'public/assets/js/blog.js')
})