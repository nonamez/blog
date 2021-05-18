<template>
	<table class="table">
		<thead>
			<tr class="text-left">
				<th>Title</th>
				<th>Parent ID</th>
				<th>Locale</th>
				<th>Status</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="p in posts" v-bind:key="p.id">
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

						<div class="dropdown">
							<button class="btn btn-outline-secondary btn-sm dropdown-toggle dropdown-in-group" type="button" data-bs-toggle="dropdown" aria-expanded="false">
								<i class="icond icon-trash"></i>
							</button>
							<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="#" @click.prevent="remove({id: p.id})">Current</a></li>
								<li><a class="dropdown-item" href="#" @click.prevent="remove({id: p.id, all: true})">All</a></li>
							</ul>
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

		store.dispatch(`${VUEX_MODULE}/fetch`);

		return {
			title_length: 35,

			posts: computed(() => store.state[VUEX_MODULE].posts),

			remove: options => store.dispatch(`${VUEX_MODULE}/remove`, options)
		};
	}
};
</script>