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
									<!-- <div class="btn-group btn-group-sm" role="group" aria-label="..." style="width: 75px;">
										<a href="{{ route('admin.posts.edit', $post->id) }}"  class="btn btn-default">
											<i class="fa fa-pencil"></i>
										</a>
										<div class="btn-group btn-group-sm" role="group">
											<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
												<i class="fa fa-trash-o"></i>
												<span class="caret"></span>
											</button>
											<ul class="dropdown-menu" role="menu">
												<li>
													<a href="{{ route('admin.posts.delete', $post->id) }}">Current</a>
												</li>
												<li>
													<a href="{{ route('admin.posts.delete', [$post->id, 'all']) }}">All</a>
												</li>
											</ul>
										</div>
									</div> -->
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

	</div>
</template>
<script>

import route from 'helpers/route';

import { mapState } from 'vuex';

export default {
	data() {
		return {
			title_length: 35
		};
	},

	computed: {
		...mapState('post', ['posts'])
	},

	created() {
		this.$store.dispatch('post/load', route('dashboard.posts.index'));
	}
};
</script>