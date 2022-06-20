import { createRouter, createWebHistory } from 'vue-router';

import Login from '../pages/Login.vue';
import Dashboard from '../pages/Dashboard.vue';

import privateRoutes from './routes/private'; // Route special pour les utilisateurs connecté
import errorsRoutes from './routes/errors'; // Route special pour les utilisateurs connecté
import store from '../store/index';

import pointVente from './routes/point-vente'; // Route qui gère tous les point de vente
import entrepot from './routes/entrepot'; // Routes qui gere tous les entrepots

const routes = [
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: { requiresGuest: true },
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta: { requiresAuth: true }
    },
]
    .concat(privateRoutes)
    .concat(errorsRoutes)
    .concat(pointVente)
    .concat(entrepot)

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    if (store.state.user.data.id === undefined && to.path !== "/login") {
        getUser()
    }

    if (to.meta.requiresAuth && !store.state.user.token) {
        next({ name: 'login' });
    } else {
        if (to.meta.requiresGuest && store.state.user.token) {
            next({ name: 'dashboard' });
        }
        next();
    }
});

/**
 * Mettre l'utilisateur connecté dans le store
 *
 * @return  {void}
 */
const getUser = async () => {
    await store.dispatch('getUser');
}

export default router;
