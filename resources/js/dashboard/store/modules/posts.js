import { route, getURLParameterByName } from 'helpers';

import pagination from './_pagination';

function initialState() {
	return {
		...pagination.state,

		posts: []
	};
}

const state = initialState();

const getters = {
	...pagination.getters
};

const mutations = {
	setPosts(state, posts) {
		state.posts = posts;
	},

	setPagination(state, pagination) {
		delete pagination.data;

		state.pagination = pagination;
	},

	remove(state, post_id) {
		let index = state.posts.findIndex(x => x.id == post_id);

		if (index !== -1) {
			state.posts.splice(index, 1);
		}
	},

	removeAll(state, post_id) {
		let post = state.posts.find(x => x.id == post_id);

		if (post) {	
			let parent_id = post.parent_post_id;

			let index;

			do {
				index = state.posts.findIndex(x => x.parent_post_id == parent_id);

				if (index !== -1) {
					state.posts.splice(index, 1);
				}
			} while (index !== -1);
		}
	}
};

const actions = {
	load({commit}, url = null) {
		if (url == null) {
			url = route('dashboard.posts.index');

			let page = getURLParameterByName('page', window.location.href);

			if (page > 0) {
				url = `${url}?page=${page}`;
			}
		}

		axios.get(url).then(response => {
			commit('setPosts', response.data.posts.data);
			commit('setPagination', response.data.posts);
		});
	},

	remove({dispatch}, {id, all}) {
		let url = route('dashboard.posts.delete', id, all ? 'all' : '');

		axios.post(url).then(() => {
			dispatch('load');
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