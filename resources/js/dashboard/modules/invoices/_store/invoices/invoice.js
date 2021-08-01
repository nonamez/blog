import { route } from 'helpers';
import mixins from 'store/modules/_mixins';
// import pick from 'lodash/pick';

const _MIXINS = mixins(initialState);

function initialState() {
	return {
		id: null,
		
		client_id: null,

		items: null,
	};
}

const state = initialState();

const mutations = {
	..._MIXINS.mutations,

	setClientId(state, client_id) {
		state.client_id = client_id;
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