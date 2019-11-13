require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';

import store from './store/store';

Vue.use(VueRouter);

const router = new VueRouter({
	// mode: 'history',
	base: '/dashboard',
	routes: [
		{
			path: '/posts/index',
			name: 'posts.index',
			component: require('./components/posts/index').default
		},
		{
			path: '/posts/show/:post_id?',
			name: 'posts.show',
			component: require('./components/posts/show').default
		},

		{
			path: '/',
			redirect: '/posts/index'
		}
	]
});

Vue.component('header-component', require('./components/header.vue').default);

Vue.component('pagination', require('./components/_partials/pagination.vue').default);
Vue.component('form-group', require('./components/_partials/form-group.vue').default);

new Vue({
	store,
	router
}).$mount('#app');
