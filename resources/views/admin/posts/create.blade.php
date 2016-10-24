@extends('layouts.admin', ['menu' => 'posts'])
@section('content')
<div class="container">
	<div class="page-header">
		<h3>
			Add New Post
		</h3>
	</div>

	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-8">
			@include('admin.posts.partials.data')
		</div>
		<div class="col-xs-12 col-sm-6 col-md-4">
			@include('admin.posts.partials.sidebar')
		</div>
	</div>
</div>
@stop
@section('scripts')
<script src="{{ asset('/assets/admin/posts.js') }}"></script>
@stop