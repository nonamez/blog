<div class="panel panel-default">
	<div class="panel-heading">General</div>
	<div class="panel-body">
		<div class="form-group">
			<label>Title</label>
			<input type="text" class="form-control" placeholder="Enter Title" name="title" value="{{ old('title') }}">
		</div>

		<div class="form-group">
			<label>Content</label>
			<textarea name="content" cols="5" rows="5" class="form-control" placeholder="Enter text">{{ old('content') }}</textarea>
		</div>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">Meta</div>
	<div class="panel-body">
		<div class="form-group">
			<label>Slug</label>
			<input type="text" class="form-control" placeholder="Enter Slug" name="slug" value="{{ old('slug') }}">
		</div>

		<div class="form-group">
			<label>Description</label>
			<input type="text" class="form-control" placeholder="Enter Description" name="meta_description" value="{{ old('meta_description') }}">
		</div>

		<div class="form-group">
			<label>Keywords</label>
			<input type="text" class="form-control" placeholder="Enter Keywords" name="meta_keywords" value="{{ old('meta_keywords') }}">
		</div>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">Tags</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1">
				<div class="input-group">
					<span class="input-group-addon">#</span>
					<input type="text" class="form-control" placeholder="Enter slug" id="tags-input-slug">
					<span class="input-group-addon" style="border-width:1px 0px">@</span>
					<input type="text" class="form-control" placeholder="Enter name" id="tags-input-name">
					<span class="input-group-btn">
						<button type="button" class="btn btn-default" id="tags-button-create">Create</button>
					</span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div id="tags-div-container">
					@if (isset($tags['titles']))
					@for ($i = 0; $i < count($tags['titles']); $i++)
					<span class="label label-default tag">
						{{ $tags['titles'][$i] }}
						<span data-role="remove"></span>
						<input type="hidden" name="tags[slugs][]" value="{{ $tags['slugs'][$i] or '' }}">
						<input type="hidden" name="tags[titles][]" value="{{ $tags['titles'][$i] }}">
					</span>
					@endfor
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">Files</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-8 col-xs-offset-2"> 
				<div class="input-group">
					<span class="input-group-btn">
						<button id="fake-file-button-browse" type="button" class="btn btn-default">
							<i class="fa fa-file-o"></i>
						</button>
					</span>
					<input type="file" id="files-input-upload" style="display:none">
					<input type="text" id="fake-file-input-name" disabled="disabled" placeholder="File not selected" class="form-control">
					<span class="input-group-btn">
						<button type="button" class="btn btn-default" disabled="disabled" id="fake-file-button-upload" data-route="{{ route('admin.files.store') }}">
							<i class="fa fa-upload"></i>
						</button>
					</span>
				</div>
			</div>
		</div>
		@if (isset($files))
		@foreach ($files as $file)
		<div class="row">
			<div class="col-xs-8 col-xs-offset-2">
				<div class="input-group">
					<input type="text" class="form-control" readonly="readonly" value="{{ $file->getURL() }}">
					<input type="hidden" name="files[]" value="{{ $file->id }}" class="hide hidden">
					<span class="input-group-btn">
						<button type="button" class="btn btn-default files-button-delete" data-file-id="{{ $file->id }}">
							<i class="fa fa-trash-o"></i>
						</button>
					</span>
				</div>
			</div>
		</div>
		@endforeach
		@endif
	</div>
</div>