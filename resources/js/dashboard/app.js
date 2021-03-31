require('./bootstrap');

import { createApp, reactive, h } from 'vue';

import Router from './router';
// import Store from './store/store';

import Dashboard from './layouts/Dashboard.vue';

axios.get('/auth').then(response => {
	const app = createApp({
		render: () => h(Dashboard)
	});

	app.config.globalProperties.$auth = reactive(response.data.data);

	// app.use(Store);
	app.use(Router);
	
	app.mount('#dashboard');
}).catch((err) => {
	console.error(err);

	document.write('App not mounted');
});

// Load all components
// const files = require.context('components', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));