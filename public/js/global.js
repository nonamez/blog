var processing_modal = jQuery('#processing-modal')

jQuery.ajaxSetup({
	beforeSend: function(jqXHR, settings) {
		jQuery('.has-error').removeClass('has-error').find('.help-block').text('').addClass('hide')

		if (isNumber(window.ajax_counter) == false)
			window.ajax_counter = 0;
		
		if (window.ajax_counter == 0)
			processing_modal.modal('show');
		
		window.ajax_counter++;
		
		if (window.ajax_counter > 1) {
			var pb = processing_modal.find('.progress').show();
			
			if (window.ajax_counter == 2)
				pb.find('.progress-bar').css('width', '0');
		}
	},
	complete: function(response) {
		if (isNumber(window.ajax_max) == false)
			window.ajax_max = 0;
		
		if (window.ajax_counter > window.ajax_max)
			window.ajax_max = window.ajax_counter;
		
		window.ajax_counter--;
		
		var progress = 100 - (100 / window.ajax_max) * window.ajax_counter;
		
		processing_modal.find('.progress').show().find('.progress-bar').css('width', progress + '%');
		
		if (window.ajax_counter == 0) {
			processing_modal.modal('hide');
			processing_modal.find('.progress').hide().find('.progress-bar').css('width', '0');
			
			window.ajax_max = 0;
		}
	},
	error: function(xmlHttpRequest, textStatus, errorThrown) {
		if (xmlHttpRequest.status == 422) {
			jQuery.each(xmlHttpRequest.responseJSON, function(key, text) {
				var element = jQuery('[name="' + key + '"]')

				// In case of array
				if (element.length == 0)
					element = jQuery('[name="' + key + '[]"]')

				// In case of custom arrays
				if (element.length == 0 && key.indexOf('.') > -1) {
					var last_item = key.split(/[. ]+/).pop()
					
					element = jQuery('[name="' + last_item + '"]')
				}

				if (element.length == 0)
					return

				element.closest('.form-group').addClass('has-error')
				element.parent().find('.help-block').text(text).removeClass('hide')
			})
		} else {		
			processing_modal.modal('hide');

			if (xmlHttpRequest.hasOwnProperty('responseJSON'))
				console.log(xmlHttpRequest.responseJSON.message)
			else
				alert('A critical error has occured. Please reload the page and try again.')
		}
	},
	cache: false,
	dataType: 'JSON',
	headers: {'X-CSRF-Token': jQuery('meta[name="csrf-token"]').attr('content')}
})

function isNumber(number) {
	return !isNaN(parseFloat(number)) && isFinite(number)
}

function s4() {
	return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
}

function guid() {
	return s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4();
}
//# sourceMappingURL=global.js.map
