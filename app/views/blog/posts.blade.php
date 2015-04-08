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
				<a href="{{ URL::route('post', array('slug' => $post->slug)) }}/#comments" class="post-comment-count use-tooltip" title="@lang('blog.post.no_comments')" data-placement="right" data-disqus-identifier="article-id-{{ $post['id'] }}">
					<i class="fa fa-comments"></i>
				</a>
			</div>
		</header>
		<section class="post-content">
			<a href="{{ URL::route('post', array('slug' => $post->slug)) }}" class="title"><h2>{{ $post->title }}</h2></a>
			@include('/blog/_tags_line')
			<div>
				{{ $post->short() }}
			</div>
			<p class="text-center">
				@if ($post->is_short)
				<a href="{{ URL::route('post', array('slug' => $post->slug)) }}" class="btn btn-default btn-xs">@lang('blog.post.more_link')</a>
				@else
				<a href="{{ URL::route('post', array('slug' => $post->slug)) }}#comments" class="btn btn-default btn-xs">@lang('blog.post.comments_link')</a>
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
<script type="text/javascript">
	var posts = [];

	jQuery(document).ready(function() {
		jQuery('article').each(function() {
			posts.push('link:' + this.getAttribute('data-url'));
		});
		
		jQuery.ajax({
			type: 'GET',
			url: 'https://disqus.com/api/3.0/threads/set.jsonp',
			data: { api_key: '{{ Config::get('blog.disqus_publickey') }}', forum : '{{ Config::get('blog.disqus_shortname') }}', thread : posts },
			cache: false,
			dataType: "jsonp",
			success: function (response) {				
				jQuery.each(response.response, function() {
					if (this.posts > 0) {
						var article_element = jQuery('article[data-url="' + this.link + '"]');
							article_element.find('a.post-comment-count').attr('title', this.posts).tooltip('fixTitle');
					}
				});
			}
		});
	});
</script>
@stop