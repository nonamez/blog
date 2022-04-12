window._     = require('lodash');
window.axios = require('axios');
window.bootstrap = require('bootstrap');

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

axios.interceptors.request.use(function (config) {
	return config;
}, function (error) {
	// Do something with request error
	return Promise.reject(error);
});

axios.interceptors.response.use(function (response) {
	// Do something with response data
	return response;
}, function (error) {
	
	return Promise.reject(error);
});