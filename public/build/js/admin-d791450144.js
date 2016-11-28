// // Fake file upload
// document.getElementById('fake-file-button-browse').addEventListener('click', function() {
// 	document.getElementById('fake-file-input-upload').click()
// });

// document.getElementById('fake-file-input-upload').addEventListener('change', function() {
// 	document.getElementById('fake-file-input-name').value = this.value;
	
// 	document.getElementById('fake-file-button-upload').removeAttribute('disabled');
// });

const _ELEMENTS = {
	input_tag_slug: jQuery('#tags-input-slug'),

	button_save_post: jQuery('#post-button-save'),
	button_create_tag: jQuery('#tags-button-create'),

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
		})
	})

	// Tags
	_ELEMENTS.button_create_tag.click(function() {
		var slug  = document.getElementById('tags-input-slug').value
		var title = document.getElementById('tags-input-title').value

		if (title.length) {
			var container = jQuery('<span/>').addClass('label label-default tag').text(title).appendTo('#tags-div-container').after(' ')

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
		}

		jQuery.post(this.getAttribute('data-route'), data, function(response) {
			console.log(response)
		})
	})
})
//# sourceMappingURL=admin.js.map
