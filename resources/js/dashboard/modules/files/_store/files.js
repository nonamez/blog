import { route, getURLParameterByName } from 'helpers';

function initialState() {
	return {
		files: []
	};
}

const state = initialState();

const getters = {};

const mutations = {
	setFiles(state, files) {
		state.files = files;
	},

	// removeFile(state, file) {
	// 	state.files.splice(state.files.findIndex(f => f.id == file.id), 1);
	// }
};

const actions = {
	remove({dispatch}, file) {
		axios.post(file.routes.delete).then(() => {
			dispatch('fetch');
		});
	},

	fetch({commit}, url = null) {
		if (url == null) {
			url = route('dashboard.files.index');

			let page = getURLParameterByName('page', window.location.href);

			if (page > 0) {
				url = `${url}?page=${page}`;
			}
		}

		axios.get(url).then(response => {
			commit('setFiles', response.data.data);
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