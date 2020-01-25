import { route, getURLParameterByName } from 'helpers';

function initialState() {
	return {
		files: [],

		pagination: {
			prev_page_url: false,
			next_page_url: false,
			current_page: 1,
			last_page: 1
		}
	};
}

const state = initialState();

const getters = {
	files_id: state => state.files.map(f => f.id),

	pagination_simple: state => {
		return (({
			prev_page_url,
			next_page_url,
			current_page,
			last_page
		}) => ({
			prev_page_url,
			next_page_url,
			current_page,
			last_page
		}))(state.pagination);
	}
};

const mutations = {
	setFiles(state, files) {
		state.files = files;
	},

	addFile(state, file, start = false) {
		if (start) {
			state.files.push(file);
		} else {
			state.files.unshift(file);
		}
	},

	removeFile(state, file) {
		state.files.splice(state.files.findIndex(f => f.id == file.id), 1);
	},

	reset(state) {
		const s = initialState();

		Object.keys(s).forEach(key => {
			state[key] = s[key];
		});
	},

	setPagination(state, pagination) {
		delete pagination.data;

		state.pagination = pagination;
	}
};

const actions = {
	remove({commit}, file) {
		axios.post(file.routes.delete).then(() => {
			commit('removeFile', file);
		});
	},

	load({commit}, url = null) {
		if (url == null) {
			url = route('dashboard.files.index');

			let page = getURLParameterByName('page', window.location.href);

			if (page > 0) {
				url = `${url}?page=${page}`;
			}
		}

		axios.get(url).then(response => {
			commit('setFiles', response.data.files.data);
			commit('setPagination', response.data.files);
		});
	},

	uploadFile({commit}, file,  watermark = false) {
		return new Promise(resolve => {
			watermark = watermark ? 1 : 0;

			let form_data = new FormData();

			form_data.append('file', file);
			form_data.append('watermark', watermark);

			window.axios.post(route('dashboard.files.store'), form_data, {
				headers: {
					'Content-Type': 'multipart/form-data'
				}
			}).then(response => {
				commit('addFile', response.data.file, true);
				
				resolve(true);
			}).catch(() => {
				resolve(false);
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