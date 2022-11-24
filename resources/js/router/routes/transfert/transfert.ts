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


import NouveauTransfert from '../../../pages/transfert-article/NouveauTransfert.vue';



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

]

export default routes.map(route => {
    return { ...route }
});
