<div class="panel panel-default">
	<div class="panel-heading">General</div>
	<div class="panel-body">
		<div class="form-group">
			<label>Title</label>
			<input type="text" class="form-control" placeholder="Enter Title" name="title" value="{{ $post->title or '' }}">
		</div>

		<div class="form-group">
			<label>Content</label>
			<textarea name="content" cols="5" rows="5" class="form-control" placeholder="Enter text">{{ $post->content or '' }}</textarea>
		</div>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">Meta</div>
	<div class="panel-body">
		<div class="form-group">
			<label>Slug</label>
			<input type="text" class="form-control" placeholder="Enter Slug" name="slug" value="{{ $post->slug or '' }}">
		</div>

		<div class="form-group">
			<label>Title</label>
			<input type="text" class="form-control" placeholder="Enter Title" name="meta_title" value="{{ $post->meta_title or '' }}">
		</div>

		<div class="form-group">
			<label>Description</label>
			<input type="text" class="form-control" placeholder="Enter Description" name="meta_description" value="{{ $post->meta_description or '' }}">
		</div>

		<div class="form-group">
			<label>Keywords</label>
			<input type="text" class="form-control" placeholder="Enter Keywords" name="meta_keywords" value="{{ $post->meta_keywords or '' }}">
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
				<div id="posts-div-tags-container">
					@if (isset($post))
					@foreach ($post->tags as $tag)
					<span class="label label-default tag" data-slug="{{ $tag->slug }}" data-name="{{ $tag->name }}">
						{{ $tag->name }}
						<span data-role="remove"></span>
					</span>
					@endforeach
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

		<div class="row">
			<div class="col-xs-8 col-xs-offset-2 p-t-15">
				<ul class="list-group" id="posts-div-files-container">
					@if (isset($post))
					@foreach ($post->files as $file)
					<li class="list-group-item" data-file-id="{{ $file->id }}">
						<div class="row">
							<div class="col-xs-12 col-sm-8">{{ $file->name }}</div>
							<div class="col-xs-12 col-sm-4 text-right">
								<div class="btn-group btn-group-sm" role="group" aria-label="...">
									<button type="button" class="btn btn-default"><i class="fa fa-download" aria-hidden="true"></i></button>
									<button type="button" class="btn btn-default" data-role="remove-file" data-file-id="{{ $file->id }}"><i class="fa fa-trash"></i></button>
								</div>
							</div>
						</div>
					</li>
					@endforeach
					@endif
				</ul>
			</div>
		</div>
	</div>
</div>