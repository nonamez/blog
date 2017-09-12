window.$ = window.jQuery = require('jquery')

jQuery.ajaxSetup({
	cache: false,
	dataType: 'JSON',
	headers: {'X-CSRF-Token': jQuery('meta[name="csrf-token"]').attr('content')}
})

window.toastr = require('toastr')

window.Vue = require('vue')

require('bootstrap-sass')