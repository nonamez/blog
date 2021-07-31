import { route } from 'helpers';

function initialState() {
	return {
		clients: []
	};
}

const state = initialState();

const mutations = {
	setClients(state, clients) {
		state.clients = clients;
	}
};

const actions = {
	fetch({commit}) {
		commit('setIsLoading', 'invoices-clients', {root: true});

		let url = route('dashboard.invoices.clients.index');

		return new Promise((resolve) => {
			axios.get(url).then(response => {
				commit('setClients', response.data.data);

				resolve(response.data.data);
			}).catch(() => {
				commit('setClients', []);

				resolve([]);
			}).finally(() => {
				commit('setIsLoading', false, {root: true});
			});
		});
	},

	remove({dispatch}, id) {
		let url = route('dashboard.invoices.clients.delete', id);

		axios.delete(url).then(() => {
			dispatch('fetch');
		});
	}
};

export default {
	namespaced: true,
	state,
	mutations,
	actions
};