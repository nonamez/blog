@extends('layouts.blog')
@section('content')
<main class="content" role="main">
	@forelse ($posts as $post)
	<?php if ($post instanceof App\Models\Blog\Post) $post = $post->locale(app()->getLocale()); ?>
	<article class="post{{ App\Helpers\Site\Blog::postColor($post->status) }}" id="post-{{ $post->id }}" data-url="{{ route('post', $post->slug) }}">
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
				@include('blog._line')
			</ul>
			<div>
				{!! $post->short() !!}
			</div>
			<p class="text-center">
				@if ($post->is_short)
				<a href="{{ route('post', $post->slug) }}" class="btn btn-default btn-sm">@lang('blog.post.more_link')</a>
				@else
				<a href="{{ route('post', $post->slug) }}#comments" class="btn btn-default btn-sm">@lang('blog.post.comments_link')</a>
				@endif
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
@section('custom_scripts')
<script src="{{ asset('/assets/blog/posts.js')}}"></script>
@stop