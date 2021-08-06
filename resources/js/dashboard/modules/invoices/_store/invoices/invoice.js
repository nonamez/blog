import { route } from 'helpers';
import mixins from 'store/modules/_mixins';
// import pick from 'lodash/pick';

const _MIXINS = mixins(initialState);

function initialState() {
	let date_due = new Date();
	
	date_due.setDate(date_due.getDate() + 10); 
	
	return {
		id: null,
		
		client_id: null,

		date_invoice: (new Date().toISOString().slice(0, 19).replace('T', ' ').split(' ').shift()),
		date_due: (date_due.toISOString().slice(0, 19).replace('T', ' ').split(' ').shift()),

		items: [],
	};
}

const state = initialState();

const mutations = {
	..._MIXINS.mutations,

	setClientId(state, client_id) {
		state.client_id = client_id;
	},
	
	setInvoiceDate(state, date) {
		state.date = date;
	},
	
	addNewItem(state) {
		state.items.push({});
	},

	editItemDescription(state, {index, value}) {
		state.items[index].description = value;
	},

	editItemQuantity(state, {index, value}) {
		state.items[index].quantity = parseInt(value);
	},

	editItemPrice(state, {index, value}) {
		state.items[index].price = parseFloat(value);
	}
};

const actions = {
	find({commit}, invoice_id) {
		commit('setIsLoading', 'invoices', {root: true});

		let url = route('dashboard.invoices.find', invoice_id);

		return new Promise((resolve) => {
			axios.get(url).then(response => {
				commit('_set', response.data.data);

				resolve(response.data.data);
			}).catch(() => {
				commit('_reset');

				resolve([]);
			}).finally(() => {
				commit('setIsLoading', false, {root: true});
			});
		});
	},
};

export default {
	namespaced: true,
	state,
	mutations,
	actions
};