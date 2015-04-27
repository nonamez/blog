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

// Fake file upload
document.getElementById('fake-file-button-browse').addEventListener('click', function() {
	document.getElementById('file-upload').click();
});

document.getElementById('file-upload').addEventListener('change', function() {
	document.getElementById('fake-file-input-name').value = this.value;
	
	document.getElementById('fake-file-button-upload').removeAttribute('disabled');
});

document.getElementById('fake-file-button-upload').addEventListener('click', function() {
	var form_data = new FormData();
		form_data.append('file', document.getElementById('file-upload').files[0]);
	
	console.log(form_data);

	var request = new XMLHttpRequest();
	
	request.open('POST', root_url + '/admin/file/upload', true);

	request.upload.onprogress = function(event) {
		console.log(event.loaded + ' / ' + event.total);
	}
	
	request.onload = function() {
		if (this.status >= 200 && this.status < 400) {
			var response = JSON.parse(this.response);
			
			if (response.status) {
				
			} else
				alert(response.message);
		} else {
			// We reached our target server, but it returned an error
		}
	};
	
	request.send(form_data);
});