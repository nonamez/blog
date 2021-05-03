import { route, toMysqlFormat } from 'helpers';
import _MIXINS from 'store/modules/_mixins';

function initialState() {
	return {
		id: null,
		parent_id: null,
		locale: 'en',
		status: 'draft',
		date: toMysqlFormat(new Date),
		markdown: 0,
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
		tags: []
	};
}

const state = initialState();

const getters = {
	data: (state, getters, rootState, rootGetters) => {
		return {
			date: state.date,
			locale: state.locale,
			status: state.status,
			parent_id: state.parent_id,

			markdown: state.markdown,

			title: state.title,
			content: state.content,
			slug: state.slug ? state.slug : state.title,

			meta_keywords: state.meta_keywords,
			meta_description: state.meta_description,

			tags: state.tags,

			files: rootGetters['files/files_id']
		};
	},

	preview_url: state => {
		if (state.routes && state.routes.preview) {
			return state.routes.preview;
		}

		return false;
	}
};

const mutations = {
	..._MIXINS.mutations,
	
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

	setSlug(state, slug) {
		state.slug = slug;
	},

	setMarkdown(state, markdown) {
		state.markdown = markdown;
	}
};

const actions = {
	find({commit}, id) {
		axios.get(route('dashboard.posts.find', id)).then(response => {
			commit('_set', response.data.post);
			commit('files/setFiles', response.data.post.files, { root: true });
		});
	},

	save({state, getters, commit}) {
		let url = state.routes.save ? state.routes.save : route('dashboard.posts.save');

		return new Promise((resolve) => {
			axios.post(url, getters.data).then(response => {
				commit('_set', response.data.post);
				commit('files/setFiles', response.data.post.files, { root: true });

				resolve();
			});
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