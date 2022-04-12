<template>
	<div class="text-end">
		<button type="button" class="btn btn-success" @click="$router.push({ name: 'invoices.invoice' })">Create</button>
	</div>
	<table class="table">
		<thead>
			<tr class="text-left">
				<th>Number</th>
				<th>Date</th>
				<th>Client</th>
				<th>Status</th>
				<th>Amount</th>
				<th>Paid</th>
				<th class="text-end">Actions</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="inv in invoices" v-bind:key="inv.id">
				<td>INV-{{ inv.id }}</td>
				<td>{{ inv.invoiced_at }}</td>
				<td>{{ inv.client.name }}</td>
				<td>{{ inv.status }}</td>
				<td>{{ inv.total }}</td>
				<td>{{ inv.paid_at }}</td>
				<td class="text-end">
					<div class="btn-group" role="group">
						<button type="button" class="btn btn-outline-secondary btn-sm" @click="$router.push({ name: 'invoices.invoice', params: { id: inv.id } })">
							<i class="icond icon-pencil-dark"></i>
						</button>
						<button type="button" class="btn btn-outline-secondary btn-sm">
							<i class="icond icon-download-cloud"></i>
						</button>
						<button type="button" class="btn btn-outline-secondary btn-sm">
							<i class="icond icon-mail"></i>
						</button>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
</template>
<script>
import { computed } from 'vue';
import { useStore } from 'vuex';

const VUEX_MODULE = 'invoices/invoices';

export default {
	setup() {
		const store = useStore();

		store.dispatch(`${VUEX_MODULE}/fetch`);

		return {
			invoices: computed(() => store.state.invoices.invoices.invoices),
		};
	}
};
</script>