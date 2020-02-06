<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Patua+One&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans:400,400i&display=swap&subset=cyrillic,cyrillic-ext" rel="stylesheet">
	
	<link rel="stylesheet" href="{{ mix('css/blog.css') }}">

	<title>@yield('title') /home/NoNameZ</title>
	
	<meta name="keywords" content="@yield('meta_keywords', trans('blog.meta.keywords'))">
	<meta name="description" content="@yield('meta_description', trans('blog.meta.description'))">

	<meta name="author" content="name @ nonamez.name">

	<link rel="alternate" href="{{ url('/lt') }}" hreflang="lt-LT">
	<link rel="alternate" href="{{ url('/en') }}" hreflang="en-US">
	<link rel="alternate" href="{{ url('/ru') }}" hreflang="ru-RU">

	<link rel="canonical" href="{{ url()->current() }}">

	<meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
	<header class="container pb-2">
		<div class="float-none lg:float-right xl:float-right lg:text-right lg:text-right">
			<h1 class="my-2 sm:m-0 md:m-0 lg:m-0">/home/NoNameZ</h1>
			<div class="langs my-3">
				@foreach(config('app.locales') as $locale)
				[<a{!! app()->getLocale() == $locale ? ' class="active"' : '' !!} href="{{ url('/' . $locale) }}">{{ strtoupper($locale) }}</a>]
				@endforeach
			</div>
		</div>
		<nav class="nav pb-3">
			@foreach($top_links as $top_link)
			<a{!! $top_links_segment == $top_link['segment'] ? ' class="active"' : '' !!} href="{{ $top_link['url'] }}">{{ $top_link['char'] }}<span class="hidden md:inline-block lg:inline-block xl:inline-block">{{ $top_link['text'] }}</span></a>
			@endforeach
		</nav>
		@include('blog.partials.tags', ['tags' => $tags_global])
	</header>

	<main class="container px-2 lg:px-0 xl:px-0">
		@yield('content')
	</main>

	<footer class="py-2">
		<div class="container">
			<a href="https://m.do.co/c/0bbcba259691" rel="nofollow" class="mr-2">Hosted on Digital Ocean</a>
			<a href="https://github.com/nonamez/blog" rel="nofollow" class="mr-2">Saved on GitHub</a>
			<a href="https://laravel.com" rel="nofollow" class="mr-2">Made with Laravel</a>
		</div>
	</footer>
	<script src="{{ mix('js/blog.js') }}"></script>
	@stack('js')
</body>
</html>
