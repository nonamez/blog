const _ELEMENTS = {
	button_fake_file_browse: jQuery('#fake-file-button-browse'),
	input_fake_file_upload:  jQuery('#fake-file-input-upload'),
	input_fake_file_name:    jQuery('#fake-file-input-name'),

	button_add_new_image: jQuery('#works-button-add-new-image'),

	textarea_image_description: jQuery('#works-textarea-image-description'),

	table_images: jQuery('#works-table-images'),

	div_add_image_modal_container: jQuery('#works-div-modal-add-image-container')
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
		form_data.append('description', _ELEMENTS.textarea_image_description.val())

		jQuery.ajax({
			url   : this.getAttribute('data-route'),
			data  : form_data,
			type  : 'POST',
			cache : false,
			contentType : false,
			processData : false,
			success: function(response) {
				var tr = jQuery('<tr/>').attr('data-image-id', response.id).appendTo(_ELEMENTS.table_images.find('tbody'))

				var img = jQuery('<img/>').attr({
					width: 140,
					height: 140,
					src: response.get_url,
					class: 'img-thumbnail'
				})

				jQuery('<a/>').attr('href', response.get_url).append(img).appendTo(tr).wrap(jQuery('<td/>').addClass('text-center'))

				jQuery('<textarea/>').attr({
					class: 'form-control',
					rows: 5,
					cols: 30
				}).text(response.description).appendTo(tr).wrap(jQuery('<td/>'))

				var td = jQuery('<td/>').appendTo(tr)

				jQuery('<button/>').attr({
					class: 'btn btn-default btn-sm',
					'data-update-route': response.upd_url
				}).text('Update').appendTo(td)

				td.append(' ')

				jQuery('<button/>').attr({
					class: 'btn btn-default btn-sm',
					'data-delete-route': response.del_url
				}).text('Delete').appendTo(td)

				_ELEMENTS.div_add_image_modal_container.modal('hide')
			}
		})
	})
})
//# sourceMappingURL=works.js.map
