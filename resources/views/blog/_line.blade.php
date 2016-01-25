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
	<a href="{{ URL::route('tag', array('slug' => $tag->slug)) }}">#{{ $tag->name }}</a>
</li>
@endforeach
<li class="pull-right">
@foreach ($post->parent->localesExcept(app()->getLocale())->where('status', 'published') as $tmp_post)
<span class="label label-default label-lang">
	<a href="{{ url($tmp_post->locale . '/post/' . $tmp_post->slug) }}">@lang('locales.' . $tmp_post->locale)</a>
</span>
@endforeach
</li>