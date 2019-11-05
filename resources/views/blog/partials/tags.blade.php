<div class="tags">
	@foreach ($tags as $tag)
	<a href="{{ route('tag', $tag->slug) }}">#{{ $tag->name }}</a>
	@endforeach
</div>