import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

const router = new VueRouter({
    base: '/',
    routes: [
        {
            path: '/',
            redirect: '/orders'
        },
        
        ...require('modules/orders/_routes.js').default,
        ...require('modules/tasks/_routes.js').default,
        ...require('modules/users/_routes.js').default,
    ],
    linkActiveClass: 'active',
    linkExactActiveClass: 'active'
});

router.beforeEach((to, from, next) => {
    if (to.meta.ability && router.app.$auth.abilities.includes(to.meta.ability)) {
        return next();
    }

    console.error(`The ability ${to.meta.ability} not given for user`);
});

export default router;