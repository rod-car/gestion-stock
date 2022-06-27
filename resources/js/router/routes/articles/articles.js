/**
 * Listé ici tous les routes qui conerne la gestion de article
 * Cette liste de routes est ensuite concatené par la route global (router.js dans le dossier router)
 * Tous les routes present dans ce fichier sont privée, L'utilisateur doit être connecté
 *
 * Liste des routes:
 *  -   Creer un nouveau article
 *  -   Liste de tous les articles
 *  -   Voir une article en particuluer
 *  -   Modifier un etrepôt
 *  -   Ajouter et modifier les responsables d'un article
 *  -   Ajouter et modifier les personnelles qui travaillent dans un article
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
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/article/liste',
        name: 'article.liste',
        component: ListeArticle,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/article/voir/:id',
        name: 'article.voir',
        component: VoirArticle,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/article/modifier/:id',
        name: 'article.modifier',
        component: ModifierArticle,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/article/categorie/nouveau',
        name: 'article.categorie.nouveau',
        component: NouveauCategorie,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/article/categorie/modifier/:id',
        name: 'article.categorie.modifier',
        component: ModifierCategorie,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/article/categorie/liste',
        name: 'article.categorie.liste',
        component: ListeCategorie,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    }
]

export default routes.map(route => {
    return { ...route }
});
