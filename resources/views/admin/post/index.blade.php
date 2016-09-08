@extends('layouts.admin', ['menu' => 'posts'])
@section('content')
<div class="container">
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-hover">
				<caption>
					<a class="btn btn-sm btn-default pull-right" href="{{ route('admin_post_create') }}">Create New Post</a>
				</caption>
				<thead>
					<tr>
						<th>Title</th>
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
							<div class="scrollable">{{ $post->title }}</div>
						</td>
						<td>{{ $post->post_id }}</td>
						<td>{{ $post->locale }}</td>
						<td>{{ ucfirst($post->status) }}</td>
						<td>
							<div class="btn-group btn-group-sm" role="group" aria-label="...">
								<a href="{{ url(sprintf('/%s/post/%s', $post->locale, $post->slug)) }}" target="blank" class="btn btn-default">
									<i class="fa fa-external-link"></i>
								</a>
								<a href="{{ route('admin_post_update', $post->id) }}"  class="btn btn-default">
									<i class="fa fa-pencil"></i>
								</a>
								<div class="btn-group btn-group-sm" role="group">
									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
										<i class="fa fa-trash-o"></i>
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li>
											<a href="{{ route('admin_post_delete', $post->id) }}">Current</a>
										</li>
										<li>
											<a href="{{ route('admin_post_delete', [$post->id, 'all']) }}">All</a>
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
		</div>
	</div>
	<div class="col-md-12">
		<div class="text-center">
			{!! $posts->render() !!}
		</div>
	</div>
</div>
@stop