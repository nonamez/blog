import { createWebHashHistory, createRouter } from 'vue-router';

const router = createRouter({
	history: createWebHashHistory('/dashboard'),
	
	routes: [
		{
			path: '/',
			redirect: '/posts'
		},

		...require('modules/posts/_routes.js').default,
		...require('modules/files/_routes.js').default,
		...require('modules/invoices/_routes.js').default,
	],
});

export default router;