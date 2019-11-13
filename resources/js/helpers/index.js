//  (c) https://ideas.hexbridge.com/how-to-use-laravel-routes-in-javascript-4d9c484a0d97
const routes = require('./_routes.json');

export function route() {
	let args = Array.prototype.slice.call(arguments);
	let name = args.shift();

	if (routes[name] === undefined) {
		console.error('Unknown route ', name);
	} else {
		return _BASE_URL + '/' + routes[name].split('/').map(s => s[0] == '{' ? args.shift() : s).join('/');
	}
}

export function getParameterByName(name, url) {
	if (!url) {
		url = window.location.href;
	}

	name = name.replace(/[[\]]/g, '\\$&');

	let regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
		results = regex.exec(url);

	if (!results) {
		return null;
	}

	if (!results[2]) {
		return '';
	}

	return decodeURIComponent(results[2].replace(/\+/g, ' '));
}