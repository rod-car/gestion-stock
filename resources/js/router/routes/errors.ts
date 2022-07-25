const NotFound = require('../../pages/errors/NotFound.vue');
const Forbidden = require('../../pages/errors/Forbidden.vue');

const routes = [
    {
        path: '/404',
        name: 'PageNotExist',
        component: NotFound,
        meta: {
            requiresAuth: false,
            gate: '',
        }
    },
    {
        path: '/403',
        name: 'Forbidden',
        component: Forbidden,
        meta: {
            requiresAuth: false,
            gate: '',
        }
    },
    {
        path: "/:catchAll(.*)", // Unrecognized path automatically matches 404
        name: "NotFound",
        component: NotFound,
        meta: {
            requiresAuth: false,
            gate: '',
        }
    },
];

export default routes.map(route => {
    return { ...route }
});
