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

export default {
	install(app) {
		router.install(app);

		router.beforeEach((to, from, next) => {
			if (to.meta.ability) {
				if (app.config.globalProperties.$auth.abilities.includes(to.meta.ability)) {
					return next();
				} else {
					console.error(`The ability "${to.meta.ability}" not given for user`);
				}
			} else {
				return next();
			}
		});
	},
};