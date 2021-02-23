<div class="tags">
	@foreach ($tags as $tag)
	<a href="{{ $tag->getUrl() }}">#{{ $tag->name }}</a>
	@endforeach
</div>