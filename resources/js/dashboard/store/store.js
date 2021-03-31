import { createStore } from 'vuex';

export const store = createStore({
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
