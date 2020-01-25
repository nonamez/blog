<template>
	<div class="container">
		<div class="card">
			<div class="card-header">
				Files
			</div>
			<div class="card-body">
				<div class="table-responsive">
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
									<a v-if="file.fileable" :href="file.fileable.routes.preview">{{ file.fileable.title }}</a>
								</td>
								<td>
									{{ file.created_at }}
								</td>
								<td>
									<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
										<a :href="file.routes.preview" target="blank" class="btn btn-outline-secondary"><i class="icon-link-ext"></i></a>
										<button type="button" class="btn btn-outline-secondary" @click="remove(file)">
											<i class="icon-trash"></i>
										</button>
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
	computed: {
		...mapState('files', ['files']),
		...mapGetters('files', ['pagination_simple'])
	},

	methods: {
		...mapActions('files', ['load', 'remove'])
	},

	created() {		
		this.$store.dispatch('files/load');
	}
};
</script>