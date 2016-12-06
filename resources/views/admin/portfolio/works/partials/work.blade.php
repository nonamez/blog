<div class="panel panel-default">
	<div class="panel-heading">General</div>
	<div class="panel-body">
		<div class="form-group">
			<label>Title</label>
			<input type="text" class="form-control" placeholder="Enter Title" name="title" value="{{ $work->title or '' }}">
		</div>

		<div class="form-group">
			<label>Description</label>
			<textarea name="content" cols="5" rows="5" class="form-control" placeholder="Enter Description">{{ $work->description or '' }}</textarea>
		</div>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">Images</div>
	<div class="panel-body">
		<!-- Button trigger modal -->
		<div class="row">
			<div class="col-xs-12 col-sm-4 col-sm-offset-4">
				<button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#works-div-modal-add-image-container">
					Add image
				</button>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div class="table-responsive">
					<table class="table" id="works-table-images">
						<thead>
							<tr>
								<th>Image</th>
								<th>Description</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@if (isset($work))
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
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="works-div-modal-add-image-container" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">New Image</h4>
			</div>
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Description</label>
						<div class="col-sm-9">
							<textarea id="works-textarea-image-description" rows="2" class="form-control" placeholder="Enter Description"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-3 control-label">Image</label>
						<div class="col-sm-9">
							<div class="input-group">
								<span class="input-group-btn">
									<button class="btn btn-default" type="button" id="fake-file-button-browse">
										<i class="fa fa-file-o"></i>
									</button>
								</span>
								<input type="file" style="display:none" id="fake-file-input-upload">
								<input type="text" class="form-control" placeholder="File not selected" disabled="disabled" id="fake-file-input-name">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" data-route="{{ route('admin.files.store') }}" id="works-button-add-new-image">Add</button>
			</div>
		</div>
	</div>
</div>