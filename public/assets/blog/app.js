jQuery(document).ready(function() {
	jQuery('.use-tooltip').tooltip({
		container: 'body',
		html: true
	});

	jQuery('.prevent-dropdown-close').on('click', 'input', function(e) {
		e.stopPropagation();
	});

	jQuery('img').wrap(jQuery('<div/>').addClass('image'));

	jQuery(window).scroll(function() {
		if (jQuery(this).scrollTop())
			jQuery('#back-to-top').fadeIn();
		else
			jQuery('#back-to-top').fadeOut();
	});

	jQuery('#back-to-top').click(function() {
		jQuery('html, body').animate({scrollTop: 0}, 200);
		return false;
	});

	jQuery('main').on('click', 'article.post header.post-header', function() {
		var article = jQuery(this).parent();

		if (article.hasClass('open')) {
			article.children('section.post-content').slideUp(400, function() {
				article.removeClass('open');
			});
		} else {
			if (jQuery('article.post.open').length > 0) {
				jQuery('article.post.open').removeClass('open').children('section.post-content').slideUp(200, function() {
					article.children('section.post-content').slideDown(500, function() {
						slideTo(article.offset().top, 200);

						article.addClass('open');
					});
				});
			} else {
				article.children('section.post-content').slideDown(500, function() {
					slideTo(article.offset().top, 200);

					article.addClass('open');
				});
			}
		}

		return false;
	}).on('click', '.post-comment-count', function() {
		window.location.href = this.href;
		return false;
	});
});

function slideTo(value, delay) {
	jQuery('html, body').animate({
		scrollTop: value
	}, delay);
}