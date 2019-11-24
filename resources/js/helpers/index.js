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

export function twoDigits(d) {
	if (0 <= d && d < 10) {
		return '0' + d.toString();
	}

	if (-10 < d && d < 0) {
		return '-0' + (-1 * d).toString();
	}
	
	return d.toString();
}

export function toMysqlFormat(d = false) {
	if (d == false) {
		d = new Date;
	}

	return d.getFullYear() + '-' + twoDigits(1 + d.getMonth()) + '-' + twoDigits(d.getDate()) + ' ' + twoDigits(d.getHours()) + ':' + twoDigits(d.getMinutes()) + ':' + twoDigits(d.getSeconds());
}