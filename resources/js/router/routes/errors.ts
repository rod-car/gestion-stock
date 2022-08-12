import NotFound from '../../pages/errors/NotFound.vue';
import Forbidden from '../../pages/errors/Forbidden.vue';

const routes = [
    {
        path: '/404',
        name: 'PageNotExist',
        component: NotFound,
        meta: {
            requiresAuth: false,
            gate: null,
        }
    },
    {
        path: '/403',
        name: 'Forbidden',
        component: Forbidden,
        meta: {
            requiresAuth: false,
            gate: null,
        }
    },
    {
        path: "/:catchAll(.*)", // Unrecognized path automatically matches 404
        name: "NotFound",
        component: NotFound,
        meta: {
            requiresAuth: false,
            gate: null,
        }
    },
];

export default routes.map(route => {
    return { ...route }
});
