/**
 * Listé ici tous les routes qui conerne lag gestion des paramètres de l'application
 * Cette liste de routes est ensuite concatené par la route global (router.js dans le dossier router)
 * Tous les routes present dans ce fichier sont privée, L'utilisateur doit être connecté
 *
 * Liste des routes:
 *  -   Gerer les dévis de l'argent
 *  -   Gerer les informations de l'entreprise
 */

const InformationEntreprise = require('../../../pages/parametre/InformationEntreprise.vue');

const routes = [
    {
        path: '/parametres/entreprise',
        name: 'parametres.entreprise',
        component: InformationEntreprise,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
]

export default routes.map(route => {
    return { ...route }
});
