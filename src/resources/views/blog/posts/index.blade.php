<x-blog-layout>
<section>
	@foreach ($posts as $post)
	<article class="post-short flex flex-wrap">
		<div class="w-full md:w-1/5">
			<div class="flex flex-wrap mr-5 px-5 py-3 md:px-1 md:h-full left-side">
				<div class="w-1/2 md:w-full md:mb-2">
					<time datetime="{{ $post->date }}">{{ $post->date->diffForHumans() }}</time>
				</div>
				<div class="w-1/2 text-right md:w-full md:text-left langs">
					@foreach($post->parent->localesExcept(app()->getLocale())->where('status', 'published') as $other_post)
					[<a{!! $other_post->locale == app()->getLocale() ? ' class="active"' : '' !!} href="{{ url(sprintf('%s/post/%s', $other_post->locale, $other_post->slug)) }}">{{ strtoupper($other_post->locale) }}</a>]
					@endforeach
				</div>
			</div>
		</div>
		<div class="w-full md:w-4/5">
			<div class="p-2 right-side">
				<h1 class="title">
					<a href="{{ $post->routes->preview }}">{{ $post->title }}</a>
				</h1>
			</div>
		</div>
	</article>
	@endforeach
	
	@if ($posts->hasPages())
	<div class="flex mt-4 px-8">
		<div class="w-1/2">
			@if($posts->onFirstPage() == FALSE)
			<a class="button bg-transparent text-gray-400 hover:text-gray-700" href="{{ $posts->previousPageUrl() }}">@lang('pagination.previous')</a>
			@endif
		</div>
		<div class="w-1/2 text-right">
			@if($posts->hasMorePages())
			<a class="button bg-transparent text-gray-400 hover:text-gray-700" href="{{ $posts->nextPageUrl() }}">@lang('pagination.next')</a>
			@endif
		</div>
	</div>
	@endif
</section>
</x-blog-layout>
