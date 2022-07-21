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

import NouvelleCommandeFrs from '../../../pages/commande/fournisseur/NouvelleCommande.vue';
import ModifierCommandeFrs from '../../../pages/commande/fournisseur/ModifierCommande.vue';
import VoirCommandeFrs from '../../../pages/commande/fournisseur/VoirCommande.vue';
import ListeCommandeFrs from '../../../pages/commande/fournisseur/ListeCommande.vue';

import NouvelleCommandeClient from '../../../pages/commande/client/NouvelleCommande.vue';
import ModifierCommandeClient from '../../../pages/commande/client/ModifierCommande.vue';
import VoirCommandeClient from '../../../pages/commande/client/VoirCommande.vue';
import ListeCommandeClient from '../../../pages/commande/client/ListeCommande.vue';

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
