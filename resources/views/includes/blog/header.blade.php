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
			<h1 class="blog-title">@lang('blog.header.title')</h1> 
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