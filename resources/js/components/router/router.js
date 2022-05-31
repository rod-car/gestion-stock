import { createRouter, createWebHistory } from 'vue-router';
import Home from '../pages/Home.vue';
import Login from '../pages/Login.vue';
import Dashboard from '../pages/Dashboard.vue';
import NouveauProduitsFinis from '../pages/articles/produits-finis/NouveauProduitsFinis.vue';
import ListeProduitsFinis from '../pages/articles/produits-finis/ListeProduitsFinis.vue'

import privateRoutes from './routes/private'; // Route special pour les utilisateurs connecté
import errorsRoutes from './routes/errors'; // Route special pour les utilisateurs connecté

import store from '../../store/index';

const routes = [
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/',
        name: 'home',
        component: Home,
        meta: {requiresAuth: true}
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
        path: '/point-de-vente/nouveau',
        name: 'depot.point-de-vente.nouveau',
        component: ListeProduitsFinis
    },
    {
        path: '/point-de-vente/liste',
        name: 'depot.point-de-vente.liste',
        component: ListeProduitsFinis
    },
    {
        path: '/entrepot/nouveau',
        name: 'depot.entrepot.nouveau',
        component: ListeProduitsFinis
    },
    {
        path: '/entrepot/liste',
        name: 'depot.entrepot.liste',
        component: ListeProduitsFinis
    },
]
    .concat(privateRoutes)
    .concat(errorsRoutes);

const router = createRouter({
  history: createWebHistory(),
  routes,
});

/*router.beforeEach((to, from, next) => {
    //Recuperer l'information de la route pour le mettre dans le breadcrumb
    let name = to.name.split('.').at(0)
    window.bcName = ucfirst(name)
    window.bcPath = to.path
    window.bcTree = window.bcPath.replace('/', '').split('/')

    // Mettre des indications pour la route active
    try {
        document.querySelector("a[href='/dashboard']").parentElement.classList.remove('active')
        let link = document.querySelector("a[href='" + to.path + "']")
        let element = link.parentElement.parentElement

        element.classList.add('in')
        element.parentElement.classList.add('active')
    } catch (error) {
        console.log("Une erreur s'et produite : " + error);
    }

    next();
});*/

router.beforeEach((to, from, next) => {
    if (store.state.user.data.id === undefined && to.path !== "/login") {
        getUser()
    }

    // Recuperation des roles del'utilisateur connecté

    if (to.meta.requiresAuth && !store.state.user.token) {
        next({name: 'login'});
    } else {
        next();
    }

});

/**
 * Mettre l'utilisateur connecté dans le store
 *
 * @return  {void}
 */
const getUser = async ()  => {
    await store.dispatch('getUser');
}

export default router;
