import { route } from 'helpers';
import mixins from 'store/modules/_mixins';
import pick from 'lodash/pick';

const _MIXINS = mixins(initialState);

function initialState() {
	let date_due = new Date();
	
	date_due.setDate(date_due.getDate() + 10); 
	
	return {
		id: null,
		
		client_id: null,

		invoiced_at: (new Date().toISOString().slice(0, 19).replace('T', ' ').split(' ').shift()),
		due_until: (date_due.toISOString().slice(0, 19).replace('T', ' ').split(' ').shift()),

		items: [],

		invoice_number: 0,
		invoice_prefix: 'INV',
	};
}

const state = initialState();

const getters = {
	data: (state) => {
		let data = pick(state, ['client_id', 'invoiced_at', 'due_until']);

		data.items = state.items.filter(x => {
			return x.description && x.quantity && x.price;
		});

		return data;
	},

	subTotal: (state) => {
		return state.items.reduce((a, x) => a + (x.quantity * x.price), 0).toFixed(2);
	},

	total: (state, getters) => {
		return getters.subTotal;
	},


};

const mutations = {
	..._MIXINS.mutations,

	setClientId(state, client_id) {
		state.client_id = client_id;
	},
	
	setInvoicedAtDate(state, date) {
		state.invoiced_at = date;
	},

	setDueUntilDate(state, date) {
		state.due_until = date;
	},
	
	addNewItem(state) {
		state.items.push({
			description: null,
			quantity: null,
			price: null,
		});
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

	save({getters, commit}) {
		commit('setIsLoading', 'invoices', {root: true});

		let url = state.routes ? state.routes.save : route('dashboard.invoices.save');

		console.log(getters.data, url);

		// return new Promise((resolve) => {
		// 	axios.post(url, getters.data).then(() => {
		// 		resolve();
		// 	}).finally(() => {
		// 		commit('setIsLoading', false, {root: true});
		// 	});
		// });
	}
};

export default {
	namespaced: true,
	state,
	mutations,
	actions,
	getters
};