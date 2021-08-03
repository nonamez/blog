<template>
	<modal ref="modal" title="Client Info" @close="onClose()">
		<template v-slot:body>
			<enterable-floating title="Name" @returnable="setName($event)" :default="name" class="mb-4"></enterable-floating>

			<enterable-floating title="Address" @returnable="setAddress($event)" :default="address" class="mb-3"></enterable-floating>
			<enterable-floating title="City" class="mb-3" @returnable="setCity($event)" :default="city"></enterable-floating>
			<enterable-floating title="Country" class="mb-4" @returnable="setCountry($event)" :default="country"></enterable-floating>

			<enterable-floating title="Company Code" class="mb-3" @returnable="setCompanyCode($event)" :default="company_code"></enterable-floating>
			<enterable-floating title="VAT Code" class="mb-4" @returnable="setVatCode($event)" :default="vat_code"></enterable-floating>

			<enterable-floating title="Email" class="mb-3" @returnable="setEmail($event)" :default="email"></enterable-floating>
			<enterable-floating title="Phone" class="mb-4" @returnable="setPhone($event)" :default="phone"></enterable-floating>

			<enterable-floating title="URL" @returnable="setUrl($event)" :default="url"></enterable-floating>
		</template>
		<template v-slot:footer>
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary" @click="save()">Save changes</button>
		</template>
	</modal>
</template>
<script>
import { ref } from 'vue';
import { useStore } from 'vuex';

import { createNamespacedHelpers } from 'vuex-composition-helpers';

const VUEX_MODULE = 'invoices/client';

const { useState, useMutations, useActions } = createNamespacedHelpers(VUEX_MODULE);

export default {

	setup() {
		const store = useStore();
		const modal = ref(null);

		return {
			...useState(['name', 'address', 'city', 'country', 'company_code', 'vat_code', 'email', 'phone', 'url']),
			...useMutations(['setName', 'setAddress', 'setCity', 'setCountry', 'setCompanyCode', 'setVatCode', 'setEmail', 'setPhone', 'setUrl']),
			...useActions(['save']),

			modal,

			show: (id) => {
				if (id) {
					store.dispatch(`${VUEX_MODULE}/find`, id);
				}

				modal.value?.show();
			},

			onClose() {
				store.commit('invoices/client/_reset');
				store.dispatch('invoices/clients/fetch');
			}
		};
	},
};
</script>
