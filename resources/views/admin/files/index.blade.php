@extends('layouts.admin', ['menu' => 'files'])
@section('content')
<div class="panel">
	<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Name</th>
								<th>Original name</th>
								<th>Type</th>
								<th>Created</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@forelse($files as $file)
							<tr>
								<td>
									{{ str_limit($file->name, 30) }}
								</td>
								<td>
									{{ str_limit($file->original_name, 30) }}
								</td>
								<td>
									@if($file->fileable instanceof App\Models\Blog\Post\Translated)
									<a href="{{ route('admin.posts.edit', $file->fileable->id) }}">
										Post
									</a>
									@elseif($file->type =='portfolio' && $file->portfolio)
									<a href="{{ route('admin_portfolio_edit_work', $file->portfolio->id) }}">Portfolio</a>
									@else
									None
									@endif
								</td>
								<td>{{ $file['created_at'] }}</td>
								<td>
									<div class="btn-group btn-group-sm" role="group" aria-label="...">
										<a href="{{ $file->getURL() }}" target="blank" class="btn btn-default">
											<i class="fa fa-file-o"></i>
										</a>
										<a href="{{ route('admin.files.delete', $file->id) }}" class="btn btn-default">
											<i class="fa fa-trash-o"></i>
										</a>
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
				</div>
			</div>
		</div>
	</div>
</div>
@stop