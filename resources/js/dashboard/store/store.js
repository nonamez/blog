import { createStore, createLogger } from 'vuex';

// Load all modules
// const files = require.context('./modules', true, /\.js$/i);

// const modules = files.keys().slice(1).reduce(function(map, path) {
// 	let key = path.split('/').pop().split('.')[0];

// 	map[key] = files(path).default;

// 	return map;
// }, {});

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

export default store;