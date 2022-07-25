/**
 * FIchier qui gère tous les routes coté client de l'application
 */

import { createRouter, createWebHistory } from 'vue-router';

import Login from '../pages/Login.vue';
const Dashboard = require('../pages/Dashboard.vue');

import privateRoutes from './routes/private'; // Route special pour les utilisateurs connecté
import errorsRoutes from './routes/errors'; // Route special pour les utilisateurs connecté
import store from '../store/index';

import pointVente from './routes/point-vente'; // Route qui gère tous les point de vente
import entrepot from './routes/entrepot'; // Routes qui gere tous les entrepots

import client from './routes/clients/client'; // Routes qui gère le client
import fournisseurs from './routes/fournisseurs/fournisseurs';
import articles from './routes/articles/articles';
import devis from './routes/devis/devis';
import commande from './routes/commande/commande';
import parametres from './routes/parametres/parametres';

const routes: Array<any> = [
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
        meta: { requiresAuth: false }
    },
]
    .concat(privateRoutes)
    .concat(errorsRoutes)
    .concat(pointVente)
    .concat(entrepot)
    .concat(client)
    .concat(fournisseurs)
    .concat(articles)
    .concat(devis)
    .concat(commande)
    .concat(parametres)

const router = createRouter({
    history: createWebHistory(),
    routes,
});


/**
 * Executé pour chaque changemen de route
 *
 * @param   {Object}  to    Route de destination
 * @param   {Object}  from  Route de provenance
 * @param   {Callback}  next  Closure pour executer la requete suivante
 *
 * @return  {void}
 */
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
