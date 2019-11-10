//  (c) https://ideas.hexbridge.com/how-to-use-laravel-routes-in-javascript-4d9c484a0d97
const routes = require('./_routes.json');

export default function() {
	let args = Array.prototype.slice.call(arguments);
	let name = args.shift();

	if (routes[name] === undefined) {
		console.error('Unknown route ', name);
	} else {
		return _BASE_URL + '/' + routes[name].split('/').map(s => s[0] == '{' ? args.shift() : s).join('/');
	}
}