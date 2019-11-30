<template>
	<div class="container">
		<div class="card">
			<div class="card-header">
				Posts
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Title</th>
								<th>Parent ID</th>
								<th>Locale</th>
								<th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="post in posts" v-bind:key="post.id">
								<td>
									<a :href="post.routes.preview">{{ post.title.slice(0, title_length) + (post.title.length > title_length ? '...' : '') }}</a>
								</td>
								<td>{{ post.parent_post_id }}</td>
								<td>{{ post.locale }}</td>
								<td>{{ post.status }}</td>
								<td>
								
									<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
										<button type="button" class="btn btn-outline-secondary btn-sm" @click="$router.push({ name: 'posts.show', params: { post_id: post.id } })">
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
				</div>
				<pagination :data="pagination_simple" @reload="load"></pagination>
			</div>
		</div>
	</div>
</template>
<script>

import { mapState, mapGetters, mapActions } from 'vuex';

export default {
	data() {
		return {
			title_length: 35
		};
	},

	computed: {
		...mapState('posts', ['posts']),
		...mapGetters('posts', ['pagination_simple'])
	},

	methods: {
		...mapActions('posts', ['remove', 'load'])
	},

	created() {		
		this.$store.dispatch('posts/load');
	}
};
</script>