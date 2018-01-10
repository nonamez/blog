@extends('layouts.admin', ['menu' => 'posts'])
@section('content')
<div class="container" id="app" style="display: none">
	<h3 class="m-t-0" v-if="!post.id">
		@{{post.id ? 'Edit Post' : 'Add New Post'}}
	</h3>
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading">General</div>
				<div class="panel-body">
					<div class="form-group">
						<label>Title</label>
						<input type="text" class="form-control" placeholder="Enter Title" v-model="post.title">
					</div>

					<div class="form-group">
						<label>Content</label>
						<textarea v-model="post.content" cols="5" rows="5" class="form-control" placeholder="Enter text"></textarea>
					</div>
				</div>
			</div> <!-- /.panel -->
			<div class="panel panel-default">
				<div class="panel-heading">Meta</div>
				<div class="panel-body">
					<div class="form-group">
						<label>Slug</label>
						<input type="text" class="form-control" placeholder="Enter Slug" v-model="post.slug">
					</div>

					<div class="form-group">
						<label>Title</label>
						<input type="text" class="form-control" placeholder="Enter Title" v-model="post.meta_title">
					</div>

					<div class="form-group">
						<label>Description</label>
						<input type="text" class="form-control" placeholder="Enter Description" v-model="post.meta_description">
					</div>

					<div class="form-group">
						<label>Keywords</label>
						<input type="text" class="form-control" placeholder="Enter Keywords" v-model="post.meta_keywords">
					</div>
				</div>
			</div> <!-- /.panel -->
			<admin-post-tags inline-template :tags="post.tags">
				<div class="panel panel-default">
					<div class="panel-heading">Tags</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Enter slug" v-model="tag.slug">
									<span class="input-group-addon" style="border-width:1px 0px">
										<i class="fa fa-exchange" aria-hidden="true"></i>
									</span>
									<input type="text" class="form-control" placeholder="Enter name" v-model="tag.name">
									<span class="input-group-btn">
										<button type="button" class="btn btn-default" v-on:click="create()">Create</button>
									</span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<div class="m-t-15">
									<div v-for="(tag, index) in tags" class="btn-group btn-group-sm m-b-5">
										<button type="button" class="btn btn-default" disabled="disabled">@{{ tag.name }}</button>
										<button type="button" class="btn btn-default" v-on:click="tags.splice(index, 1)">
											<i class="fa fa-trash"></i>
										</button>
										&nbsp;
									</div> 
								</div>
							</div>
						</div>
					</div>
				</div>
			</admin-post-tags> <!-- /admin-post-tags -->
			<admin-post-files inline-template :files="post.files">
				<div class="panel panel-default">
					<div class="panel-heading">Files</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-xs-12 col-sm-7 col-sm-offset-2"> 
								<div class="input-group">
									<span class="input-group-btn">
										<button id="fake-file-button-browse" type="button" class="btn btn-default">
											<i class="fa fa-file-o"></i>
										</button>
									</span>
									<input type="file" id="files-input-upload" style="display:none">
									<input type="text" id="fake-file-input-name" disabled="disabled" placeholder="File not selected" class="form-control">
									<span class="input-group-btn">
										<button type="button" data-trigger="hover" data-toggle="tooltip" data-placement="top" title="Watermark" :class="['btn', 'btn-default', {'active': watermark}]" :disabled="!selected" v-on:click="watermark = !watermark">
											<i class="fa fa-puzzle-piece" aria-hidden="true"></i>
										</button>
										<button type="button" class="btn btn-default" id="fake-file-button-upload" :disabled="!selected" v-on:click="upload('{{ route('admin.files.store') }}')">
											<i class="fa fa-upload"></i>
										</button>
									</span>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-12 col-sm-10 col-sm-offset-1 p-t-15">
								<ul class="list-group">
									<li v-for="(file, index) in files" class="list-group-item">
										<div class="row">
											<div class="col-xs-12 col-sm-8">@{{ file.name }}</div>
											<div class="col-xs-12 col-sm-4 text-right">
												<div class="btn-group btn-group-sm" role="group" aria-label="...">
													<a type="button" class="btn btn-default" :href="file.links.get" target="blank">
														<i class="fa fa-download"></i>
													</a>
													<button type="button" class="btn btn-default" v-on:click="remove(index)">
														<i class="fa fa-trash"></i>
													</button>
												</div>
											</div>
										</div>
									</li>

								</ul>
							</div>
						</div>
					</div>
				</div>
			</admin-post-files> <!-- /admin-post-files -->
		</div> <!-- post block end -->

		<div class="col-xs-12 col-sm-6 col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">Publish</div>
				<div class="panel-body">
					<div class="form-horizontal">
						<div class="form-group" v-if="post.date">
							<label for="language" class="col-sm-4 control-label">Date</label>
							<div class="col-sm-8">
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Enter date" v-model="post.date">
									<span class="input-group-btn">
										<button class="btn btn-default" type="button"  v-on:click="setPostDateToNow()">Now</button>
									</span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="language" class="col-sm-4 control-label">Language</label>
							<div class="col-sm-8">
								<select class="form-control"  v-model="post.locale">
									<option value="en">English</option>
									<option value="ru">Русский</option>
									<option value="lt">Lietuviškai</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="status" class="col-sm-4 control-label">Status</label>
							<div class="col-sm-8">
								<select class="form-control" v-model="post.status">
									<option value="draft">Draft</option>
									<option value="published">Published</option>
									<option value="hidden">Hidden</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="parent-post" class="col-sm-4 control-label">Parent post</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" placeholder="Enter post id" v-model="post.parent_post_id">
							</div>
						</div>
						<div class="form-group">
							<label for="markdown" class="col-sm-4 control-label">MarkDown</label>
							<div class="col-sm-8">
								<div class="checkbox">
									<input type="checkbox" v-model="post.markdown">
									<label></label>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<button type="button" class="btn btn-primary btn-block" data-loading-text="Saving..." v-on:click="save(post)">
								Save
							</button>
						</div>
						<div class="col-xs-6">
							<a :href="post.url" :disabled="!post.id" class="btn btn-default btn-block" target="_blank">Preview</a>
						</div>
					</div>
				</div>
			</div>
		</div> <!-- sidebar block end --> 
	</div>
</div>
@stop
@push('js')
<script>
	var _POST = {!! json_encode($post) !!};
	var _STORE_ROUTE = '{{ route('admin.posts.store') }}';
</script>
<script src="{{ mix('js/admin/post.js')}}"></script>
@endpush