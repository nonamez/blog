@section('title', e($post->title))

@section('meta_keywords', e($post->meta_keywords))
@section('meta_description', e($post->meta_description))

@extends('layouts.blog')

@section('content')
<article class="post-standalone" id="post-{{ $post['id'] }}">
	<h2 class="mb-1">{{ $post->title }}</h2>

	<ul class="flex pl-2">
		<li class="mr-3">
			<small>
				<time datetime="{{ $post->date }}">{{ $post->date }}</time>
			</small>
		</li>
		<li>
			@include('blog.partials.tags', ['tags' => $post->tags])
		</li>
	</ul>
	<div class="content">
		{!! prepareContent($post) !!}
	</div>

	<footer class="post-footer">
{{-- 		<section class="share">
			<a class="icon-twitter-square twitter" href="https://twitter.com/share?text={{ $post->title }}&amp;url={{ url()->current() }}" onclick="window.open(this.href, 'twitter-share', 'width=550,height=235');return false;">
				<span class="hidden">Twitter</span>
			</a>
			<a class="icon-facebook-square facebook" href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" onclick="window.open(this.href, 'facebook-share','width=580,height=296');return false;">
				<span class="hidden">Facebook</span>
			</a>
		</section> --}}
		<section class="comments" id="comments" style="text-align: center">
			<div id="disqus_thread"></div>
		</section>
	</footer>
</article>
@stop
@push('js')
<script src="https://{{ config('services.disqus.shortname') }}.disqus.com/embed.js"></script>
@endpush