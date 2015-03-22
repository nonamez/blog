<header class="site-head" >
	<div class="vertical">
		<div class="menu btn-group text-left">
			<button type="button" class="btn btn-menu btn-xs dropdown-toggle" data-toggle="dropdown">
				<i class="fa fa-bars"></i>
			</button>
			<ul class="dropdown-menu" role="menu">
				<li><a href="{{ URL::to('/' . app()->getLocale()) }}">@lang('blog.header.home')</a></li>
				<li><a href="{{ URL::route('about') }}">@lang('blog.header.about_me')</a></li>
			</ul>
		</div>
		<div class="menu btn-group text-left" style="left: 30px">
			<button type="button" class="btn btn-menu btn-xs dropdown-toggle" data-toggle="dropdown">
				<i class="fa fa-language"></i>
			</button>
			<ul class="dropdown-menu" role="menu">
				<li><a href="{{ URL::to('/en') }}">@lang('locales.en')</a></li>
				<li><a href="{{ URL::to('/ru') }}">@lang('locales.ru')</a></li>
				<li><a href="{{ URL::to('/lt') }}">@lang('locales.lt')</a> </li>
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
			<h1 class="blog-title">@lang('blog.header.title.before') <a href="#" class="use-tooltip" data-toggle="tooltip" data-placement="right" title="@lang('blog.header.title_tooltip')">@lang('blog.header.title.name')</a>!</h1> 
			<h2 class="blog-description">@lang('blog.header.description')</h2>
			@if (isset($tags))
			<h6>
				@foreach ($tags as $tag)
				<a href="{{ URL::to('/' . $locale . '/tag/' . $tag['slug']) }}">#{{ $tag['name'] }}</a>
				@endforeach
			</h6>
			@endif
		</div>
	</div>
</header>