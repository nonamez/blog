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
	},

	reset(state) {
		const s = initialState();

		Object.keys(s).forEach(key => {
			state[key] = s[key];
		});
	}
};

const actions = {
	load({commit}, route) {
		axios.get(route).then(response => {
			commit('setPosts', response.data.posts.data);
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