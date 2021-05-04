module.exports = {
	'parserOptions': {
		'ecmaVersion': 2020,
		'sourceType': 'module'
	},
	'env': {
		'browser': true,
		'es6': true
	},
	'extends': [
		'eslint:recommended',
		'plugin:vue/vue3-essential',
	],
	'globals': {
		'Atomics': 'readonly',
		'SharedArrayBuffer': 'readonly',
		'axios': 'readonly',
		'toastr': 'readonly',
		'Vue': 'readonly',
		'jQuery': 'readonly',
		'require': 'readonly',
		'_BASE_URL': 'readonly',
	},
	'plugins': [
		'vue'
	],
	'rules': {
		'indent': [
			2,
			"tab"
		],
		'linebreak-style': [
			'error',
			'unix'
		],
		'quotes': [
			'error',
			'single'
		],
		'semi': [
			'error',
			'always'
		],
	}
};