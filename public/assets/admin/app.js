var tags_container = document.getElementById('tags-div-container');

// Create new tag
document.getElementById('tags-button-create').addEventListener('click', function() {
	var slug  = document.getElementById('tags-input-slug').value;
	var title = document.getElementById('tags-input-title').value;
	
	if (title.length > 0) {
		var container = document.createElement('span');
			container.className   = 'label label-default tag';
			container.textContent = title;
		
		var input_slug = document.createElement('input');
			input_slug.type  = 'hidden';
			input_slug.name  = 'tags[slugs][]';
			input_slug.value = slug.length == 0 ? title : slug;
		
		var input_title = document.createElement('input');
			input_title.type  = 'hidden';
			input_title.name  = 'tags[titles][]';
			input_title.value = title;
		
		var span_remove = document.createElement('span');
			span_remove.setAttribute('data-role', 'remove');
		
		container.appendChild(span_remove);
		container.appendChild(input_slug);
		container.appendChild(input_title);
		
		tags_container.appendChild(container)
		tags_container.appendChild(document.createTextNode(' '));
	}
});

// Remove tag
var tags = tags_container.querySelectorAll('[data-role="remove"]');

for (var i = 0, tag; tag = tags[i]; ++i) {
	tag.addEventListener('click', function() {
		this.parentNode.parentNode.removeChild(this.parentNode);
	});
}