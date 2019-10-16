@extends('layouts.blog')
@section('content')
<section class="pt-5">
	@foreach ($posts as $post)
	<div class="flex flex-wrap post-meta">
		<div class="w-full md:w-1/5">
			<div class="post-left-part">
				<time datetime="{{ $post->date }}">{{ $post->date->diffForHumans() }}</time>
			</div>
		</div>
		<div class="w-full md:w-4/5">
			<div class="post-content">
				<h1 class="post-title">
					<a href="{{ $post->routes->preview }}">{{ $post->title }}</a>
				</h1>
			</div>
		</div>
	</div>
	@endforeach
	<div class="text-center">
		{!! $posts->render() !!}
	</div>
</section>
@stop