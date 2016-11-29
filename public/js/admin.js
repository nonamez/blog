// // Fake file upload
// document.getElementById('fake-file-button-browse').addEventListener('click', function() {
// 	document.getElementById('fake-file-input-upload').click()
// });

// document.getElementById('fake-file-input-upload').addEventListener('change', function() {
// 	document.getElementById('fake-file-input-name').value = this.value;
	
// 	document.getElementById('fake-file-button-upload').removeAttribute('disabled');
// });

const _ELEMENTS = {

	div_tags_container: jQuery('#posts-div-tags-container'),
	div_files_container: jQuery('#posts-div-files-container'),

	button_save_post: jQuery('#posts-button-save'),
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
				var li_container = jQuery('<li/>').addClass('list-group-item').appendTo(_ELEMENTS.div_files_container)

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
				}).on('click', function() {
					
				}).append(jQuery('<i/>').addClass('fa fa-trash')).appendTo(div_btn_group)

			}
		})
	})

	// Tags
	_ELEMENTS.button_create_tag.click(function() {
		var slug = document.getElementById('tags-input-slug').value
		var name = document.getElementById('tags-input-name').value

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
		var data = {
			title:   jQuery('input[name="title"]').val(),
			content: jQuery('textarea[name="content"]').val(),
			locale:  jQuery('select[name="locale"]').val(),
			status:  jQuery('select[name="status"]').val(),
			parent_post: jQuery('input[name="parent_post"]').val(),

			tags: _ELEMENTS.div_tags_container.find('span.tag').map(function() {
				return {
					name: this.getAttribute('data-name'),
					slug: this.getAttribute('data-slug')
				}
			}).get()
		}

		jQuery.post(this.getAttribute('data-route'), data, function(response) {
			console.log(response)
		})
	})
})

function addFile() {
	var container = jQuery('<li/>').addClass('list-group-item')
		
	var input_file = jQuery('<input/>').attr({
		type: 'file',
		class: 'hidden'
	}).appendTo(container).on('change', function() {
		jQuery('<button/>').attr({
			type: 'button', 
			class: 'btn btn-default btn-sm pull-right',
			'data-role': 'remove-file'
		}).append(jQuery('<i/>').addClass('fa fa-trash')).insertAfter(this)

		jQuery(this).after(this.files[0].name)

		_ELEMENTS.div_files_container.append(container)
	}).trigger('click')
}
//# sourceMappingURL=admin.js.map
