function twoDigits(d) {
	if (0 <= d && d < 10) {
		return "0" + d.toString()
	}

	if (-10 < d && d < 0) {
		return "-0" + (-1*d).toString()
	}
	
	return d.toString()
}

Date.prototype.toMysqlFormat = function() {
    return this.getFullYear() + '-' + twoDigits(1 + this.getMonth()) + '-' + twoDigits(this.getDate()) + ' ' + twoDigits(this.getHours()) + ':' + twoDigits(this.getMinutes()) + ':' + twoDigits(this.getSeconds())
}

const _ELEMENTS = {
	input_post_date: jQuery('#posts-input-date'),
	input_tags_slug: jQuery('#posts-input-tag-slug'),
	input_tags_name: jQuery('#posts-input-tag-name'),

	div_tags_container:  jQuery('#posts-div-tags-container'),
	div_files_container: jQuery('#posts-div-files-container'),

	button_now:        jQuery('#posts-button-now'),
	button_save_post:  jQuery('#posts-button-save'),
	button_create_tag: jQuery('#posts-button-tags-create'),

	button_fake_file_browse: jQuery('#fake-file-button-browse'),
	input_fake_file_upload:  jQuery('#files-input-upload'),
	input_fake_file_name:    jQuery('#fake-file-input-name'),
	button_fake_file_upload: jQuery('#fake-file-button-upload')
}

jQuery(document).ready(function() {
	_ELEMENTS.input_fake_file_upload.change(function() {
		_ELEMENTS.input_fake_file_name.val(this.value)

		_ELEMENTS.button_fake_file_upload.prop('disabled', false)
	})

	_ELEMENTS.button_fake_file_browse.click(function() {
		_ELEMENTS.input_fake_file_upload.trigger('click')
	})

	// File delete
	_ELEMENTS.div_files_container.on('click', '[data-role="delete-file"]', function() {
		var that = this
		
		jQuery.getJSON(this.getAttribute('data-route'), function() {
			jQuery(that).closest('.list-group-item').remove()
		})
	})

	// Tag delete
	_ELEMENTS.div_tags_container.on('click', 'div[data-role="tag"]', function() {
		jQuery(this).remove()
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
					'data-role': 'delete-file',
					'data-route': response.del_url
				}).append(jQuery('<i/>').addClass('fa fa-trash')).appendTo(div_btn_group)
			}
		})
	})

	// Tags
	_ELEMENTS.button_create_tag.click(function() {
		var slug = _ELEMENTS.input_tags_slug.val()
		var name = _ELEMENTS.input_tags_name.val()

		if (name.length) {
			var container = jQuery('<div/>').attr({
				class: 'btn-group btn-group-sm',
				'data-role': 'tag',
				'data-name': name,
				'data-slug': slug
			}).appendTo(_ELEMENTS.div_tags_container).after(' ')

			jQuery('<button/>').attr({
				type: 'button',
				class: 'btn btn-default',
				disabled: 'disabled'
			}).text(name).appendTo(container)

			jQuery('<button/>').attr({
				type: 'button',
				class: 'btn btn-default',
			}).append(jQuery('<i/>').addClass('fa fa-trash')).appendTo(container)

			_ELEMENTS.input_tags_slug.val(null)
			_ELEMENTS.input_tags_name.val(null)
		}
	})

	_ELEMENTS.button_now.click(function() {
		_ELEMENTS.input_post_date.val(new Date().toMysqlFormat())
	})

	// Save post
	_ELEMENTS.button_save_post.click(function() {
		_ELEMENTS.button_save_post.button('loading')

		var data = {}

		jQuery('.container').find('[name]').each(function() {
			data[this.name] = this.value
		})

		data.markdown = jQuery('#markdown').is(':checked') ? 1 : 0

		data['tags'] = _ELEMENTS.div_tags_container.find('div[data-role="tag"]').map(function() {
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
		}).complete(function() {
			_ELEMENTS.button_save_post.button('reset')
		})
	})
})
//# sourceMappingURL=posts.js.map
