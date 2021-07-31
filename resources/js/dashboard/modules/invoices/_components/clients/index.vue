<template>
	<table class="table">
		<thead>
			<tr class="text-left">
				<th>Name</th>
				<th>Country</th>
				<th>Created</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="c in clients" v-bind:key="c.id">
				<td>{{ c.name }}</td>
				<td>{{ c.country }}</td>
				<td>{{ c.created_at }}</td>
				<td>
					<div class="btn-group" role="group">
						<button type="button" class="btn btn-outline-secondary btn-sm" @click="presentClientModal(c.id)">
							<i class="icond icon-pencil"></i>
						</button>
						<button type="button" class="btn btn-outline-secondary btn-sm" @click="remove(c.id)">
							<i class="icond icon-trash"></i>
						</button>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	<client-modal ref="clientModal"></client-modal>
</template>
<script>
import { computed, ref } from 'vue';
import { useStore } from 'vuex';

const VUEX_MODULE = 'invoices/clients';

export default {
	components: {
		'client-modal': require('./modals/client.vue').default
	},

	setup() {
		const store = useStore();
		const clientModal = ref(null);

		store.dispatch(`${VUEX_MODULE}/fetch`);

		return {
			clientModal,

			clients: computed(() => store.state.invoices.clients.clients),

			presentClientModal: (id) => {
				clientModal.value?.show(id);
			},

			remove: id => store.dispatch(`${VUEX_MODULE}/remove`, id)
		};
	}
};
</script>