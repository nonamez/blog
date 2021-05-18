<template>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Name</th>
				<th>Original Name</th>
				<th>Assigned</th>
				<th style="max-width: 50px">Created</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="file in files" v-bind:key="file.id">
				<td>
					{{ file.name }}
				</td>
				<td>
					{{ file.original_name }}
				</td>
				<td>
					<a v-if="file.assigned" :href="file.assigned.preview">{{ file.assigned.title }}</a>
				</td>
				<td>
					{{ file.created_at }}
				</td>
				<td>
					<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
						<a :href="file.routes.preview" target="blank" class="btn btn-outline-secondary">
							<i class="icon-link-ext"></i>
						</a>
						<button type="button" class="btn btn-outline-secondary" @click="remove(file)">
							<i class="icon-trash"></i>
						</button>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
</template>
<script>
import { computed } from 'vue';
import { useStore } from 'vuex';

const VUEX_MODULE = 'files';

export default {
	setup() {
		const store = useStore();

		store.dispatch(`${VUEX_MODULE}/fetch`);

		return {
			files: computed(() => store.state[VUEX_MODULE].files),

			remove: (file) => store.dispatch(`${VUEX_MODULE}/remove`, file)
		};
	}
};
</script>