import Vue from 'vue';
import Vuex from 'vuex';

import post from './modules/post';
import posts from './modules/posts';

Vue.use(Vuex);

export default new Vuex.Store({
	modules: {
		post,
		posts
	},

	state: {
		page: null
	}
});