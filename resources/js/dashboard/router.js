import { createWebHashHistory, createRouter } from 'vue-router';

const router = createRouter({
	history: createWebHashHistory('/dashboard'),
	
	routes: [
		{
			path: '/',
			redirect: '/posts'
		},

		...require('d-modules/posts/_routes.js').default,
	],
});

export default router;