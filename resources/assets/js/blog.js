var posts       = jQuery('article:not(.post-standalone)')
var html_body   = jQuery('html, body')
var back_to_top = jQuery('#back-to-top')

jQuery(document).ready(function() {
	var posts = jQuery('article:not(.post-standalone)')

	posts.each(function() {
		var current_post = jQuery(this),
		current_post_header  = current_post.find('header.post-header'),
		current_post_content = current_post.find('section.post-content')

		current_post_header.click(function() {
			if (current_post.hasClass('open')) {
				current_post_content.slideUp('slow', function() {
					current_post.removeClass('open')
				})
			} else {
				posts.each(function() {
					var post = jQuery(this)

					if (post.hasClass('open')) {
						post.find('section.post-content').slideUp('slow', function() {
							post.removeClass('open')
						})
					}
				})

				current_post.addClass('open')
				current_post_content.slideDown('slow', function() {
					html_body.animate({
						scrollTop: current_post.offset().top
					}, 'slow')
				})
			}
		})
	})

	back_to_top.click(function(event) {
		event.preventDefault()

		html_body.animate({scrollTop: 0}, 'slow')
	})

	html_body.on('scroll', function() {
		var scrollTop = jQuery(window).scrollTop()

		if (jQuery(window).scrollTop() > 100) {
			back_to_top.show()
		} else {
			back_to_top.hide()
		}
	})
})