<template>
	<div class="container">
		<div class="row mb-3">
			<div class="col mb-2">
				<div class="d-flex align-items-center h-100">
					<client-select class="w-100"></client-select>
				</div>
			</div>
			<div class="col mb-2">
				<div class="row mb-md-3">
					<div class="col mb-2 mb-md-0">
						<enterable-floating title="Invoice Date" type="date" :default="invoiced_at" @returnable="setInvoicedAtDate($event)"></enterable-floating>						
					</div>
					<div class="col mb-2 mb-md-0">
						<enterable-floating title="Due Date" type="date" :default="due_until" @returnable="setDueUntilDate($event)"></enterable-floating>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-sm-6 mb-2 mb-md-0">
						<div class="d-flex align-items-center h-100 border border-grey rounded p-2">
							<strong class="me-5">Invoice Number:</strong>
							<span>{{ invoice_prefix }}-{{ invoice_number }}</span>
						</div>
					</div>
					<div class="col-12 col-sm-6">
						<div class="form-floating">
							<select class="form-select" id="floatingSelect" aria-label="Floating label select example">
								<option selected>Open this select menu</option>
								<option value="1">One</option>
								<option value="2">Two</option>
								<option value="3">Three</option>
							</select>
							<label for="floatingSelect">Invoice Template</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row mb-3">
			<items></items>
		</div>
		<div class="row mb-3">
			<div class="col-12 col-sm-6">
				<enterable-big @returnable="setNotes($event)" :default="notes" title="Notes"></enterable-big>
			</div>
			<div class="col-12 col-sm-6">
				<table class="table table-clear">
					<tbody>
						<tr>
							<td class="left">
								<strong>Subtotal</strong>
							</td>
							<td class="right">€ {{ subTotal }}</td>
						</tr>
						<tr>
							<td class="left">
								<strong>Discount (20%)</strong>
							</td>
							<td class="right">€ 1,699,40</td>
						</tr>
						<tr>
							<td class="left">
								<strong>VAT (10%)</strong>
							</td>
							<td class="right">€ 679,76</td>
						</tr>
						<tr>
							<td class="left">
								<strong>Total</strong>
							</td>
							<td class="right">
								<strong>€ {{ total }}</strong>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="text-center">
			<button class="btn btn-success" @click="save()">Save</button>
		</div>
	</div>
</template>
<script>
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';

import { createNamespacedHelpers } from 'vuex-composition-helpers';

const VUEX_MODULE = 'invoices/invoice';

const { useState, useGetters, useMutations, useActions } = createNamespacedHelpers(VUEX_MODULE);

export default {
	components: {
		'client-select': require('./partials/client-select.vue').default,
		items: require('./partials/items.vue').default,
	},

	setup() {
		const store = useStore();
		const route = useRoute();

		if (route.params.id) {
			store.dispatch(`${VUEX_MODULE}/find`, route.params.id);
		} else {
			// 
		}
		
		return {
			...useGetters(['subTotal', 'total']),
			...useState(['items', 'invoiced_at', 'due_until', 'invoice_number', 'invoice_prefix', 'notes']),
			...useMutations(['setInvoicedAtDate', 'setDueUntilDate', 'setNotes']),
			...useActions(['save'])
		};
	},

	beforeRouteUpdate() {
		this.$store.commit(`${VUEX_MODULE}/_reset`);
	},

	beforeRouteLeave() {
		this.$store.commit(`${VUEX_MODULE}/_reset`);
	}
};
</script>