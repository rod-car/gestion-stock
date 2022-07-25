/**
 * Listé ici tous les routes qui conerne la gestion de article
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


const NouveauArticle = require('../../../pages/articles/NouveauArticle.vue');
const ModifierArticle = require('../../../pages/articles/ModifierArticle.vue');
const VoirArticle = require('../../../pages/articles/VoirArticle.vue');
const ListeArticle = require('../../../pages/articles/ListeArticle.vue');
const NouveauCategorie = require('../../../pages/articles/categorie/NouveauCategorie.vue');
const ListeCategorie = require('../../../pages/articles/categorie/ListeCategorie.vue');
const ModifierCategorie = require('../../../pages/articles/categorie/ModifierCategorie.vue');

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
    }
]

export default routes.map(route => {
    return { ...route }
});
