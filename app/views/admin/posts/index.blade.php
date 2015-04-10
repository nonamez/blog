@extends('layouts.admin')
@section('content')
<table class="table table-hover">
	<thead>
		<tr>
			<th>Title</th>
			<th>Slug</th>
			<th>Locale</th>
			<th>Status</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		@foreach($posts as $post)
		<tr>
			<td>{{ $post['title'] }}</td>
			<td>{{ $post['slug'] }}</td>
			<td>{{ $post['locale'] }}</td>
			<td>{{ ucfirst($post['status']) }}</td>
			<td>
				<div class="btn-group" role="group" aria-label="...">
					<button type="button" class="btn btn-default">Edit</button>
					<div class="btn-group" role="group">
						<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
							Delete
							<span class="caret"></span>
						</button>
						
						<ul class="dropdown-menu" role="menu">
							<li>
								<a href="{{ URL::action('Admin\PostController@getDelete', array($post['id'])) }}">Current</a>
							</li>
							<li>
								<a href="{{ URL::action('Admin\PostController@getDelete', array($post['id'], 'translations')) }}">Other translations</a>
							</li>
						</ul>
					</div>
				</div>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
@stop