/**
 * Listé ici tous les routes qui conerne la facturation
 * Cette liste de routes est ensuite concatené par la route global (router.js dans le dossier router)
 * Tous les routes present dans ce fichier sont privée, L'utilisateur doit être connecté
 *
 * Liste des routes:
 *  -   Creer une nouvelle facturation
 *  -   Modifier une facturation
 *  -   Liste de tous les factures
 *  -   Voir une facture en particulier
 */

import NouvelleFacture from '../../../pages/facturation/NouvelleFacture.vue';
import ModifierFacture from '../../../pages/facturation/ModifierFacture.vue';
import VoirFacture from '../../../pages/facturation/VoirFacture.vue';
import ListeFacture from '../../../pages/facturation/ListeFacture.vue';

const routes = [
    {
        path: '/facture/nouveau',
        name: 'facture.nouvelle',
        component: NouvelleFacture,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/facture/liste',
        name: 'facture.liste',
        component: ListeFacture,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/facture/voir/:id',
        name: 'facture.voir',
        component: VoirFacture,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/facture/modifier/:id',
        name: 'facture.modifier',
        component: ModifierFacture,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
]

export default routes.map(route => {
    return { ...route }
});

