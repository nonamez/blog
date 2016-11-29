const _ELEMENTS = {
	input_tags_slug: jQuery('#posts-input-tag-slug'),
	input_tags_name: jQuery('#posts-input-tag-name'),

	div_tags_container:  jQuery('#posts-div-tags-container'),
	div_files_container: jQuery('#posts-div-files-container'),

	button_save_post:  jQuery('#posts-button-save'),
	button_create_tag: jQuery('#posts-button-tags-create'),

	button_fake_file_browse: jQuery('#fake-file-button-browse'),
	input_fake_file_upload:  jQuery('#files-input-upload'),
	input_fake_file_name:    jQuery('#fake-file-input-name'),
	button_fake_file_upload: jQuery('#fake-file-button-upload')
}

jQuery(document).ready(function() {
	_ELEMENTS.div_tags_container.find('[data-role="remove"]').click(function() {
		this.parentNode.parentNode.removeChild(this.parentNode)
	})
	
	_ELEMENTS.input_fake_file_upload.change(function() {
		_ELEMENTS.input_fake_file_name.val(this.value)

		_ELEMENTS.button_fake_file_upload.prop('disabled', false)
	})

	_ELEMENTS.button_fake_file_browse.click(function() {
		_ELEMENTS.input_fake_file_upload.trigger('click')
	})

	// File upload
	_ELEMENTS.button_fake_file_upload.click(function() {
		var form_data = new FormData()
			form_data.append('file', _ELEMENTS.input_fake_file_upload[0].files[0])

		jQuery.ajax({
			url   : this.getAttribute('data-route'),
			data  : form_data,
			type  : 'POST',
			cache : false,
			contentType : false,
			processData : false,
			success: function(response) {
				var li_container = jQuery('<li/>').attr({
					class: 'list-group-item',
					'data-file-id': response.id
				}).appendTo(_ELEMENTS.div_files_container)

				var div_row = jQuery('<div/>').addClass('row').appendTo(li_container)

				jQuery('<div/>').addClass('col-xs-12 col-sm-8').text(response.name).appendTo(div_row)

				var div_col = jQuery('<div/>').addClass('col-xs-12 col-sm-4 text-right').appendTo(div_row)

				var div_btn_group = jQuery('<div/>').addClass('btn-group btn-group-sm').appendTo(div_col)

				jQuery('<a/>').attr({
					href: response.get_url,
					class: 'btn btn-default',
					target: '_blank',
				}).append(jQuery('<i/>').addClass('fa fa-download')).appendTo(div_btn_group)

				jQuery('<button/>').attr({
					class: 'btn btn-default',
					'data-role': 'remove-file',
					'data-route': response.del_url
				}).on('click', removeTag).append(jQuery('<i/>').addClass('fa fa-trash')).appendTo(div_btn_group)

			}
		})
	})

	// Tags
	_ELEMENTS.button_create_tag.click(function() {
		var slug = _ELEMENTS.input_tags_slug.val()
		var name = _ELEMENTS.input_tags_name.val()

		if (name.length) {
			var container = jQuery('<span/>').attr({
				class: 'label label-default tag',
				'data-name': name,
				'data-slug': slug
			}).text(name).appendTo(_ELEMENTS.div_tags_container).after(' ')

			jQuery('<span/>').attr('data-role', 'remove').appendTo(container).on('click', function() {
				this.parentNode.parentNode.removeChild(this.parentNode)
			})
		}
	})

	// Save post
	_ELEMENTS.button_save_post.click(function() {
		var data = {}

		jQuery('.container').find('[name]').each(function() {
			data[this.name] = this.value
		})

		data['tags'] = _ELEMENTS.div_tags_container.find('span.tag').map(function() {
			return {
				name: this.getAttribute('data-name'),
				slug: this.getAttribute('data-slug')
			}
		}).get()

		data['files'] = _ELEMENTS.div_files_container.find('li[data-file-id]').map(function() {
			return this.getAttribute('data-file-id')
		}).get()

		jQuery.post(this.getAttribute('data-route'), data, function(response) {
			if (response.redirect_to) {
				window.location = response.redirect_to
			}
		})
	})
})
//# sourceMappingURL=admin.js.map
