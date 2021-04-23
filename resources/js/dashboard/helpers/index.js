//  (c) https://ideas.hexbridge.com/how-to-use-laravel-routes-in-javascript-4d9c484a0d97
const routes = require('./_routes.json');

export function route() {
	let args = Array.prototype.slice.call(arguments);
	let name = args.shift();

	if (routes[name] === undefined) {
		throw new Error('Unknown route');
	} else {
		return _BASE_URL + '/' + routes[name].split('/').map(s => s[0] == '{' ? args.shift() : s).join('/').replace(/\/$/, '');
	}
}

export function getURLParameterByName(name, url) {
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

export function debounce(fn, delay = 500, id = 'GLOBAL') {
	let timeout = {};

	return function (...args) {
		clearTimeout(timeout[id]);

		timeout[id] = setTimeout(() => fn.call(this, ...args), delay);
	};
}

export function getId(char_first = true) {
	let uniqid = (~~(Math.random() * 1e8)).toString(16);

	if (char_first) {
		uniqid = String.fromCharCode(65 + Math.floor(Math.random() * 26)) + uniqid;
	}

	return uniqid;
}