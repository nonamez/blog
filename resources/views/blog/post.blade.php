@section('title', e($post->title))

@section('meta_title', strlen($post->meta_title) == 0 ? e($post->title) : e($post->meta_title))
@section('meta_keywords', e($post->meta_keywords))
@section('meta_description', e($post->meta_description))

@extends('layouts.blog')

@section('content')
<main class="content" role="main">
	<article class="post post-standalone" id="post-{{ $post['id'] }}">
		<section class="post-content">
			<div class="title">
				<h2>{{ $post->title }}</h2>
			</div>
			<ul class="post-tags list-inline">
				@include('blog.partials.line')
			</ul>
			<div class="content">
				{!! prepareContent($post) !!}
			</div>
		</section>
		<footer class="post-footer">
			<section class="share">
				<a class="icon-twitter-square twitter" href="https://twitter.com/share?text={{ $post->title }}&amp;url={{ url()->current() }}" onclick="window.open(this.href, 'twitter-share', 'width=550,height=235');return false;">
					<span class="hidden">Twitter</span>
				</a>
				<a class="icon-facebook-square facebook" href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" onclick="window.open(this.href, 'facebook-share','width=580,height=296');return false;">
					<span class="hidden">Facebook</span>
				</a>
				<a class="icon-google-plus-square google-plus" href="https://plus.google.com/share?url={{ url()->current() }}" onclick="window.open(this.href, 'google-plus-share', 'width=490,height=530');return false;">
					<span class="hidden">Google+</span>
				</a>
			</section>
			<section class="comments" id="comments" style="text-align: center">
				<div id="disqus_thread"></div>
			</section>
		</footer>
	</article>
</main>
@stop
@push('scripts')
<script src="http://{{ config('blog.disqus_shortname') }}.disqus.com/embed.js"></script>
@endpush