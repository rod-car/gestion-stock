import { createRouter, createWebHistory } from 'vue-router';
import Home from '../pages/Home.vue';
import Login from '../pages/Login.vue';
import Dashboard from '../pages/Dashboard.vue';
import NouveauProduitsFinis from '../pages/articles/produits-finis/NouveauProduitsFinis.vue';
import ListeProduitsFinis from '../pages/articles/produits-finis/ListeProduitsFinis.vue'

import NouveauEntrepot from '../pages/entrepot/NouveauEntrepot.vue';
import ListeEntrepot from '../pages/entrepot/ListeEntrepot.vue';

import privateRoutes from './routes/private'; // Route special pour les utilisateurs connecté
import errorsRoutes from './routes/errors'; // Route special pour les utilisateurs connecté
import store from '../store/index';

import pointVente from './routes/point-vente';

const routes = [
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: { requiresGuest: true },
    },
    {
        path: '/',
        name: 'home',
        component: Home,
        meta: { requiresAuth: true }
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta: { requiresAuth: true }
    },
    {
        path: '/article/nouveau',
        name: 'article.article.nouveau',
        component: NouveauProduitsFinis
    },
    {
        path: '/article/liste',
        name: 'article.article.liste',
        component: ListeProduitsFinis
    },
    {
        path: '/entrepot/nouveau',
        name: 'depot.entrepot.nouveau',
        component: NouveauEntrepot,
        meta: {
            requiresAuth: true,
            gate: 'add_entrepot',
        }
    },
    {
        path: '/entrepot/liste',
        name: 'depot.entrepot.liste',
        component: ListeEntrepot,
        meta: {
            requiresAuth: true,
            gate: 'view_entrepot',
        }
    },
]
    .concat(privateRoutes)
    .concat(errorsRoutes)
    .concat(pointVente)

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