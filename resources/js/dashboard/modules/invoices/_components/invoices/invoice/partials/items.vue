<template>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Items</th>
				<th>Quantity</th>
				<th>Price</th>
				<th>Amount</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="itm in items" v-bind:key="itm.id">
				<td>{{ itm.comment }}</td>
				<td>{{ itm.quantity }}</td>
				<td>{{ itm.price }}</td>
				<td>{{ itm.price * itm.quantity }}</td>
			</tr>
		</tbody>
	</table>
</template>
<script>
import { computed } from 'vue';
import { useStore } from 'vuex';

export default {
	setup() {
		const store = useStore();

		return {		
			items: computed(() => store.state.invoices.invoice.items),
		};
	}
};
</script>