@extends('layouts.blog')
@section('content')
<main class="content" role="main">
	@forelse ($posts as $post)
		<a href="{{ $post->getURL() }}">
			<article class="post{{ $post->getPostClass() }}" id="post-{{ $post->id }}">
				<header class="post-header">
					<div class="icon">
						<i class="icon-align-left"></i>
					</div>
					<div class="post-title">{{ $post->title }}</div>
					<div class="post-meta">
						<time datetime="{{ $post->date }}">{{ $post->date->diffForHumans() }}</time>
					</div>
				</header>
			</article>
		</a>
		{{-- <section class="post-content">
			<ul class="post-tags list-inline">
				@include('blog.partials.line')
			</ul>
			<div>
				{!! prepareContent($post, TRUE) !!}
			</div>
			<p class="text-center">
				<a href="{{ $post->routes['preview'] }}" class="btn btn-default btn-sm">@lang('blog.post.more_link')</a>
			</p>
		</section> --}}
	@empty
	<div id="no-posts">@lang('blog.post.no_posts')</div>
	@endforelse
	<div class="text-center">
		{!! $posts->render() !!}
	</div>
</main>
@stop