import { createRouter, createWebHistory } from 'vue-router';
import Home from '../pages/Home.vue';
import Dashboard from '../pages/Dashboard.vue';
import NouveauProduitsFinis from '../pages/articles/produits-finis/NouveauProduitsFinis.vue';
import ListeProduitsFinis from '../pages/articles/produits-finis/ListeProduitsFinis.vue'
import NouveauMatierePremiere from '../pages/articles/matieres-premieres/NouveauMatieresPremieres.vue';
import ListeMatierePremiere from '../pages/articles/matieres-premieres/ListeMatieresPremieres.vue'

const routes = [
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
        path: '/produit-finis/nouveau',
        name: 'article.produit-fini.nouveau',
        component: NouveauProduitsFinis
    },
    {
        path: '/produit-finis/liste',
        name: 'article.produit-fini.liste',
        component: ListeProduitsFinis
    },
    {
        path: '/matiere-premiere/nouveau',
        name: 'article.matiere-premiere.nouveau',
        component: NouveauMatierePremiere
    },
    {
        path: '/matiere-premiere/liste',
        name: 'article.matiere-premiere.liste',
        component: ListeMatierePremiere
    }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router
