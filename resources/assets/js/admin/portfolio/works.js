const _ELEMENTS = {
	button_fake_file_browse: jQuery('#fake-file-button-browse'),
	input_fake_file_upload:  jQuery('#fake-file-input-upload'),
	input_fake_file_name:    jQuery('#fake-file-input-name'),

	button_add_new_image: jQuery('#works-button-add-new-image'),

	textarea_image_description: jQuery('#works-textarea-image-description')
}

jQuery(document).ready(function() {
	_ELEMENTS.input_fake_file_upload.change(function() {
		_ELEMENTS.input_fake_file_name.val(this.value)
	})

	_ELEMENTS.button_fake_file_browse.click(function() {
		_ELEMENTS.input_fake_file_upload.trigger('click')
	})

	// Image upload
	_ELEMENTS.button_add_new_image.click(function() {
		var form_data = new FormData()

		form_data.append('file', _ELEMENTS.input_fake_file_upload[0].files[0])
		form_data.append('description', _ELEMENTS.textarea_image_description)

		jQuery.ajax({
			url   : this.getAttribute('data-route'),
			data  : form_data,
			type  : 'POST',
			cache : false,
			contentType : false,
			processData : false,
			success: function(response) {
				
			}
		})
	})
})