@extends('layouts.blog')
@section('content')
<main class="content" role="main">
	<article class="post post-standalone" id="post-{{ $post['id'] }}">
		<section class="post-content">
			<div class="title">
				<h2>{{ $post->title }} @foreach ($post->parent->localesExcept(app()->getLocale())->where('status', 'published') as $tmp_post)
					<span class="label label-default label-lang">
						<a href="{{ url($tmp_post->locale . '/post/' . $tmp_post->slug) }}">@lang('locales.' . $tmp_post->locale)</a>
					</span>
					@endforeach</h2>
			</div>
			<ul class="post-tags list-inline">
				@include('blog._line')
			</ul>
			<div>
				{!! $post->content !!}
			</div>
		</section>
		<footer class="post-footer">
			<section class="share">
				<a class="fa fa-twitter-square twitter" href="https://twitter.com/share?text={{ $post->title }}&amp;url={{ URL::current() }}" onclick="window.open(this.href, 'twitter-share', 'width=550,height=235');return false;">
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
	document.getElementById('show-disqus').addEventListener('click', function() {
		var disqus = document.createElement('script');
			disqus.setAttribute('src', 'http://{{ config()->get('blog.disqus_shortname') }}.disqus.com/embed.js');

		document.head.appendChild(disqus);
		
		this.nextElementSibling.style.display = 'block';
		this.parentElement.removeChild(this);
	});

	if (window.location.href.indexOf('#comments') > -1)
		document.getElementById('show-disqus').click();
</script>
@stop