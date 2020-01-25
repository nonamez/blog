let mix = require('laravel-mix'),
	tailwindcss = require('tailwindcss');

mix.webpackConfig({
	module: {
		rules: [
			{
				enforce: 'pre',
				exclude: /node_modules/,
				loader: 'eslint-loader',
				test: /\.(js|vue)?$/ 
			}
		]
	},
	resolve: {
		alias: {
			helpers: path.resolve(__dirname, 'resources/js/helpers')
		}
	}
});

const purgecss = require('@fullhuman/postcss-purgecss')({

	// Specify the paths to all of the template files in your project 
	content: [
		'./resources/js/*.js',
		'./resources/js/**/*.js',

		'./resources/js/*.vue',
		'./resources/js/**/*.vue',

		'./resources/views/*.php',
		'./resources/views/**/*.php',
	],

	// Include any special characters you're using in this regular expression
	defaultExtractor: content => content.match(/[\w-/:%]+(?<!:)/g) || []
});

mix.options({
	clearConsole: true,
	processCssUrls: true,
	postCss: [
		tailwindcss('./tailwind.config.js'),
		...process.env.NODE_ENV === 'production' ? [purgecss] : []
	]
});

mix.version();

if (mix.inProduction()) {
	mix.sourceMaps();
}

mix.sass('resources/sass/blog/styles.scss', 'public/css/blog.css').js('resources/js/blog.js', 'public/js/blog.js');
mix.sass('resources/sass/dashboard/app.scss', 'public/css/dashboard.css').js('resources/js/dashboard/app.js', 'public/js/dashboard.js');
