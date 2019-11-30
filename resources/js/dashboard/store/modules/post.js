import { route, toMysqlFormat } from 'helpers';

function initialState() {
	return {
		id: null,
		parent_id: null,
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
	};
}

const state = initialState();

const getters = {
	data: (state, getters, rootState, rootGetters) => {
		return {
			parent_id: state.parent_id,
			locale: state.locale,
			status: state.status,
			date: state.date,
			markdown: state.markdown,
			slug: state.slug,
			title: state.title,
			content: state.content,
			meta_description: state.meta_description,
			meta_keywords: state.meta_keywords,
			tags: state.tags,
			files: rootGetters['files/files_id']
		};
	}
};

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

	setDate(state, date) {
		state.date = toMysqlFormat(date);
	},

	setLocale(state, locale) {
		state.locale = locale;
	},

	setStatus(state, status) {
		state.status = status;
	},

	setParentId(state, id) {
		state.parent_id = parseInt(id);
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
			commit('files/setFiles', response.data.post.files, { root: true });
		});
	},

	save({state, getters}) {
		let url = state.routes.save ? state.routes.save : route('dashboard.posts.save');

		axios.post(url, getters.data).then(response => {
			console.log(response);
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