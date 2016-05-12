@extends('layouts.admin', ['menu' => 'portfolio'])
@section('content')
<table class="table">
	<caption>
		<a href="{{ route('admin_portfolio_create_work') }}" class="btn btn-sm btn-default pull-right">Add New Work</a>
	</caption>
	<thead>
		<tr>
			<th>#</th>
			<th>Title</th>
			<th class="text-center">Created</th>
			<th class="text-center">Images</th>
			<th class="text-center">Actions</th>
		</tr>
	</thead>
	<tbody>
		@forelse($works as $work)
		<tr>
			<th scope="row">{{ $work->id }}</th>
			<td>{{ $work->title }}</td>
			<td class="text-center">{{ $work->created_at }}</td>
			<td class="text-center">{{ $work->images->count() }}</td>
			<td class="text-center">
				<div class="btn-group btn-group-sm" role="group" aria-label="...">
					<a href="#" target="blank" class="btn btn-default">
						<i class="fa fa-external-link"></i>
					</a>
					<a href="{{ route('admin_portfolio_edit_work', $work->id) }}"  class="btn btn-default">
						<i class="fa fa-pencil"></i>
					</a>
					<a href="{{ route('admin_portfolio_delete_work', $work->id) }}"  class="btn btn-default">
						<i class="fa fa-trash-o"></i>
					</a>
				</div>
			</td>
		</tr>
		@empty
		<tr>
			<td class="bg-info text-center" colspan="5">
				Works not found.
			</td>
		</tr>
		@endforelse
	</tbody>
</table>
@stop