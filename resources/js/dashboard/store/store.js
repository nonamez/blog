import { createStore, createLogger } from 'vuex';

// Load all modules
const files = require.context('./modules', true, /\.js$/i);

const modules = files.keys().slice(1).reduce(function(map, path) {
	let key = path.split('/').pop().split('.')[0];

	map[key] = files(path).default;

	return map;
}, {});

const store = createStore({
	plugins: [createLogger()],
	
	modules,

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

export default store;