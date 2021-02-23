<x-blog-layout>
	<article class="post-standalone" id="post-{{ $post['id'] }}">
		<h2 class="mb-1">{{ $post->title }}</h2>

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
