import { route } from 'helpers';

function initialState() {
	return {
		posts: []
	};
}

const state = initialState();

const getters = {
	
};

const mutations = {
	setPosts(state, posts) {
		state.posts = posts;
	}
};

const actions = {
	fetch({commit}) {
		commit('setIsLoading', 'posts', {root: true});

		let url = route('dashboard.posts.index');

		return new Promise((resolve) => {
			axios.get(url).then(response => {
				commit('setPosts', response.data.data);

				resolve(response.data.data);
			}).catch(() => {
				commit('setPosts', []);

				resolve([]);
			}).finally(() => {
				commit('setIsLoading', false, {root: true});
			});
		});
	},

	remove({dispatch}, {id, all}) {
		let url = route('dashboard.posts.delete', id, all ? 'all' : '');

		axios.post(url).then(() => {
			dispatch('fetch');
		});
	}
};

export default {
	namespaced: true,
	state,
	getters,
	mutations,
	actions
};