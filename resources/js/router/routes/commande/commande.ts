/**
 * Listé ici tous les routes qui conerne la gestion de commande
 * Cette liste de routes est ensuite concatené par la route global (router.js dans le dossier router)
 * Tous les routes present dans ce fichier sont privée, L'utilisateur doit être connecté
 *
 * Liste des routes:
 *  -   Creer un nouveau commande
 *  -   Liste de tous les commandes
 *  -   Voir une commande en particuluer
 */

const NouvelleCommandeFrs = require('../../../pages/commande/fournisseur/NouvelleCommande.vue');
const ModifierCommandeFrs = require('../../../pages/commande/fournisseur/ModifierCommande.vue');
const VoirCommandeFrs = require('../../../pages/commande/fournisseur/VoirCommande.vue');
const ListeCommandeFrs = require('../../../pages/commande/fournisseur/ListeCommande.vue');

const NouvelleCommandeClient = require('../../../pages/commande/client/NouvelleCommande.vue');
const ModifierCommandeClient = require('../../../pages/commande/client/ModifierCommande.vue');
const VoirCommandeClient = require('../../../pages/commande/client/VoirCommande.vue');
const ListeCommandeClient = require('../../../pages/commande/client/ListeCommande.vue');

const commandeFournisseurs = [
    {
        path: '/commande/fournisseur/nouveau',
        name: 'commande.fournisseur.nouveau',
        component: NouvelleCommandeFrs,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/commande/fournisseur/liste',
        name: 'commande.fournisseur.liste',
        component: ListeCommandeFrs,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/commande/fournisseur/voir/:id',
        name: 'commande.fournisseur.voir',
        component: VoirCommandeFrs,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/commande/fournisseur/modifier/:id',
        name: 'commande.fournisseur.modifier',
        component: ModifierCommandeFrs,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
]


const commandeClient = [
    {
        path: '/commande/client/nouveau',
        name: 'commande.client.nouveau',
        component: NouvelleCommandeClient,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/commande/client/liste',
        name: 'commande.client.liste',
        component: ListeCommandeClient,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/commande/client/voir/:id',
        name: 'commande.client.voir',
        component: VoirCommandeClient,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/commande/client/modifier/:id',
        name: 'commande.client.modifier',
        component: ModifierCommandeClient,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
]

const routes = commandeFournisseurs.concat(commandeClient)

export default routes.map(route => {
    return { ...route }
});
