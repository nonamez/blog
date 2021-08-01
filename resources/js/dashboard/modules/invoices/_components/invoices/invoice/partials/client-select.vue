<template>
	<selectable-floating :options="clients" :default="client_id" @returnable="setClientId($event)" title="Customer"></selectable-floating>
</template>
<script>
import { computed } from 'vue';
import { useStore } from 'vuex';

export default {
	setup() {
		const store = useStore();

		store.dispatch('invoices/clients/fetch');

		return {
			client_id: computed(() => store.state.invoices.invoices.invoice.client_id),
			clients: computed(() => store.state.invoices.clients.clients),
			setClientId: (id) => {
				store.commit('invoices/invoices/invoice/setClientId', id);
			}
		};
	}
};
</script>