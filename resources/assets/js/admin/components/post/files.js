module.exports = {
	props: ['files'], 
	data: function () {
		return {
			file: null,
			
			// Statuses
			selected: false,
			watermark: false,
		}
	},
	methods: {
		upload: function(route) {
			console.log('uploadFile')

			let form_data = new FormData();
				form_data.append('file', this._JQ_ELEMENTS.input_file_upload[0].files[0]);
				form_data.append('watermark', this.watermark);

			jQuery.ajax({
				url  : route,
				data : form_data,
				type : 'POST',
				cache: false,
				contentType: false,
				processData: false,
				success: response => {
					this.files.unshift(response)

					this.selected = false;
					this.watermark = false;

					this._JQ_ELEMENTS.input_file_upload.val(null)

					this._JQ_ELEMENTS.input_fake_file_name.val('')
				}
			})
		},
		remove: function(index) {
			jQuery.getJSON(this.files[index].links.delete, () => {
				this.files.splice(index, 1)
			})
		}
	},

	created: function() {
		console.log('files created')
	},
	mounted: function() {
		console.log('files mounted')

		$('[data-toggle="tooltip"]').tooltip(); 

		const _ELEMENTS = {
			input_file_upload:  jQuery('#files-input-upload'),

			input_fake_file_name:    jQuery('#fake-file-input-name'),
			button_fake_file_upload: jQuery('#fake-file-button-upload'),
			button_fake_file_browse: jQuery('#fake-file-button-browse')
		}

		this._JQ_ELEMENTS = _ELEMENTS;

		_ELEMENTS.input_file_upload.change(event => {
			_ELEMENTS.input_fake_file_name.val(event.currentTarget.value)

			this.selected = true;
		})

		_ELEMENTS.button_fake_file_browse.click(function() {
			_ELEMENTS.input_file_upload.trigger('click')
		})
	}
}