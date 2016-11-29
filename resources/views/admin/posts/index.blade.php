@extends('layouts.admin', ['menu' => 'posts'])
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-hover">
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
							<a href="{{ $post->getURL() }}">{{ str_limit($post->title, 60) }}</a>
						</td>
						<td>{{ $post->post_id }}</td>
						<td>{{ $post->locale }}</td>
						<td>{{ ucfirst($post->status) }}</td>
						<td>
							<div class="btn-group btn-group-sm" role="group" aria-label="..." style="width: 75px;">
								<a href="{{ route('admin.posts.edit', $post->id) }}"  class="btn btn-default">
									<i class="fa fa-pencil"></i>
								</a>
								<div class="btn-group btn-group-sm" role="group">
									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
										<i class="fa fa-trash-o"></i>
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li>
											<a href="{{ route('admin.posts.delete', $post->id) }}">Current</a>
										</li>
										<li>
											<a href="{{ route('admin.posts.delete', [$post->id, 'all']) }}">All</a>
										</li>
									</ul>
								</div>
							</div>
						</td>
					</tr>
					@empty
					<tr>
						<td colspan="5" class="bg-info text-center">
							Posts not found. Want to <a href="{{ route('admin.posts.create')}}">create</a> ?
						</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="text-center">
	{!! $posts->render() !!}
</div>
@stop