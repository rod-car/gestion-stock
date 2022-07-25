/**
 * Listé ici tous les routes qui conerne la gestion de client
 * Cette liste de routes est ensuite concatené par la route global (router.js dans le dossier router)
 * Tous les routes present dans ce fichier sont privée, L'utilisateur doit être connecté
 *
 * Liste des routes:
 *  -   Creer un nouveau client
 *  -   Liste de tous les clients
 *  -   Voir une client en particuluer
 *  -   Modifier un etrepôt
 *  -   Ajouter et modifier les responsables d'un client
 *  -   Ajouter et modifier les personnelles qui travaillent dans un client
 */

const NouveauCategorie = require('../../../pages/client/categorie/NouveauCategorie.vue');
const ListeCategorie = require('../../../pages/client/categorie/ListeCategorie.vue');
const ModifierCategorie = require('../../../pages/client/categorie/ModifierCategorie.vue');
const NouveauClient = require('../../../pages/Client/NouveauClient.vue');
const ModifierClient = require('../../../pages/Client/ModifierClient.vue');
const VoirClient = require('../../../pages/Client/VoirClient.vue');
const ListeClient = require('../../../pages/Client/ListeClient.vue');

const routes = [
    {
        path: '/client/nouveau',
        name: 'client.nouveau',
        component: NouveauClient,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/client/liste',
        name: 'client.liste',
        component: ListeClient,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/client/voir/:id',
        name: 'client.voir',
        component: VoirClient,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/client/modifier/:id',
        name: 'client.modifier',
        component: ModifierClient,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/client/categorie/nouveau',
        name: 'client.categorie.nouveau',
        component: NouveauCategorie,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/client/categorie/modifier/:id',
        name: 'client.categorie.modifier',
        component: ModifierCategorie,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/client/categorie/liste',
        name: 'client.categorie.liste',
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
