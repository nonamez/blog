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
</div>
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
</div>
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
						</div> 
					</div>
				</div>
			</div>
		</div>
	</div>
</admin-post-tags>
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
							<button type="button" class="btn btn-default" disabled="disabled" id="fake-file-button-upload" v-on:click="upload('{{ route('admin.files.store') }}')">
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
</admin-post-files>