export default [
	{
		path: '/invoices/clients',
		name: 'invoices.clients.index',
		component: require('modules/invoices/_components/clients/index.vue').default,
		meta: {
			ability: 'invoices-management'
		}
	}
];