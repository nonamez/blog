@extends('layouts.admin', ['menu' => 'portfolio'])
@section('content')
<div class="row">
	<div class="col-xs-12 col-sm-6 col-md-8">
		@include('admin.portfolio.works.partials.work')
	</div>
	<div class="col-xs-12 col-sm-6 col-md-4">
		@include('admin.portfolio.works.partials.sidebar', ['save_route' => route('admin.portfolio.works.store')])
	</div>
</div>
@stop