@extends('layouts.admin', ['menu' => 'portfolio'])
@section('content')
<form action="{{ $route }}" method="POST" class="form-horizontal" style="margin-bottom:15px">
	{{ csrf_field() }}
	<div class="row">
		<div class="form-group">
			<label class="col-sm-2 control-label">Title</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" placeholder="Enter Title" name="title" value="{{ $work->title or old('title') }}">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Description</label>
			<div class="col-sm-8">
				<textarea name="description" cols="5" rows="5" class="form-control" placeholder="Enter Text">{{ $work->description or old('description') }}</textarea>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-4 col-sm-offset-4">
				<button class="btn btn-success btn-block">Save</button>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-sm-5 col-sm-offset-1">
			<div class="form-group">
				<label for="portfolio-textarea-image-description">Description</label>
				<textarea id="portfolio-textarea-image-description" rows="2" class="form-control" placeholder="Enter Description"></textarea>
			</div>
		</div>
		<div class="col-sm-4 col-sm-offset-1">
			<div class="form-group">
				<label for="fake-file-button-browse">Image</label>
				<div class="input-group">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button" id="fake-file-button-browse">
							<i class="fa fa-file-o"></i>
						</button>
					</span>
					<input type="file" style="display:none" id="files-input-upload">
					<input type="text" class="form-control" placeholder="File not selected" disabled="disabled" id="fake-file-input-name">
				</div>
			</div>
		</div>
		<div class="col-sm-4 col-sm-offset-4">
			<button class="btn btn-default btn-block" type="button" id="portfolio-button-upload-image">Add</button>
		</div>
	</div>
	<hr>
	<div class="row">
		<table class="table" id="portfolio-table-images">
			<thead>
				<tr>
					<th>Image</th>
					<th>Description</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@if ($work !== NULL)
				@foreach($work->images as $image)
				<tr>
					<td class="text-center">
						<a href="{{ $image->getURL() }}"><img width="140" height="140" src="{{ $image->getURL() }}" class="img-thumbnail"></a>
					</td>
					<td>
						<textarea class="form-control" rows="1" cols="30">{{ $image->description }}</textarea>
					</td>
					<td>
						<button class="btn btn-default" type="button" data-file-id="{{ $image->id }}">Update</button>
						<button class="btn btn-default portfolio-button-delete-image" type="button" data-file-id="{{ $image->id }}">Delete</button>
						<input type="hidden" name="images[]" value="{{ $image->id }}">
					</td>
				</tr>
				@endforeach
				@endif
			</tbody>
		</table>
	</div>
</form>
@stop
@section('scripts')
<script src="{{ asset('/assets/admin/portfolio.js') }}"></script>
@stop