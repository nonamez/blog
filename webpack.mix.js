let mix = require('laravel-mix'),
	path = require('path'),
	tailwindcss = require('tailwindcss');

mix.options({
	clearConsole: true,
	processCssUrls: false,
	postCss: [
		tailwindcss('./tailwind.config.js'),
	]
});

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
			// helpers: path.resolve(__dirname, 'resources/js/helpers'),
			// store: path.resolve(__dirname, 'resources/js/store'),
			'd-modules': path.resolve(__dirname, 'resources/js/dashboard/modules'),
			// components: path.resolve(__dirname, 'resources/js/components'),
			'd-partials': path.resolve(__dirname, 'resources/js/dashboard/partials'),
			// 'event-bus': path.resolve(__dirname, 'resources/js/event-bus.js'),

			// sass: path.join(__dirname, 'resources/sass')
		}
	}
});

mix.version();

if (mix.inProduction()) {
	mix.sourceMaps();
}

mix.sass('resources/sass/blog/styles.scss', 'public/css/blog.css');
mix.sass('resources/sass/dashboard/styles.scss', 'public/css/dashboard.css');

mix.js('resources/js/dashboard/app.js', 'public/js/dashboard.js').vue();