/**
 * Listé ici tous les routes qui conerne la gestion des articles
 * Cette liste de routes est ensuite concatené par la route global (router.js dans le dossier router)
 * Tous les routes present dans ce fichier sont privée, L'utilisateur doit être connecté
 *
 * Liste des routes:
 *  -   Creer un nouveau article
 *  -   Liste de tous les articles
 *  -   Voir une article en particuluer
 *  -   Modifier un article
 *  -   Créer un nouveau catégorie d'article
 *  -   Modifier un catégorie d'article
 *  -   Liste des atégories d'article
 */


import NouveauArticle from '../../../pages/articles/NouveauArticle.vue';
import ModifierArticle from '../../../pages/articles/ModifierArticle.vue';
import VoirArticle from '../../../pages/articles/VoirArticle.vue';
import ListeArticle from '../../../pages/articles/ListeArticle.vue';
import NouveauCategorie from '../../../pages/articles/categorie/NouveauCategorie.vue';
import ListeCategorie from '../../../pages/articles/categorie/ListeCategorie.vue';
import ModifierCategorie from '../../../pages/articles/categorie/ModifierCategorie.vue';

const routes = [
    {
        path: '/article/nouveau',
        name: 'article.nouveau',
        component: NouveauArticle,
        meta: {
            requiresAuth: true,
            // gate: 'non definie',
        }
    },
    {
        path: '/article/liste',
        name: 'article.liste',
        component: ListeArticle,
        meta: {
            requiresAuth: true,
            // gate: 'non definie',
        }
    },
    {
        path: '/article/voir/:id',
        name: 'article.voir',
        component: VoirArticle,
        meta: {
            requiresAuth: true,
            // gate: 'non definie',
        }
    },
    {
        path: '/article/modifier/:id',
        name: 'article.modifier',
        component: ModifierArticle,
        meta: {
            requiresAuth: true,
            // gate: 'non definie',
        }
    },
    {
        path: '/article/categorie/nouveau',
        name: 'article.categorie.nouveau',
        component: NouveauCategorie,
        meta: {
            requiresAuth: true,
            // gate: 'non definie',
        }
    },
    {
        path: '/article/categorie/modifier/:id',
        name: 'article.categorie.modifier',
        component: ModifierCategorie,
        meta: {
            requiresAuth: true,
            // gate: 'non definie',
        }
    },
    {
        path: '/article/categorie/liste',
        name: 'article.categorie.liste',
        component: ListeCategorie,
        meta: {
            requiresAuth: true,
            // gate: 'non definie',
        }
    },
]

export default routes.map(route => {
    return { ...route }
});
