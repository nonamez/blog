// Fake file upload
document.getElementById('fake-file-button-browse').addEventListener('click', function() {
	document.getElementById('files-input-upload').click();
});

document.getElementById('files-input-upload').addEventListener('change', function() {
	document.getElementById('fake-file-input-name').value = this.value;
});

function deleteImage() {
	var tr = this.closest('tr');
	var id = this.getAttribute('data-file-id');
	
	var request = new XMLHttpRequest();

	request.open('GET', root_url + '/admin/file/delete/' + id, true);
	
	request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

	request.onload = function() {
		tr.parentNode.removeChild(tr);
	}
	
	request.send();
}

function updateImageDescription() {
	var form_data = new FormData();
	
	form_data.append('description', this.parentElement.parentElement.children[1].children[0].value);
	form_data.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

	var id = this.getAttribute('data-file-id');

	var request = new XMLHttpRequest();

	request.open('POST', root_url + '/admin/file/update/' + id, true);
	
	request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

	request.send(form_data);
}

var delete_images = document.querySelectorAll('.portfolio-button-delete-image');

for (var i = 0, button; button = delete_images[i]; ++i)
	button.addEventListener('click', deleteImage);

var update_images = document.querySelectorAll('.portfolio-button-update-image-description');

for (var i = 0, button; button = update_images[i]; ++i)
	button.addEventListener('click', updateImageDescription);

var tbody = document.getElementById('portfolio-table-images')['tBodies'][0];

// Upload file and create input with result link
document.getElementById('portfolio-button-upload-image').addEventListener('click', function() {
	var form_data = new FormData();
	
	form_data.append('file', document.getElementById('files-input-upload').files[0]);
	form_data.append('description', document.getElementById('portfolio-textarea-image-description').value);
	form_data.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
	form_data.append('type', 'portfolio');
	form_data.append('watermark', 1);
	
	var request = new XMLHttpRequest();
	
	request.open('POST', root_url + '/admin/file/upload', true);

	request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

	request.onload = function() {
		if (this.status >= 200 && this.status < 400) {
			var response = JSON.parse(this.response);
			
			if (response.status) {	
				var tr = document.createElement('tr');

				tbody.appendChild(tr);

				var image = document.createElement('img');
					image.src = response.data.url;
					image.className = 'img-thumbnail';
					
					image.setAttribute('width', '140');
					image.setAttribute('height', '140');

				var image_link = document.createElement('a');
					image_link.href = response.data.url;
					image_link.appendChild(image);

				var td = document.createElement('td');
					td.className = 'text-center';
					td.appendChild(image_link);

				tr.appendChild(td);

				var textarea = document.createElement('textarea');
					textarea.className = 'form-control';
					textarea.setAttribute('rows', 1);
					textarea.setAttribute('cols', 30);
					textarea.appendChild(document.createTextNode(response.data.description));

				var td = document.createElement('td');
					td.appendChild(textarea);

				tr.appendChild(td);

				var td = document.createElement('td');

				var button = document.createElement('button');
					button.className = 'btn btn-default';
					button.type = 'button';
					button.setAttribute('data-file-id', response.data.id);
					button.appendChild(document.createTextNode('Update'));

					// Delete uploaded file
					button.addEventListener('click', updateImageDescription);


				td.appendChild(button);
				td.appendChild(document.createTextNode(' '));

				var button = document.createElement('button');
					button.className = 'btn btn-default portfolio-button-delete-image';
					button.type = 'button';
					button.setAttribute('data-file-id', response.data.id);
					button.appendChild(document.createTextNode('Delete'));

					// Delete uploaded image
					button.addEventListener('click', deleteImage);

				td.appendChild(button);

				var input = document.createElement('input');
					input.type  = 'hidden';
					input.name  = 'images[]';
					input.value = response.data.id;

				td.appendChild(input);


				tr.appendChild(td);

				// Reset
				document.getElementById('files-input-upload').value = '';
				document.getElementById('fake-file-input-name').value = '';
				document.getElementById('portfolio-textarea-image-description').value = '';
			} else
				alert(response.message);
		} else {
			// We reached our target server, but it returned an error
		}
	};
	
	request.send(form_data);
});