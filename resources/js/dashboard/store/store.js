import Vue from 'vue';
import Vuex from 'vuex';

import post from './modules/post';
import files from './modules/files';
import posts from './modules/posts';

Vue.use(Vuex);

export default new Vuex.Store({
	modules: {
		post,
		files,
		posts
	},

	state: {
		page: null
	}
});