require('./bootstrap');

import { createApp, reactive } from 'vue';

import Router from './router';
import Store from './store/store';

import Dashboard from './layouts/dashboard.vue';

axios.get('/auth').then(response => {
	const app = createApp(Dashboard);

	app.config.globalProperties.$auth = reactive(response.data.data);

	// Loading all global components
	const files = require.context('./components', true, /\.vue$/i);

	files.keys().reduce(function(map, path) {
		app.component(path.split('/').pop().split('.')[0], files(path).default);
	}, {});

	app.use(Store);
	app.use(Router, app);
	
	app.mount('#dashboard');
}).catch((err) => {
	console.error(err);

	document.write('App not mounted');
});