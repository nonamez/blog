@extends('layouts.admin', ['menu' => 'portfolio'])
@section('content')
<div class="panel">
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-12 col-md-5 col-md-offset-3">
				<form action="{{ route('admin.portfolio.codes.store') }}" method="POST">
					{{ csrf_field() }}
					<div class="input-group">
						<input type="text" class="form-control" name="title" placeholder="Title if necessary...">
						<span class="input-group-btn">
							<button class="btn btn-default" type="submit">Create Code</button>
						</span>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Title</th>
								<th>Code</th>
								<th>Used</th>
								<th>Created</th>
								<th>Updated</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($codes as $code)
							<tr>
								<td>{{ $code->title }}</td>
								<td>{{ $code->code }}</td>
								<td>{{ $code->used ? 'Yes' : 'No' }}</td>
								<td>{{ $code->created_at }}</td>
								<td>{{ $code->updated_at }}</td>
								<td>
									<a href="{{ route('admin.portfolio.codes.delete', $code->id) }}" class="btn btn-default btn-sm">
										<i class="fa fa-trash-o"></i>
									</a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@stop