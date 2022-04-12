export default [
	{
		path: '/posts',
		name: 'posts.index',
		component: () => import('modules/posts/_components/index.vue'),
	},

	{
		path: '/posts/post/:id?',
		name: 'posts.post',
		component: () => import('modules/posts/_components/post/index.vue'),
	},
];