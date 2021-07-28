<x-blog-layout>
	<article class="post-standalone" id="post-{{ $post['id'] }}">
		<div class="flex justify-between">
			<div>
				<h2>{{ $post->title }}</h2>
			</div>
			<div class="langs">
				@foreach($post->parent->localesExcept(app()->getLocale())->where('status', 'published') as $other_post)
				[<a{!! $other_post->locale == app()->getLocale() ? ' class="active"' : '' !!} href="{{ url(sprintf('%s/post/%s', $other_post->locale, $other_post->slug)) }}">{{ strtoupper($other_post->locale) }}</a>]
				@endforeach
			</div>
		</div>

		<ul class="flex pl-2">
			<li class="mr-3">
				<small>
					<time datetime="{{ $post->date }}">{{ $post->date }}</time>
				</small>
			</li>
			<li>
				<x-blog.tags :tags="$post->tags"></x-blog.tags>
			</li>
		</ul>
		<div class="post-content">
			{!! prepareContent($post) !!}
		</div>

		<footer class="post-footer">
			{{-- <section class="share">
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
</x-blog-layout>
@push('js')
<script src="https://{{ config('services.disqus.shortname') }}.disqus.com/embed.js"></script>
@endpush