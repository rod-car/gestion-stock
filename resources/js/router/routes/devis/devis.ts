/**
 * Listé ici tous les routes qui conerne la gestion de devis
 * Cette liste de routes est ensuite concatené par la route global (router.js dans le dossier router)
 * Tous les routes present dans ce fichier sont privée, L'utilisateur doit être connecté
 *
 * Liste des routes:
 *  -   Creer un nouveau devis
 *  -   Liste de tous les deviss
 *  -   Voir une devis en particuluer
 */

import NouveauDevisFrs from '../../../pages/devis/fournisseur/NouveauDevis.vue';
import ModifierDevisFrs from '../../../pages/devis/fournisseur/ModifierDevis.vue';
import VoirDevisFrs from '../../../pages/devis/fournisseur/VoirDevis.vue';
import ListeDevisFrs from '../../../pages/devis/fournisseur/ListeDevis.vue';

import NouveauDevisClient from '../../../pages/devis/client/NouveauDevis.vue';
import ModifierDevisClient from '../../../pages/devis/client/ModifierDevis.vue';
import VoirDevisClient from '../../../pages/devis/client/VoirDevis.vue';
import ListeDevisClient from '../../../pages/devis/client/ListeDevis.vue';

const devisFournisseurs = [
    {
        path: '/devis/fournisseur/nouveau',
        name: 'devis.fournisseur.nouveau',
        component: NouveauDevisFrs,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/devis/fournisseur/liste',
        name: 'devis.fournisseur.liste',
        component: ListeDevisFrs,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/devis/fournisseur/voir/:id',
        name: 'devis.fournisseur.voir',
        component: VoirDevisFrs,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/devis/fournisseur/modifier/:id',
        name: 'devis.fournisseur.modifier',
        component: ModifierDevisFrs,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
]


const devisClient = [
    {
        path: '/devis/client/nouveau',
        name: 'devis.client.nouveau',
        component: NouveauDevisClient,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/devis/client/liste',
        name: 'devis.client.liste',
        component: ListeDevisClient,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/devis/client/voir/:id',
        name: 'devis.client.voir',
        component: VoirDevisClient,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/devis/client/modifier/:id',
        name: 'devis.client.modifier',
        component: ModifierDevisClient,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
]

const routes = devisFournisseurs.concat(devisClient)

export default routes.map(route => {
    return { ...route }
});
