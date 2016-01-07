@extends('layouts.admin', ['menu' => 'posts'])
@section('content')
<form action="{{ route('admin_post_update', $post->id) }}" method="POST" class="form-horizontal" style="margin-bottom:15px">
	{{ csrf_field() }}
	<div class="row with-title" data-block-title="General">
		<div class="form-group">
			<label class="col-md-2 control-label">Title</label>
			<div class="col-md-8">
				<input type="text" name="title" value="{{ $post->title }}" class="form-control" placeholder="Enter Title">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label">content</label>
			<div class="col-md-8">
				<textarea name="content" class="form-control" placeholder="Enter text" rows="5" cols="5">{!! $post->content !!}</textarea>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-6 with-title" data-block-title="Meta">
			<div class="form-group">
				<label class="col-md-4 control-label">Slug</label>
				<div class="col-md-8">
					<input type="text" name="slug" value="{{ $post->slug }}" class="form-control" placeholder="Enter Slug">
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Description</label>
				<div class="col-md-8">
					<input type="text" name="meta_description" value="{{ $post->meta_description }}" class="form-control" placeholder="Enter Description">
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Keywords</label>
				<div class="col-md-8">
					<input type="text" name="meta_keywords" value="{{ $post->meta_keywords }}" class="form-control" placeholder="Enter Keywords">
				</div>
			</div>
		</div>
		<div class="col-md-6 with-title with-title-right" data-block-title="Files" id="files-div-container">
			<div class="form-group">
				<div class="col-md-9 col-md-offset-1"> 
					<div class="input-group">
						<span class="input-group-btn">
							<button id="fake-file-button-browse" type="button" class="btn btn-default"><i class="fa fa-file-o"></i></button>
						</span>
						<input type="file" id="files-input-upload" style="display:none">
						<input type="text" id="fake-file-input-name" disabled="disabled" placeholder="File not selected" class="form-control">
						<span class="input-group-btn">
							<button type="button" class="btn btn-default" disabled="disabled" id="fake-file-button-upload"><i class="fa fa-upload"></i></button>
						</span>
					</div>
				</div>
			</div>
			<hr>
			@foreach ($post->files as $file)
			<div class="form-group">
				<div class="col-md-9 col-md-offset-1">
					<div class="input-group">
						<input type="text" class="form-control" readonly="readonly" value="{{ URL::route('file_get', array( $file['created_at']->format('Y-m-d'), $file['name'])) }}">
						<input type="hidden" name="files[]" value="{{ $file['id'] }}" class="hide hidden">
						<span class="input-group-btn">
							<button type="button" class="btn btn-default files-button-delete" data-file-id="{{ $file['id'] }}">
								<i class="fa fa-trash-o"></i>
							</button>
						</span>
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>
	<hr>
	<div class="row with-title" data-block-title="Tags">
		<div class="form-group">
			<div class="col-md-7 col-md-offset-2">
				<div class="input-group">
					<span class="input-group-addon">#</span>
					<input type="text" class="form-control" placeholder="Enter slug" id="tags-input-slug">
					<span class="input-group-addon" style="border-width:1px 0px">@</span>
					<input type="text" class="form-control" placeholder="Enter title" id="tags-input-title">
					<span class="input-group-btn">
						<button type="button" class="btn btn-default" id="tags-button-create">Create</button>
					</span>
				</div>
			</div>
		</div>
		<div id="tags-div-container">
			@foreach ($post->tags as $tag)
			<span class="label label-default tag">
				{{ $tag['name'] }}
				<span data-role="remove"></span>
				<input type="hidden" name="tags[ids][]" value="{{ $tag['id'] }}">
			</span>
			@endforeach
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-6 with-title" data-block-title="Options">
			<div class="form-group">
				<label class="col-md-6 control-label">Language</label>
				<div class="col-md-6">
					<select name="locale" class="form-control">
						@foreach($locales as $locale)
						<option value="{{ $locale }}"{{ $post->locale == $locale ? ' selected="selected"' : ''}}>{{ $locale }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-6 control-label">Status</label>
				<div class="col-md-6">
					<select name="status" class="form-control">
						<option value="draft"{{ $post->status == 'draft' ? ' selected="selected"' : ''}}>Draft</option>
						<option value="published"{{ $post->status == 'published' ? ' selected="selected"' : ''}}>Published</option>
						<option value="hidden"{{ $post->status == 'hidden' ? ' selected="selected"' : ''}}>Hidden</option>
					</select>
				</div>
			</div>
		</div>
		<div class="col-md-6 with-title with-title-right" data-block-title="Actions">
			<div class="form-group">
				<div class="col-md-7 col-md-offset-1">
					<div class="input-group">
						<span class="input-group-addon">Parent post</span>
						<input type="text" class="form-control" placeholder="Enter post id" name="parent_post" value="{{ $post->parent->id }}">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-7 col-md-offset-1">
					<button class="btn btn-success btn-block" type="submit">Update</button>
				</div>
			</div>
		</div>
	</div>
</form>
@stop
@section('scripts')
<script src="{{ asset('/assets/admin/app.js') }}"></script>
@stop