let mix = require('laravel-mix'),
	tailwindcss = require('tailwindcss');

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

mix.sass('resources/sass/blog/styles.scss', 'public/css/blog.css').options({
	processCssUrls: false,
	postCss: [
		tailwindcss('./tailwind.config.js'),
		...process.env.NODE_ENV === 'production' ? [purgecss] : []
	],
});

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
	}
});

// mix.js('resources/js/blog/app.js', 'public/js/blog.js');

mix.version();

if (mix.inProduction()) {
	mix.sourceMaps();
}