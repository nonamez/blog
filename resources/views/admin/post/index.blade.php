@extends('layouts.admin', ['menu' => 'posts'])
@section('content')
<table class="table table-hover">
	<thead>
		<tr>
			<th>Title</th>
			<th>Slug</th>
			<th>Parent ID</th>
			<th>Locale</th>
			<th>Status</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		@forelse($posts as $post)
		<tr>
			<td>
				<div class="scrollable">{{ $post['title'] }}</div>
			</td>
			<td>
				<div class="scrollable">{{ $post['slug'] }}</div>
			</td>
			<td>{{ $post['post_id'] }}</td>
			<td>{{ $post['locale'] }}</td>
			<td>{{ ucfirst($post['status']) }}</td>
			<td>
				<div class="btn-group btn-group-sm" role="group" aria-label="...">
					<a href="{{ url(sprintf('/%s/post/%s', $post['locale'], $post['slug'])) }}" target="blank" class="btn btn-default">
						<i class="fa fa-external-link"></i>
					</a>
					<a href="{{ route('admin_post_update', $post['id']) }}"  class="btn btn-default">
						<i class="fa fa-pencil"></i>
					</a>
					<div class="btn-group btn-group-sm" role="group">
						<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
							<i class="fa fa-trash-o"></i>
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li>
								<a href="{{ route('admin_post_delete', array($post['id'])) }}">Current</a>
							</li>
							<li>
								<a href="{{ route('admin_post_delete', array($post['id'], 'all')) }}">All</a>
							</li>
						</ul>
					</div>
				</div>
			</td>
		</tr>
		@empty
		<tr>
			<td colspan="6" class="bg-info text-center">
				Posts not found. Want to <a href="{{ route('admin_post_create')}}">create</a> ?
			</td>
		</tr>
		@endforelse
	</tbody>
</table>
<div class="text-center">
	{!! $posts->render() !!}
</div>
@stop