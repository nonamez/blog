<div class="tags">
	@foreach ($tags as $tag)
	<a href="{{ route('tag', [app()->getLocale(), $tag->slug]) }}">#{{ $tag->name }}</a>
	@endforeach
</div>