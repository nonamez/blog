@extends('layouts.admin', ['menu' => 'portfolio'])
@section('content')
<div class="row">
	<div class="col-xs-12 col-sm-6 col-md-8">
		@include('admin..portfolio.works._partials.work')
	</div>
	<div class="col-xs-12 col-sm-6 col-md-4">
		@include('admin..portfolio.works._partials.sidebar', ['save_route' => route('admin.posts.store')])
	</div>
</div>
@stop