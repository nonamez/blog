<li style="margin-right:-5px">
	<i class="fa fa-clock-o"></i>
</li>
<li>
	<time datetime="{{ $post->created_at }}">{{ $post->created_at }}</time>
</li>
@if ($post->tags->count() > 0)
<li style="margin-right:-5px">
	<i class="fa fa-tags"></i>
</li>
@endif
@foreach ($post->tags as $tag)
<li>
	<a href="{{ route('tag', $tag->slug) }}">#{{ $tag->name }}</a>
</li>
@endforeach
<li class="pull-right">
@foreach ($post->parent->localesExcept(app()->getLocale())->where('status', 'published') as $other_post)
<span class="label label-default label-lang">
	<a href="{{ url(sprintf('%s/post/%s', $other_post->locale, $other_post->slug)) }}">@lang('locales.' . $other_post->locale)</a>
</span>
@endforeach
</li>