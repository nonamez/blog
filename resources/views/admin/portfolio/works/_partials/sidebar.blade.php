<div class="panel panel-default">
	<div class="panel-heading">Publish</div>
	<div class="panel-body">
		
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