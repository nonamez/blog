@extends('layouts.admin')
@section('content')
{{ Form::open(['route' => 'post_store', 'class' => 'form-horizontal', 'style' => 'margin-bottom:15px']) }}
	<input type="hidden" class="hide hidden" name="parent_post" id="parent-post">
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
		<div id="tags-div-container"></div>
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
				<div class="col-md-7 col-md-offset-1">
					<div aria-label="Button group with nested dropdown" role="group" class="btn-group">
						<div role="group" class="btn-group">
							<button class="btn btn-default btn-block dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true" id="post-to-assign-button-selected">
								Assign to post
							</button>
							<ul class="dropdown-menu scroll-menu" role="menu" id="post-to-assign-ul-posts">
								@foreach ($posts as $post)
								<li role="presentation">
									<a class="post-href-assign-to" role="menuitem" tabindex="-1" href="#" data-post-id="{{ $post }}">{{ $post }}</a>
								</li>
								@endforeach
								<li role="presentation" class="divider"></li>
								<li role="presentation">
									<a role="menuitem" tabindex="-1" href="#" id="post-to-assign-href-mode-posts">More</a>
								</li>
							</ul>
						</div>
						<button class="btn btn-default" type="button" disabled="disabled" id="post-to-assign-button-unassign">
							<i class="fa fa-chain-broken"></i>
						</button>
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
{{ Form::close() }}
@stop
@section('scripts')
<script src="{{ asset('/assets/admin/app.js') }}"></script>
@stop