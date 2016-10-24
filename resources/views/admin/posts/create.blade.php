@extends('layouts.admin', ['menu' => 'posts'])
@section('content')
<div class="container">
	{{-- <div class="page-header"> --}}
		<h3 class="m-t-0">
			Add New Post
		</h3>
	{{-- </div> --}}

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
@push('scripts')
<script src="{{ elixir('js/admin/posts.js') }}"></script>
@endpush