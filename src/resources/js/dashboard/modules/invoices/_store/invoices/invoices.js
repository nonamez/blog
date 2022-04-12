import { route } from 'helpers';

function initialState() {
	return {
		invoices: []
	};
}

const state = initialState();

const mutations = {
	setInvoices(state, invoices) {
		state.invoices = invoices;
	}
};

const actions = {
	fetch({commit}) {
		commit('setIsLoading', 'invoices', {root: true});

		let url = route('dashboard.invoices.index');

		return new Promise((resolve) => {
			axios.get(url).then(response => {
				commit('setInvoices', response.data.data);

				resolve(response.data.data);
			}).catch(() => {
				commit('setInvoices', []);

				resolve([]);
			}).finally(() => {
				commit('setIsLoading', false, {root: true});
			});
		});
	}
};

export default {
	namespaced: true,
	state,
	mutations,
	actions
};