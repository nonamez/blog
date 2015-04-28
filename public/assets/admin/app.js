// To do:
//  	* Optimize AJAX requests
//  	* Add loading state of file

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
	document.getElementById('files-input-upload').click();
});

document.getElementById('files-input-upload').addEventListener('change', function() {
	document.getElementById('fake-file-input-name').value = this.value;
	
	document.getElementById('fake-file-button-upload').removeAttribute('disabled');
});

// Upload file and create input with result link
document.getElementById('fake-file-button-upload').addEventListener('click', function() {
	var form_data = new FormData();
		form_data.append('file', document.getElementById('files-input-upload').files[0]);
	
	var request = new XMLHttpRequest();
	
	request.open('POST', root_url + '/admin/file/upload', true);

	request.upload.onprogress = function(event) {
		console.log(event.loaded + ' / ' + event.total);
	}
	
	request.onload = function() {
		if (this.status >= 200 && this.status < 400) {
			var response = JSON.parse(this.response);
			
			if (response.status) {
				
				var group = document.createElement('div');
					group.className = 'form-group';
				
				var col = document.createElement('div');
					col.className = 'col-md-9 col-md-offset-1';
				
				var input_group = document.createElement('div');
					input_group.className = 'input-group';
				
				var input = document.createElement('input');
					input.type  = 'text';
					input.value = response.data.url;
					input.className = 'form-control';
					
					input.setAttribute('readonly', 'readonly');
				
				var input_hidden = document.createElement('input');
					input_hidden.type  = 'hidden';
					input_hidden.name  = 'files[]';
					input_hidden.value = response.data.id;
					input_hidden.className = 'hide hidden';
				
				var span = document.createElement('span');
					span.className   = 'input-group-btn';
				
				var button = document.createElement('button');
					button.type = 'button';
					button.className = 'btn btn-default';
					
					button.setAttribute('data-file-id', response.data.id);
					
					// Delete uploaded file
					button.addEventListener('click', function () {
						var group = this.closest('.form-group');
						
						var request = new XMLHttpRequest();

						var id = this.getAttribute('data-file-id');

						request.open('GET', root_url + '/admin/file/delete/' + id, true);
						
						request.onload = function() {
							group.parentNode.removeChild(group);
						}
						
						request.send();
					});
				
				var i = document.createElement('i');
					i.className = 'fa fa-trash-o';
					
				button.appendChild(i);
				span.appendChild(button);
				
				input_group.appendChild(input);
				input_group.appendChild(input_hidden);
				input_group.appendChild(span);
				
				col.appendChild(input_group);
				
				group.appendChild(col);
				
				document.getElementById('files-div-container').appendChild(group);
			} else
				alert(response.message);
		} else {
			// We reached our target server, but it returned an error
		}
	};
	
	request.send(form_data);
});