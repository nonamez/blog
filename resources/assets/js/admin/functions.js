require('./bootstrap');

function twoDigits(d) {
	if (0 <= d && d < 10) {
		return '0' + d.toString();
	}

	if (-10 < d && d < 0) {
		return '-0' + (-1*d).toString();
	}
	
	return d.toString()
}

Date.prototype.toMysqlFormat = function() {
	return this.getFullYear() + '-' + twoDigits(1 + this.getMonth()) + '-' + twoDigits(this.getDate()) + ' ' + twoDigits(this.getHours()) + ':' + twoDigits(this.getMinutes()) + ':' + twoDigits(this.getSeconds())
}