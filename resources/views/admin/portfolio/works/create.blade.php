@extends('layouts.admin', ['menu' => 'portfolio'])
@section('content')
<h3 class="m-t-0">
	Add New Work
</h3>

<div class="row">
	<div class="col-xs-12 col-sm-6 col-md-8">
		@include('admin..portfolio.works._partials.work')
	</div>
	<div class="col-xs-12 col-sm-6 col-md-4">
		{{-- @include('admin.posts.partials.sidebar', ['save_route' => route('admin.posts.store')]) --}}
	</div>
</div>
@stop
@section('scripts')
<script src="{{ asset('/assets/admin/portfolio.js') }}"></script>
@stop