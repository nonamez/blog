const mix = require('laravel-mix'),
	path = require('path'),
	webpack = require('webpack'),
	tailwindcss = require('tailwindcss');

mix.options({
	clearConsole: true,
	processCssUrls: true,
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
	plugins: [
		new webpack.DefinePlugin({
			__VUE_OPTIONS_API__: false,
			__VUE_PROD_DEVTOOLS__: false,
		}),
	],
	resolve: {
		alias: {
			helpers: path.resolve(__dirname, 'resources/js/dashboard/helpers'),
			store: path.resolve(__dirname, 'resources/js/dashboard/store'),
			modules: path.resolve(__dirname, 'resources/js/dashboard/modules'),
			// components: path.resolve(__dirname, 'resources/js/components'),
			partials: path.resolve(__dirname, 'resources/js/dashboard/partials'),
			// 'event-bus': path.resolve(__dirname, 'resources/js/event-bus.js'),

			// sass: path.join(__dirname, 'resources/sass')
		}
	}
});

mix.version();

if (mix.inProduction()) {
	mix.sourceMaps();
}

mix.sass('resources/sass/dashboard/invoices/journal.scss', 'public/css/dashboard/invoices/journal.css');

mix.sass('resources/sass/dashboard/styles.scss', 'public/css/dashboard.css').js('resources/js/dashboard/app.js', 'public/js/dashboard.js').vue();

mix.sass('resources/sass/blog/styles.scss', 'public/css/blog.css').js('resources/js/blog/app.js', 'public/js/blog.js');

mix.js('resources/js/app.js', 'public/js').postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
    require('autoprefixer'),
]);