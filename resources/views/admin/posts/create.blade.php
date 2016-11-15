@extends('admin.index', ['menu' => 'posts'])
@section('admin.content')
<h3 class="m-t-0">
	Add New Post
</h3>

<div class="row">
	<div class="col-xs-12 col-sm-6 col-md-8">
		@include('admin.posts.partials.post')
	</div>
	<div class="col-xs-12 col-sm-6 col-md-4">
		@include('admin.posts.partials.sidebar')
	</div>
</div>
@stop