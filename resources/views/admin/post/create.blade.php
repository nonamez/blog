@extends('layouts.admin')
@section('content')
<form action="{{ route('admin_post_store') }}" method="POST" class="form-horizontal" style="margin-bottom:15px">
	{{ csrf_field() }}
	<div class="row with-title" data-block-title="General">
		<div class="form-group">
			<label class="col-md-2 control-label">Title</label>
			<div class="col-md-8">
				<input type="text" class="form-control" placeholder="Enter Title" name="title" value="{{ old('title') }}">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label">content</label>
			<div class="col-md-8">
				<textarea name="content" cols="5" rows="5" class="form-control" placeholder="Enter text">{{ old('content') }}</textarea>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-6 with-title" data-block-title="Meta">
			<div class="form-group">
				<label class="col-md-4 control-label">Slug</label>
				<div class="col-md-8">
					<input type="text" class="form-control" placeholder="Enter Slug" name="slug" value="{{ old('slug') }}">
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Description</label>
				<div class="col-md-8">
					<input type="text" class="form-control" placeholder="Enter Description" name="meta_description" value="{{ old('meta_description') }}">
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Keywords</label>
				<div class="col-md-8">
					<input type="text" class="form-control" placeholder="Enter Keywords" name="meta_keywords" value="{{ old('meta_keywords') }}">
				</div>
			</div>
		</div>
		<div class="col-md-6 with-title with-title-right" data-block-title="Files" id="files-div-container">
			<div class="form-group">
				<div class="col-md-9 col-md-offset-1"> 
					<div class="input-group">
						<span class="input-group-btn">
							<button id="fake-file-button-browse" type="button" class="btn btn-default">
								<i class="fa fa-file-o"></i>
							</button>
						</span>
						<input type="file" id="files-input-upload" style="display:none">
						<input type="text" id="fake-file-input-name" disabled="disabled" placeholder="File not selected" class="form-control">
						<span class="input-group-btn">
							<button type="button" class="btn btn-default" disabled="disabled" id="fake-file-button-upload">
								<i class="fa fa-upload"></i>
							</button>
						</span>
					</div>
				</div>
			</div>
			<hr>
			@foreach ($files as $file)
			<div class="form-group">
				<div class="col-md-9 col-md-offset-1">
					<div class="input-group">
						<input type="text" class="form-control" readonly="readonly" value="{{ route('file_get', [$file['created_at']->format('Y-m-d'), $file['name']]) }}">
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
			@if (isset($tags['titles']))
			@for($i = 0; $i < count($tags['titles']); $i++)
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
	<hr>
	<div class="row">
		<div class="col-md-6 with-title" data-block-title="Options">
			<div class="form-group">
				<label class="col-md-6 control-label">Language</label>
				<div class="col-md-6">
					<select name="locale" class="form-control">
						@foreach($locales as $locale)
						<option value="{{ $locale }}"{{ old('locale') == $locale ? ' selected="selected"' : ''}}>{{ $locale }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-6 control-label">Status</label>
				<div class="col-md-6">
					<select name="status" class="form-control">
						<option value="draft"{{ old('status') == 'draft' ? ' selected="selected"' : ''}}>Draft</option>
						<option value="published"{{ old('status') == 'published' ? ' selected="selected"' : ''}}>Published</option>
					</select>
				</div>
			</div>
		</div>
		<div class="col-md-6 with-title with-title-right" data-block-title="Actions">
			<div class="form-group">
				<div class="col-md-7 col-md-offset-1">
					<div class="input-group">
						<span class="input-group-addon">Parent post</span>
						<input type="text" class="form-control" placeholder="Enter post id" name="parent_post">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-7 col-md-offset-1">
					<button class="btn btn-success btn-block" type="submit">Create</button>
				</div>
			</div>
		</div>
	</div>
</form>
@stop
@section('scripts')
<script src="{{ asset('/assets/admin/app.js') }}"></script>
@stop