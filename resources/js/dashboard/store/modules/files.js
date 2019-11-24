import { route } from 'helpers';

function initialState() {
	return {
		files: []
	};
}

const state = initialState();

const getters = {
	
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

	resetFiles(state) {
		const s = initialState();

		Object.keys(s).forEach(key => {
			state[key] = s[key];
		});
	},


};

const actions = {
	removeFile({commit}, file) {
		axios.post(file.routes.delete).then(() => {
			commit('removeFile', file);
		});
	},

	loadFiles() {

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