/**
 * Listé ici tous les routes qui conerne la gestion des articles
 * Cette liste de routes est ensuite concatené par la route global (router.js dans le dossier router)
 * Tous les routes present dans ce fichier sont privée, L'utilisateur doit être connecté
 *
 * Liste des routes:
 *  -   Creer un nouvel article
 *  -   Liste de tous les articles
 *  -   Voir une article en particuluer
 *  -   Modifier un article
 *  -   Créer un nouveau catégorie d'article
 *  -   Modifier un catégorie d'article
 *  -   Liste des atégories d'article
 */


import NouveauTransfert from '../../../pages/transfert-article/NouveauTransfert.vue';
import ListeTransfert from '../../../pages/transfert-article/ListeTransfert.vue'
import ModifierTransfert from  '../../../pages/transfert-article/ModifierTransfert.vue'

const routes = [
    {
        path: '/transfert-article/nouveau',
        name: 'transfert.nouveau',
        component: NouveauTransfert,
        meta: {
            requiresAuth: true,
            // gate: 'non definie',
        }
    },
    {
        path: '/transfert-article/liste',
        name: 'transfert.liste',
        component: ListeTransfert,
        meta: {
            requiresAuth: true,
            // gate: 'non definie',
        }
    },
    {
        path: '/transfert-article/modifier/:id',
        name: 'transfert.modifier',
        component: ModifierTransfert,
        meta: {
            requiresAuth: true,
            // gate: 'non definie',
        }
    },

]

export default routes.map(route => {
    return { ...route }
});
