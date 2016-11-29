<div class="panel panel-default">
	<div class="panel-heading">Publish</div>
	<div class="panel-body">
		<div class="form-group">
			<label>Language</label>
			<select name="locale" class="form-control">
				@foreach($locales as $locale)
				<option value="{{ $locale }}">{{ $locale }}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group">
			<label>Status</label>
			<select name="status" class="form-control">
				<option value="draft">Draft</option>
				<option value="published">Published</option>
				<option value="hidden">Hidden</option>
			</select>
		</div>
		<div class="form-group">
			<label>Parent post</label>
			<input type="text" class="form-control" placeholder="Enter post id" name="parent_post_id" value="{{ $post->parent_post_id or '' }}">
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
@if(isset($post))
@push('scripts')
<script>
	jQuery('select[name="locale"]').val('{{ $post->locale }}')
	jQuery('select[name="status"]').val('{{ $post->status }}')
</script>
@endpush
@endif