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
			<tr v-for="(item, index) in items" v-bind:key="item.id">
				<td><enterable @returnable="editItemDescription({index: index, value: $event })" :default="item.description"></enterable></td>
				<td><enterable @returnable="editItemQuantity({index: index, value: $event })" :default="item.quantity"></enterable></td>
				<td><enterable @returnable="editItemPrice({index: index, value: $event })" :default="item.price"></enterable></td>
				<td>{{ getTotal(item) }}</td>
			</tr>
			<tr>
				<td colspan="4" class="text-center">
					<button class="btn btn-success btn-sm" @click="addNewItem()">Add Item</button>
				</td>
			</tr>
		</tbody>
	</table>
</template>
<script>
import { createNamespacedHelpers } from 'vuex-composition-helpers';

const VUEX_MODULE = 'invoices/invoice';

const { useState, useMutations } = createNamespacedHelpers(VUEX_MODULE);

export default {
	setup() {
		return {		
			...useState(['items']),
			...useMutations(['addNewItem', 'editItemDescription', 'editItemQuantity', 'editItemPrice']),

			getTotal(item) {
				if (item.total) {
					return item.total;
				}

				if (item.quantity && item.price) {
					return (item.quantity * item.price).toFixed(2);
				}

				return 0;
			}
		};
	}
};
</script>