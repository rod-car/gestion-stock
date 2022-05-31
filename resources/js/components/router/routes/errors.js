import NotFound from '../../pages/errors/NotFound.vue';

const routes = [
    {
        path: '/404',
        name: 'PageNotExist',
        component: NotFound
    },
    {
        path: "/:catchAll(.*)", // Unrecognized path automatically matches 404
        redirect: '/404',
    },
];

export default routes;
