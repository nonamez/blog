@extends('layouts.blog')
@section('content')
<main class="content" role="main">
	@forelse ($posts as $post)
	<?php if ($post instanceof Blog\Models\Post) $post = $post->locale($locale); ?>
	<article class="post" id="post-{{ $post->id }}" data-url="{{ URL::route('post', array('slug' => $post->slug)) }}">
		<header class="post-header">
			<div class="icon">
				<i class="{{ $post->icon }}"></i>
			</div>
			<div class="post-title">{{ $post->title }}</div>
			<div class="post-meta">
				<time datetime="{{ $post->created_at }}">{{ $post->created_at }}</time>
			</div>
		</header>
		<section class="post-content">
			<ul class="post-tags list-inline">
				<li style="margin-right:-5px">
					<i class="fa fa-tags"></i>
				</li>
				@foreach ($post->tags as $tag)
				<li>
					<a href="{{ URL::route('tag', array('slug' => $tag->slug)) }}">#{{ $tag->name }}</a>
				</li>
				@endforeach
			</ul>
			<div>
				{{ $post->short() }}
			</div>
			<p class="text-center">
				@if ($post->is_short)
				<a href="{{ URL::route('post', array('slug' => $post->slug)) }}" class="btn btn-default btn-sm">@lang('blog.post.more_link')</a>
				@else
				<a href="{{ URL::route('post', array('slug' => $post->slug)) }}#comments" class="btn btn-default btn-sm">@lang('blog.post.comments_link')</a>
				@endif
			</p>
		</section>
	</article>
	@empty
	<div id="no-posts">@lang('blog.post.no_posts')</div>
	@endforelse
	<nav class="text-center">
		{{ $posts->links() }}
	</nav>
</main>
@stop
@section('custom_scripts')
<script src="{{ asset('/assets/blog/posts.js')}}"></script>
@stop