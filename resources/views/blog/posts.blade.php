@extends('layouts.blog')
@section('content')
<main class="content" role="main">
	@forelse ($posts as $post)
	<article class="post{{ $post->getPostClass() }}" id="post-{{ $post->id }}" data-url="{{ $post->getURL() }}">
		<header class="post-header">
			<div class="icon">
				<i class="{{ $post->icon }}"></i>
			</div>
			<div class="post-title">{{ $post->title }}</div>
			<div class="post-meta">
				<time datetime="{{ $post->created_at }}">{{ $post->created_at->diffForHumans() }}</time>
			</div>
		</header>
		<section class="post-content">
			<ul class="post-tags list-inline">
				@include('blog.partials.line')
			</ul>
			<div>
				{!! prepareContent($post->getShort()) !!}
			</div>
			<p class="text-center">
				<a href="{{ $post->getURL() }}" class="btn btn-default btn-sm">@lang('blog.post.more_link')</a>
			</p>
		</section>
	</article>
	@empty
	<div id="no-posts">@lang('blog.post.no_posts')</div>
	@endforelse
	<nav class="text-center">
		{!! $posts->render() !!}
	</nav>
</main>
@stop