<nav class="nav pb-3">
	@foreach($links as $link)
	<a href="{{ $link['url'] }}"{!! request()->segment(2) == $link['segment'] ? ' class="active"' : '' !!}>{{ $link['char'] }}<span class="hidden md:inline-block lg:inline-block xl:inline-block">{{ $link['text'] }}</span></a>
	@endforeach
</nav>