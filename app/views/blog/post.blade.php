@extends('layouts.blog')
@section('content')
<main class="content" role="main">
	<article class="post post-standalone" id="post-{{ $post['id'] }}" style="border-top: 1px solid #efefef">
		<section class="post-content">
			<div class="title">
				<h2>{{ $post->title }} @foreach ($post->parent->localeNot(app()->getLocale()) as $tmp_post)
					<span class="label label-default label-lang">
						<a href="{{ URL::to('/' . $tmp_post->locale . '/post/' . $tmp_post->slug) }}">@lang('locales.' . $tmp_post->locale)</a>
					</span>
					@endforeach</h2>
			</div>
			@include('blog._tags_line')
			<div>
				<div style="text-align:center">
					
				</div>
				<div>{{ $post->content }}</div>
			</div>
		</section>
		<footer class="post-footer">
			<section class="share">
				<a class="fa fa-twitter-square twitter" href="https://twitter.com/share?text={{ $post['title'] }}&amp;url={{ URL::current() }}" onclick="window.open(this.href, 'twitter-share', 'width=550,height=235');return false;">
					<span class="hidden">Twitter</span>
				</a>
				<a class="fa fa-facebook-square facebook" href="https://www.facebook.com/sharer/sharer.php?u={{ URL::current() }}" onclick="window.open(this.href, 'facebook-share','width=580,height=296');return false;">
					<span class="hidden">Facebook</span>
				</a>
				<a class="fa fa-google-plus-square google-plus" href="https://plus.google.com/share?url={{ URL::current() }}" onclick="window.open(this.href, 'google-plus-share', 'width=490,height=530');return false;">
					<span class="hidden">Google+</span>
				</a>
			</section>
			<section class="comments" id="comments" style="text-align: center">
				<button class="btn btn-default" id="show-disqus">@lang('blog.post.show_comments')</button>
				<div id="disqus_thread" style="display:none"></div>
			</section>
		</footer>
	</article>
</main>
@stop
@section('custom_scripts')
<script type="text/javascript">	
	jQuery('#show-disqus').on('click', function() {
		jQuery(this).next().show();
		
		this.parentElement.removeChild(this);
		
		jQuery.ajax({
			'type': 'GET',
			'url': 'http://{{ Config::get('blog.disqus_shortname') }}.disqus.com/embed.js',
			'dataType': 'script',
			'cache': true
		});
	});

</script>
@stop