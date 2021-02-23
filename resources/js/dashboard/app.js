require('./bootstrap');

import { createApp } from 'vue';

import Header from './partials/header.vue';

const App = {
	components: {
		'header-component': Header
	}
};

createApp(App).mount('#dashboard');

// import store from './store/store';
// import router from './router';

// import Layout from './layout.vue';

// Load all components
// const files = require.context('components', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// axios.get('/auth').then(response => {
// 	Vue.prototype.$auth = Vue.observable(response.data.data);

// 	new Vue({
// 		// store,
// 		// router,

// 		render: h => h(App),
// 	}).$mount('#app');
// }).catch(() => {
// 	document.write('Auth not found');
// });