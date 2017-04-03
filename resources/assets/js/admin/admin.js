window.$ = window.jQuery = require('jquery')
window.toastr = require('toastr')

require('bootstrap-sass')

jQuery.ajaxSetup({
	cache: false,
	dataType: 'JSON',
	headers: {'X-CSRF-Token': jQuery('meta[name="csrf-token"]').attr('content')}
})

jQuery(document).ajaxStart(function() {
	jQuery('.has-error').removeClass('has-error').find('.help-block').text('').addClass('hide')
})

jQuery(document).ajaxError(function(event, jqXHR, ajaxSettings, errorThrown) {
	if (jqXHR.status == 422) {
		jQuery.each(jqXHR.responseJSON, function(key, text) {
			let element = jQuery('[name="' + key + '"]')
				// In case of array
				if (element.length == 0) {
					element = jQuery('[name="' + key + '[]"]')
				}

				if (element.length == 0) {
					toastr.error(text)
					return
				}

				element.closest('.form-group').addClass('has-error')
				
				let help_block = element.parent().find('.help-block')
				
				if (help_block.length > 0) {
					help_block.text(text).removeClass('hide')
				} else {
					toastr.warning(text)
				}
			})
	} else if (jqXHR.status == 404) {
		toastr.warning('Item not found')
	} else {
		console.log(jqXHR)

		if (jqXHR.hasOwnProperty('responseJSON')) {
			toastr.error(jqXHR.responseJSON.message)
		} else {
			toastr.error('A critical error has occured. Please reload the page and try again')
		}
	}
})

require('./components/posts.js')
require('./components/portfolio/works.js')