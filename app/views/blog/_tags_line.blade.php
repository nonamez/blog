<ul class="post-tags list-inline">
	<li style="margin-right:-5px">
		<i class="fa fa-clock-o"></i>
	</li>
	<li>
		<time datetime="{{ $post->created_at }}">{{ $post->created_at }}</time>
	</li>
	<li style="margin-right:-5px">
		<i class="fa fa-tags"></i>
	</li>
	@foreach ($post->tags as $tag)
	<li>
		<a href="{{ URL::route('tag', array('slug' => $tag->slug)) }}">#{{ $tag->name }}</a>
	</li>
	@endforeach
</ul>