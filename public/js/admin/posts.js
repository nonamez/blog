// Fake file upload
document.getElementById('fake-file-button-browse').addEventListener('click', function() {
	document.getElementById('files-input-upload').click();
});

document.getElementById('files-input-upload').addEventListener('change', function() {
	document.getElementById('fake-file-input-name').value = this.value;
	
	document.getElementById('fake-file-button-upload').removeAttribute('disabled');
});

const _ELEMENTS = {
	input_tag_slug: jQuery('#tags-input-slug')
}

jQuery(document).ready(function() {
	jQuery('#tags-button-create').click(function() {
		var slug  = document.getElementById('tags-input-slug').value
		var title = document.getElementById('tags-input-title').value

		if (title.length) {
			var container = jQuery('<span/>').addClass('label label-default tag').text(title).appendTo('#tags-div-container').after(' ')

			jQuery('<span/>').attr('data-role', 'remove').appendTo(container).on('click', function() {
				this.parentNode.parentNode.removeChild(this.parentNode)
			})
		}
	})
})
//# sourceMappingURL=posts.js.map
