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

import NouveauDevis from '../../../pages/devis/NouveauDevis.vue';
import ModifierDevis from '../../../pages/devis/ModifierDevis.vue';
import VoirDevis from '../../../pages/devis/VoirDevis.vue';
import ListeDevis from '../../../pages/devis/ListeDevis.vue';

const routes = [
    {
        path: '/devis/nouveau',
        name: 'devis.nouveau',
        component: NouveauDevis,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/devis/liste',
        name: 'devis.liste',
        component: ListeDevis,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/devis/voir/:id',
        name: 'devis.voir',
        component: VoirDevis,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/devis/modifier/:id',
        name: 'devis.modifier',
        component: ModifierDevis,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
]

export default routes.map(route => {
    return { ...route }
});
