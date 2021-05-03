<template>
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
				<td>
					<div class="btn-group" role="group">
						<button type="button" class="btn btn-outline-secondary btn-sm" @click="$router.push({ name: 'posts.post', params: { id: p.id } })">
							<i class="icond icon-pencil"></i>
						</button>

						<div class="btn-group" role="group">
							<button id="btnGroupDrop1" type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="icond icon-trash"></i>
							</button>
							<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
								<a class="dropdown-item" href="#" @click.prevent="remove({id: post.id})">Current</a>
								<a class="dropdown-item" href="#" @click.prevent="remove({id: post.id, all: true})">All</a>
							</div>
						</div>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
</template>
<script>
import { computed } from 'vue';
import { useStore } from 'vuex';

const VUEX_MODULE = 'posts';

export default {
	setup() {
		const store = useStore();

		// console.log(store)

		store.dispatch(`${VUEX_MODULE}/fetch`);

		return {
			posts: computed(() => store.state[VUEX_MODULE].posts),
			title_length: 35
		};
	}
};
</script>