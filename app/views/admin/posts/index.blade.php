@extends('layouts.admin')
@section('content')
<table class="table table-hover">
	<thead>
		<tr>
			<th>Title</th>
			<th>Slug</th>
			<th>Locale</th>
			<th>Status</th>
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
				<button class="btn btn-default">Edit</button>
				<a href="#" class="btn btn-default">Delete</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
@stop