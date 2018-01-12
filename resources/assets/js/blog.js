window.$ = window.jQuery = require('jquery');

require('bootstrap-sass');

let hljs = require('highlight.js/lib/highlight.js');

hljs.registerLanguage('apache', require('highlight.js/lib/languages/apache'));
hljs.registerLanguage('bash', require('highlight.js/lib/languages/bash'));
hljs.registerLanguage('cpp', require('highlight.js/lib/languages/cpp'));
hljs.registerLanguage('css', require('highlight.js/lib/languages/css'));
// hljs.registerLanguage('html', require('highlight.js/lib/languages/html'));
hljs.registerLanguage('json', require('highlight.js/lib/languages/json'));
hljs.registerLanguage('javascript', require('highlight.js/lib/languages/javascript'));
hljs.registerLanguage('nginx', require('highlight.js/lib/languages/nginx'));
hljs.registerLanguage('php', require('highlight.js/lib/languages/php'));
hljs.registerLanguage('python', require('highlight.js/lib/languages/python'));
hljs.registerLanguage('xml', require('highlight.js/lib/languages/xml'));
hljs.registerLanguage('sql', require('highlight.js/lib/languages/sql'));
hljs.registerLanguage('typescript', require('highlight.js/lib/languages/typescript'));

hljs.initHighlightingOnLoad();

// let posts       = jQuery('article:not(.post-standalone)')
let html_body   = jQuery('html, body')
let back_to_top = jQuery('#back-to-top')

jQuery(document).ready(function() {
	// let posts = jQuery('article:not(.post-standalone)')

	// posts.each(function() {
	// 	let current_post = jQuery(this),
	// 		current_post_header  = current_post.find('header.post-header'),
	// 		current_post_content = current_post.find('section.post-content')

	// 	current_post_header.click(function() {
	// 		if (current_post.hasClass('open')) {
	// 			current_post_content.slideUp('slow', function() {
	// 				current_post.removeClass('open')
	// 			})
	// 		} else {
	// 			posts.each(function() {
	// 				let post = jQuery(this)

	// 				if (post.hasClass('open')) {
	// 					post.find('section.post-content').slideUp('slow', function() {
	// 						post.removeClass('open')
	// 					})
	// 				}
	// 			})

	// 			current_post.addClass('open')
	// 			current_post_content.slideDown('slow', function() {
	// 				html_body.animate({
	// 					scrollTop: current_post.offset().top
	// 				}, 'slow')
	// 			})
	// 		}
	// 	})
	// })

	back_to_top.click(function(event) {
		event.preventDefault()

		html_body.animate({scrollTop: 0}, 'slow')
	})

	html_body.on('scroll', function() {
		let scrollTop = jQuery(window).scrollTop()

		if (jQuery(window).scrollTop() > 100) {
			back_to_top.show()
		} else {
			back_to_top.hide()
		}
	})
})