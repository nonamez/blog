<template>
	<div class="container">
		<div class="row mb-3">
			<div class="col">
				<div class="d-flex align-items-center h-100">
					<client-select class="w-100"></client-select>
				</div>
			</div>
			<div class="col">
				<div class="row mb-3">
					<div class="col">
						<enterable-floating title="Invoice Date"></enterable-floating>
					</div>
					<div class="col">
						<enterable-floating title="Due Date"></enterable-floating>
					</div>
				</div>
				<div class="row">
					<div class="col-6">
						<enterable-floating title="Invoice Number"></enterable-floating>
					</div>
					<div class="col-6">
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
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Items</th>
						<th>Quantity</th>
						<th>Price</th>
						<th>Amount</th>
					</tr>
				</thead>
			</table>
		</div>
		<div class="row border border-danger">
			<div class="col">Notes</div>
			<div class="col">
				<table class="table table-clear">
					<tbody>
						<tr>
							<td class="left">
								<strong>Subtotal</strong>
							</td>
							<td class="right">$8.497,00</td>
						</tr>
						<tr>
							<td class="left">
								<strong>Discount (20%)</strong>
							</td>
							<td class="right">$1,699,40</td>
						</tr>
						<tr>
							<td class="left">
								<strong>VAT (10%)</strong>
							</td>
							<td class="right">$679,76</td>
						</tr>
						<tr>
							<td class="left">
								<strong>Total</strong>
							</td>
							<td class="right">
								<strong>$7.477,36</strong>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</template>
<script>
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';

import { createNamespacedHelpers } from 'vuex-composition-helpers';

const VUEX_MODULE = 'invoices/invoices/invoice';

const { useState, useMutations } = createNamespacedHelpers(VUEX_MODULE);

export default {
	components: {
		'client-select': require('./partials/client-select.vue').default
	},

	setup() {
		const store = useStore();
		const route = useRoute();

		if (route.params.id) {
			store.dispatch(`${VUEX_MODULE}/find`, route.params.id);
		}
		
		return {
			...useState(['items', 'total']),
			...useMutations(['setTitle', 'setContent', 'setMetaKeywords', 'setMetaDescription', 'setLocale', 'setStatus', 'setParentId', 'setSlug'])
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