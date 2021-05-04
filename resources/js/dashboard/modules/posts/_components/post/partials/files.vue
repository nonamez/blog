<template>
	<div class="input-group mb-3 px-5">
		<div class="input-group mb-3">
			<input class="form-control" type="file" id="input-file">
			<button class="btn btn-outline-secondary" type="button" @click="uploadFile()">
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
import { createNamespacedHelpers } from 'vuex-composition-helpers';
import { useStore } from 'vuex';

const VUEX_MODULE = 'files';

const { useState } = createNamespacedHelpers(VUEX_MODULE);

export default {
	setup() {
		const store = useStore();

		return {
			...useState(['files']),

			uploadFile() {
				const el = document.getElementById('input-file');
				
				store.dispatch('files/upload', el.files[0]).then(status => {
					if (status) {
						el.value = null;
					}
				});
			},
		};
	}
};
</script>