@extends('layouts.admin')
@section('content')
{{ Form::open(['action' => 'Admin\PostController@store', 'class' => 'form-horizontal', 'style' => 'margin-bottom:15px']) }}
	<div class="row with-title" data-block-title="General">
		<div class="form-group">
			<label class="col-md-2 control-label">Title</label>
			<div class="col-md-8">
				{{ Form::text('title', NULL, ['class' => 'form-control', 'placeholder' => 'Enter Title']) }}
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label">content</label>
			<div class="col-md-8">
				{{ Form::textarea('content', NULL, ['class' => 'form-control', 'placeholder' => 'Enter text', 'size' => '5x5'])}}
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-6 with-title" data-block-title="Meta">
			<div class="form-group">
				<label class="col-md-4 control-label">Slug</label>
				<div class="col-md-8">
					{{ Form::text('slug', NULL, ['class' => 'form-control', 'placeholder' => 'Enter Slug']) }}
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Description</label>
				<div class="col-md-8">
					{{ Form::text('meta_description', NULL, ['class' => 'form-control', 'placeholder' => 'Enter Description']) }}
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Keywords</label>
				<div class="col-md-8">
					{{ Form::text('meta_keywords', NULL, ['class' => 'form-control', 'placeholder' => 'Enter Keywords']) }}
				</div>
			</div>
		</div>
		<div class="col-md-6 with-title with-title-right" data-block-title="Files">
			<div class="form-group">
				<div class="col-md-9 col-md-offset-1">
					<div class="input-group">
						<span class="input-group-btn">
							<button id="fake-file-button-browse" type="button" class="btn btn-default">Browse</button>
						</span>
						<input type="file" id="file-upload" style="display:none" name="image">
						<input type="text" id="fake-file-input-name" disabled="disabled" placeholder="File not selected" class="form-control">
					</div>
				</div>
			</div>
		</div>
	</div>
	<hr>
	<div class="row with-title" data-block-title="Tags">
		<div class="form-group">
			<div class="col-md-7 col-md-offset-2">
				<div class="input-group">
					<span class="input-group-addon">#</span>
					<input type="text" placeholder="Enter slug" class="form-control">
					<span class="input-group-addon" style="border-width:1px 0px">@</span>
					<input type="text" placeholder="Enter title" class="form-control">
					<span class="input-group-btn">
						<button type="button" class="btn btn-default">Create</button>
					</span>
				</div>
			</div>
		</div>
		<span class="label label-default tag">
			Default 
			<span data-role="remove"></span>
		</span>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-6 with-title" data-block-title="Options">
			<div class="form-group">
				<label class="col-md-6 control-label">Language</label>
				<div class="col-md-6">
					{{ Form::select('locale', $locales, NULL, array('class' => 'form-control'))}}
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-6 control-label">Status</label>
				<div class="col-md-6">
					<select class="form-control" name="status">
						<option value="draft">Draft</option>
						<option value="published">Published</option>
					</select>
				</div>
			</div>
		</div>
		<div class="col-md-6 with-title with-title-right" data-block-title="Actions">
			<div class="form-group">
				<div class="col-md-5 col-md-offset-3">
					<button class="btn btn-default btn-block" type="submit">Create</button>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-5 col-md-offset-3">
					<button class="btn btn-default btn-block" type="button" disabled="disabled">Update</button>
				</div>
			</div>
		</div>
	</div>
{{ Form::close() }}
@stop