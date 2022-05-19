import { createRouter, createWebHistory } from 'vue-router';
import Home from '../pages/Home.vue';
import Login from '../pages/Login.vue';
import Dashboard from '../pages/Dashboard.vue';
import NouveauProduitsFinis from '../pages/articles/produits-finis/NouveauProduitsFinis.vue';
import ListeProduitsFinis from '../pages/articles/produits-finis/ListeProduitsFinis.vue'

const routes = [
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard
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
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router
