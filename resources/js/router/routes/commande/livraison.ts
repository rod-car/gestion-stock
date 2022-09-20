/**
 * Listé ici tous les routes qui conerne le bon de livraison
 * Cette liste de routes est ensuite concatené par la route global (router.js dans le dossier router)
 * Tous les routes present dans ce fichier sont privée, L'utilisateur doit être connecté
 *
 * Liste des routes:
 *  -   Creer un nouveau bon de livraison (CLIENT)
 *  -   Modifier un bon de livraison (CLIENT)
 *  -   Liste de tous les bons de livraison avec status (CLIENT)
 *  -   Voir un bon de livraison en particuluer (CLIENT)
 */

import NouveauBonLivraison from '../../../pages/bon-livraison/NouveauBonLivraison.vue';
import ModifierBonLivraison from '../../../pages/bon-livraison/ModifierBonLivraison.vue';
import VoirBonLivraison from '../../../pages/bon-livraison/VoirBonLivraison.vue';
import ListeBonLivraison from '../../../pages/bon-livraison/ListeBonLivraison.vue';

const routes = [
    {
        path: '/bon-livraison/nouveau',
        name: 'bon-livraison.nouveau',
        component: NouveauBonLivraison,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/bon-livraison/liste',
        name: 'bon-livraison.liste',
        component: ListeBonLivraison,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/bon-livraison/voir/:id',
        name: 'bon-livraison.voir',
        component: VoirBonLivraison,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/bon-livraison/modifier/:id',
        name: 'bon-livraison.modifier',
        component: ModifierBonLivraison,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
]

export default routes.map(route => {
    return { ...route }
});
