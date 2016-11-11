<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="HandheldFriendly" content="True">

	<title>@section('title') /home/NoNameZ @show</title>

	<meta name="csrf-token" content="{{ csrf_token() }}">

	<meta name="description" content="{{ $meta_description or trans('blog.meta.description') }}"> 
	<meta name="keywords" content="{{ $meta_keywords or trans('blog.meta.keywords') }}"> 

	<link rel="stylesheet" href="{{ elixir('css/blog.css') }}">

	@yield('custom_styles')

	<script>var root_url = '{{ url('/') }}'</script>

	<link rel="canonical" href="{{ url()->current() }}">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<header class="site-head" >
					<div class="vertical">
						<div class="menu btn-group text-left">
							<button type="button" class="btn btn-menu btn-xs dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-bars"></i>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url(app()->getLocale()) }}">@lang('blog.header.menu.home')</a></li>
								<li><a href="{{ route('about') }}">@lang('blog.header.menu.about_me')</a></li>
							</ul>
						</div>
						<div class="menu btn-group text-left" style="left: 30px">
							<button type="button" class="btn btn-menu btn-xs dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-language"></i>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/en') }}">@lang('locales.en')</a></li>
								<li><a href="{{ url('/ru') }}">@lang('locales.ru')</a></li>
								<li><a href="{{ url('/lt') }}">@lang('locales.lt')</a> </li>
							</ul>
						</div>
						<div class="menu btn-group text-left" style="left: 60px">
							<button type="button" class="btn btn-menu btn-xs dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-code"></i>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><a href="https://github.com/nonamez">GitHub</a></li>
							</ul>
						</div>
						<div class="site-head-content inner">
							<h1 class="blog-title">/home/NoNameZ</h1> 
							<h2 class="blog-description">@lang('blog.header.description')</h2>
							@if (isset($tags))
							<h6>
								@foreach ($tags as $tag)
								<a href="{{ route('tag', $tag['slug']) }}">#{{ $tag['name'] }}</a>
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
							<a href="https://www.digitalocean.com/?refcode=0bbcba259691" rel="nofollow">DigitalOcean</a>
						</section>
					</div>
				</footer>
			</div>
		</div>
		<a href="#" id="back-to-top" class="back-to-top hidden-xs">
			<i class="fa fa-angle-up"></i>
		</a>
	</div>
	<a href="https://github.com/nonamez/blog">
		<img style="position: absolute; top: 0; right: 0; border: 0;" src="{{ asset('/images/fork_me.png') }}" alt="Fork me on GitHub">
	</a>
	{{-- <script src="https://code.jquery.com/jquery-3.1.0.slim.min.js" integrity="sha256-cRpWjoSOw5KcyIOaZNo4i6fZ9tKPhYYb6i5T9RSVJG8=" crossorigin="anonymous"></script> --}}
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script src="{{ elixir('js/blog.js') }}"></script>
	@yield('custom_scripts')
	@if(strlen(env('GOOGLE_ANALYTICS')) > 0)
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', '{{ env('GOOGLE_ANALYTICS') }}', 'auto');
		ga('send', 'pageview');
	</script>
	@endif
</body>
</html>