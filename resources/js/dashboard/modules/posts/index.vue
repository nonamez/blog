<template>
	<div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
		<table class="table">
			<thead>
				<tr class="text-left">
					<!-- <th>
						<label>
							<input type="checkbox">
						</label>
					</th> -->
					<th>Title</th>
					<th>Parent ID</th>
					<th>Locale</th>
					<th>Status</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="p in posts" v-bind:key="p.id">
					<!-- <td>
						<label>
							<input type="checkbox" name="1">
						</label>
					</td> -->
					<td>
						<a :href="p.routes.preview">{{ p.title.slice(0, title_length) + (p.title.length > title_length ? '...' : '') }}</a>
					</td>
					<td>{{ p.parent_post_id }}</td>
					<td>{{ p.locale }}</td>
					<td>{{ p.status }}</td>
				</tr>
			</tbody>
		</table>
	</div>
</template>
<script>
import { computed } from 'vue';
import { useStore } from 'vuex';

const VUEX_MODULE = 'posts';

export default {
	setup() {
		const store = useStore();

		store.dispatch(`${VUEX_MODULE}/fetch`);

		return {
			posts: computed(() => store.state[VUEX_MODULE].posts),
			title_length: 35
		};
	}
};
</script>