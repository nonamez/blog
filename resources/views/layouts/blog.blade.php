<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="HandheldFriendly" content="True">

	<title>@yield('title') /home/NoNameZ</title>
	
	@if (isset($meta_title))
	<meta name="title" content="{{ $meta_title }}">
	@endif
	<meta name="keywords" content="@yield('meta_keywords', trans('blog.meta.keywords'))">
	<meta name="description" content="@yield('meta_description', trans('blog.meta.description'))">

	<link rel="stylesheet" href="{{ mix('css/blog.css') }}">

	<script>var root_url = '{{ url('/') }}'</script>

	<link rel="canonical" href="{{ url()->current() }}">

	<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<header class="site-head" >
					<div class="vertical">
						<div class="menu btn-group text-left">
							<button type="button" class="btn btn-menu btn-xs dropdown-toggle" data-toggle="dropdown">
								<i class="icon-bars"></i>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url(app()->getLocale()) }}">@lang('blog.header.menu.home')</a></li>
								<li><a href="{{ route('about') }}">@lang('blog.header.menu.about_me')</a></li>
							</ul>
						</div>
						<div class="menu btn-group text-left" style="left: 30px">
							<button type="button" class="btn btn-menu btn-xs dropdown-toggle" data-toggle="dropdown">
								<i class="icon-language"></i>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/en') }}">@lang('locales.en')</a></li>
								<li><a href="{{ url('/ru') }}">@lang('locales.ru')</a></li>
								<li><a href="{{ url('/lt') }}">@lang('locales.lt')</a> </li>
							</ul>
						</div>
						<div class="menu btn-group text-left" style="left: 60px">
							<button type="button" class="btn btn-menu btn-xs dropdown-toggle" data-toggle="dropdown">
								<i class="icon-code"></i>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><a href="https://github.com/nonamez">GitHub</a></li>
							</ul>
						</div>
						<div class="site-head-content inner">
							<h1 class="blog-title">/home/NoNameZ</h1> 
							<h2 class="blog-description">@lang('blog.header.description')</h2>
							@if ($tags->count() > 0)
							<h6>
								@foreach ($tags as $tag)
								<a href="{{ route('tag', $tag->slug) }}">#{{ $tag->name }}</a>
								@endforeach
							</h6>
							@endif
						</div>
					</div>
				</header>
			</div>
			<div class="col-md-12">
				@yield('content')
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<footer class="site-footer">
					<div class="inner">
						<section class="poweredby">
							<a href="http://laravel.com" rel="nofollow">Laravel</a> |
							<a href="https://github.com/suinly/science" rel="nofollow">Science</a> |
							<a href="https://m.do.co/c/0bbcba259691" rel="nofollow">DigitalOcean</a>
						</section>
					</div>
				</footer>
			</div>
		</div>
		<a href="#" id="back-to-top" class="back-to-top hidden-xs">
			<i class="icon-angle-up"></i>
		</a>
	</div>
	<a href="https://github.com/nonamez/blog">
		<img style="position: absolute; top: 0; right: 0; border: 0;" src="{{ asset('storage/images/fork_me.png') }}" alt="Fork me on GitHub">
	</a>
	
	<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>

	<script src="{{ mix('js/blog.js') }}"></script>
	
	@stack('scripts')
	
	@if(strlen(env('GOOGLE_ANALYTICS')) > 0)
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', '{{ env('GOOGLE_ANALYTICS') }}', 'auto');
		ga('send', 'pageview');
	</script>
	@endif
</body>
</html>