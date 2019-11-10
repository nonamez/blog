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
		},
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
		'./resources/views/blog/*.php',
		'./resources/views/blog/**/*.php',
		'./resources/views/layouts/blog.blade.php',
		// './resources/js/components/*.vue',
		// './resources/js/components/**/*.vue',
	],

	// Include any special characters you're using in this regular expression
	defaultExtractor: content => content.match(/[\w-/:%]+(?<!:)/g) || []
});

mix.options({
	clearConsole: true
});

mix.version();

if (mix.inProduction()) {
	mix.sourceMaps();
}

mix.js('resources/js/blog.js', 'public/js/blog.js');

mix.sass('resources/sass/blog/styles.scss', 'public/css/blog.css').options({
	processCssUrls: false,
	postCss: [
		tailwindcss('./tailwind.config.js'),
		...process.env.NODE_ENV === 'production' ? [purgecss] : []
	],
});

mix.js('resources/js/dashboard/app.js', 'public/js/dashboard.js');
mix.sass('resources/sass/dashboard/app.scss', 'public/css/dashboard.css');