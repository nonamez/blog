<template>
	<div class="input-group mb-3 px-5">
		<div class="custom-file">
			<input type="file" class="custom-file-input" id="input-file">
			<label class="custom-file-label" for="input-file">Choose file</label>
		</div>
		<div class="input-group-append">
			<button class="btn btn-outline-secondary secondary-button-light-border" type="button" @click="uploadFile()">
				<i class="icon-plus-circled"></i>
			</button>
		</div>
	</div>
	<ul class="list-group list-group-flush">
		<li class="list-group-item d-flex justify-content-between" v-for="file in files" v-bind:key="file.id">
			<div>
				{{ file.name }}
			</div>
			<div class="btn-group btn-group-sm" role="group">
				<a :href="file.routes.preview" target="blank" type="button" class="btn btn-outline-secondary">
					<i class="icon-file-image"></i>
				</a>
				<button type="button" class="btn btn-outline-secondary" @click="removeFile(file)">
					<i class="icon-trash"></i>
				</button>
			</div>
		</li>
	</ul>
</template>
<script>
export default {
	setup() {
		return {
			files: []
		};
	}
};
</script>