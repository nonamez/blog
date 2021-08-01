export default [
	{
		path: '/invoices/clients',
		name: 'invoices.clients.index',
		component: () => import('modules/invoices/_components/clients/index.vue'),
		meta: {
			ability: 'invoices-management'
		}
	},
	{
		path: '/invoices',
		name: 'invoices.index',
		component: () => import('modules/invoices/_components/invoices/index.vue'),
		meta: {
			ability: 'invoices-management'
		}
	},
	{
		path: '/invoices/:id',
		name: 'invoices.invoice',
		component: () => import('modules/invoices/_components/invoices/invoice/index.vue'),
		meta: {
			ability: 'invoices-management'
		}
	}
];