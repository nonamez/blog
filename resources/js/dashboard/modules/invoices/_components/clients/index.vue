<template>
	<table class="table">
		<thead>
			<tr class="text-left">
				<th>Name</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="c in clients" v-bind:key="c.id">
				<td>{{ c.name }}</td>
				<td>
					<div class="btn-group" role="group">
						<button type="button" class="btn btn-outline-secondary btn-sm" @click="presentClientModal(c.id)">
							<i class="icond icon-pencil"></i>
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
			}

			// remove: options => store.dispatch(`${VUEX_MODULE}/remove`, options)
		};
	}
};
</script>