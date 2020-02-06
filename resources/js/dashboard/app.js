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
			path: '/posts',
			name: 'posts.index',
			component: require('dashboard-components/posts/index').default
		},
		{
			path: '/posts/show/:post_id?',
			name: 'posts.show',
			component: require('dashboard-components/posts/show').default
		},

		{
			path: '/files/',
			name: 'files.index',
			component: require('dashboard-components/files/index').default
		},

		{
			path: '/',
			redirect: '/posts'
		}
	]
});

Vue.component('header-component', require('dashboard-components/header.vue').default);

Vue.component('card', require('dashboard-components/partials/card.vue').default);

Vue.component('enterable', require('dashboard-components/partials/inputs/enterable.vue').default);
Vue.component('selectable', require('dashboard-components/partials/inputs/selectable.vue').default);

Vue.component('pagination', require('dashboard-components/partials/pagination.vue').default);
Vue.component('form-group', require('dashboard-components/partials/form-group.vue').default);

new Vue({
	store,
	router
}).$mount('#app');
