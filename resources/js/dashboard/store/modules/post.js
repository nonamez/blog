import { route } from 'helpers';

function initialState() {
	return {
		id: null,
		parent_post_id: null,
		locale: null,
		status: null,
		date: null,
		markdown: null,
		slug: null,
		title: null,
		content: null,
		meta_description: null,
		meta_keywords: null,
		created_at: null,
		updated_at: null,
		routes: {
			preview: null,
			save: null,
			find: null,
		},
		tags: [],
		files: [],
	};
}

const state = initialState();

// const getters = {};

const mutations = {
	setPost(state, data) {
		for (let key in data) {
			if (key in state) {
				state[key] = data[key];
			}
		}
	},
	
	setTitle(state, title) {
		state.title = title;
	},

	setContent(state, content) {
		state.content = content;
	},

	setMetaKeywords(state, keywords) {
		state.meta_keywords = keywords;
	},

	setMetaDescription(state, description) {
		state.meta_description = description;
	},

	addTag(state, tag) {
		state.tags.push(tag);
	},

	removeTag(state, index) {
		state.tags.splice(index, 1);
	},

	reset(state) {
		const s = initialState();

		Object.keys(s).forEach(key => {
			state[key] = s[key];
		});
	}
};

const actions = {
	find({commit}, id) {
		axios.get(route('dashboard.posts.find', id)).then(response => {
			commit('setPost', response.data.post);
		});
	}
};

export default {
	namespaced: true,
	state,
	// getters,
	mutations,
	actions
};