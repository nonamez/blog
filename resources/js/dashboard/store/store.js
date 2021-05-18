import { createStore, createLogger } from 'vuex';

const store = createStore({
	plugins: [createLogger()],
	
	state () {
		return {
			is_loading: false,
			is_saving:  false,
		};
	},

	mutations: {
		setIsLoading(state, payload) {
			state.is_loading = payload;
		},

		setIsSaving(state, payload) {
			state.is_saving = payload ? true : false;
		}
	}
});

// Autolod some time...
// let m = require.context('modules', true, /\.\/[a-zA-Z0-9]+\/_store\/index\.js/);

store.registerModule('posts', require('modules/posts/_store/posts').default);
store.registerModule(['posts', 'post'], require('modules/posts/_store/post').default);
store.registerModule('files', require('modules/files/_store/files').default);

export default store;