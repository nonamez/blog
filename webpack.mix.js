let mix = require('laravel-mix'),
	tailwindcss = require('tailwindcss');

mix.sass('resources/sass/blog/styles.scss', 'public/css/blog.css').options({
	// processCssUrls: false,
	postCss: [ tailwindcss('./tailwind.config.js') ],
});

// mix.js('resources/js/blog/app.js', 'public/js/blog.js');

mix.version();

if (mix.inProduction()) {
	mix.sourceMaps();
}