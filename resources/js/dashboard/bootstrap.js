window._ = require('lodash');

window.Popper = require('popper.js').default;
window.$ = window.jQuery = require('jquery');
window.toastr = require('toastr');
window.axios = require('axios');

require('bootstrap');

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

axios.interceptors.response.use(function (response) {
	// Do something with response data
	return response;
}, function (error) {
	if (error.response.status == 422) {
		jQuery.each(error.response.data.errors, function(key, text) {
			toastr.warning(text[0]);
		});
	} else {
		toastr.error(error.response.statusText);
	}

	return Promise.reject(error);
});