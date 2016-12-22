<div class="panel panel-default">
	<div class="panel-heading">Publish</div>
	<div class="panel-body">
		<div class="form-horizontal">
			<div class="form-group">
				<label for="language" class="col-sm-4 control-label">Language</label>
				<div class="col-sm-8">
					<select name="locale" id="language" class="form-control">
						<option value="en">English</option>
						<option value="ru">Русский</option>
						<option value="lt">Lietuviškai</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="status" class="col-sm-4 control-label">Status</label>
				<div class="col-sm-8">
					<select name="status" id="status" class="form-control">
						<option value="draft">Draft</option>
						<option value="published">Published</option>
						<option value="hidden">Hidden</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="parent-post" class="col-sm-4 control-label">Parent post</label>
				<div class="col-sm-8">
					<input id="parent-post" type="text" class="form-control" placeholder="Enter post id" name="parent_post_id" value="{{ $post->parent_post_id or '' }}">
				</div>
			</div>
			<div class="form-group">
				<label for="markdown" class="col-sm-4 control-label">MarkDown</label>
				<div class="col-sm-8">
					<div class="checkbox">
                        <input type="checkbox" name="markdown" id="markdown" checked="checked">
                        <label></label>
                    </div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6">
				<button type="button" class="btn btn-primary btn-block" data-loading-text="Saving..." id="posts-button-save" data-route="{{ $save_route }}">
					Save
				</button>
			</div>
			@if(isset($post))
			<div class="col-xs-6">
				<a href="{{ $post->getURL() }}" class="btn btn-default btn-block" target="_blank">Preview</a>
			</div>
			@endif
		</div>
	</div>
</div>