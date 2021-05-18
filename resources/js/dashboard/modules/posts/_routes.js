export default [
	{
		path: '/posts',
		name: 'posts.index',
		component: require('modules/posts/_components/index.vue').default,
	},

	{
		path: '/posts/post/:id?',
		name: 'posts.post',
		component: require('modules/posts/_components/post/index.vue').default,
	},
];