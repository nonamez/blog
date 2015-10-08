@extends('layouts.admin')
@section('content')
<table class="table table-hover">
	<thead>
		<tr>
			<th>Name</th>
			<th>Original name</th>
			<th>Created</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		@forelse($files as $file)
		<tr>
			<td>
				<div class="scrollable">{{ $file->name }}</div>
			</td>
			<td>
				<div class="scrollable">{{ $file->original_name }}</div>
			</td>
			<td>{{ $file['created_at'] }}</td>
			<td>
				<div class="btn-group btn-group-sm" role="group" aria-label="...">
					<a href="{{ route('file_get', [$file->created_at->format('Y-m-d'), $file->name]) }}" target="blank" class="btn btn-default">
						<i class="fa fa-file-o"></i>
					</a>
					<a href="{{ route('admin_file_delete', $file->id) }}" class="btn btn-default">
						<i class="fa fa-trash-o"></i>
					</a>
					@if($file->post)
					<a href="{{ route('admin_post_edit', $file->post->id) }}" class="btn btn-default">
						<i class="fa fa-external-link"></i>
					</a>
					@endif
				</div>
			</td>
		</tr>
		@empty
		<tr>
			<td colspan="6" class="bg-info text-center">
				Files not found.
			</td>
		</tr>
		@endforelse
	</tbody>
</table>
<div class="text-center">
	{!! $files->render() !!}
</div>
@stop