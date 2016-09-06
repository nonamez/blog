'use strict'

var elixir = require('laravel-elixir')

const BOWER_DIR = '../../../bower_components'

elixir(function(mix) {
	mix.copy(
		'bower_components/fontawesome/fonts',
		'public/assets/fonts'
	)

	mix.styles([
		'blog/bootstrap/css/bootstrap.min.css',
		BOWER_DIR + '/fontawesome/css/font-awesome.css',
		BOWER_DIR + '/highlightjs/styles/ascetic.css',
		'blog/styles.css'
	], 'public/assets/css/blog.css')

	mix.scripts([
		'/../css/blog/bootstrap/js/bootstrap.min.js',
		'resources/assets/js/blog.js',
		BOWER_DIR + '/highlightjs/highlight.pack.js',
	], 'public/assets/js/blog.js')

	mix.version([
		'public/assets/css/blog.css',
		'public/assets/js/blog.js',
	])
})