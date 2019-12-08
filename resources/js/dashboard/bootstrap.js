window._ = require('lodash');

window.Popper = require('popper.js').default;
window.$ = window.jQuery = require('jquery');
window.toastr = require('toastr');
window.axios = require('axios');

require('bootstrap');

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

axios.interceptors.request.use(function (config) {
	jQuery('.is-invalid').removeClass('is-invalid').next('div.invalid-feedback').remove();
	return config;
}, function (error) {
	// Do something with request error
	return Promise.reject(error);
});

axios.interceptors.response.use(function (response) {
	// Do something with response data
	return response;
}, function (error) {
	if (error.response.status == 422) {
		let errors = error.response.data.errors;

		for (let key in errors) {
			let el = jQuery(`[name="${key}"]`);

			if (el.length > 0) {
				jQuery(`[name="${key}"]`).addClass('is-invalid').after(jQuery('<div/>').addClass('invalid-feedback').text(errors[key]));
			} else {
				toastr.warning(errors[key]);
			}
		}
	} else {
		toastr.error(error.response.statusText);
	}

	return Promise.reject(error);
});