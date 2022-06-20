import NotFound from '../../pages/errors/NotFound.vue';
import Forbidden from '../../pages/errors/Forbidden.vue';

const routes = [
    {
        path: '/404',
        name: 'PageNotExist',
        component: NotFound
    },
    {
        path: '/403',
        name: 'Forbidden',
        component: Forbidden
    },
    {
        path: "/:catchAll(.*)", // Unrecognized path automatically matches 404
        redirect: '/404',
    },
];

export default routes;
