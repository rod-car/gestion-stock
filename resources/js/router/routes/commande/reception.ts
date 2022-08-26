/**
 * Listé ici tous les routes qui conerne le bon de reception
 * Cette liste de routes est ensuite concatené par la route global (router.js dans le dossier router)
 * Tous les routes present dans ce fichier sont privée, L'utilisateur doit être connecté
 *
 * Liste des routes:
 *  -   Creer un nouveau bon de reception (FRS)
 *  -   Modifier un bon de reception (FRS)
 *  -   Liste de tous les bons de reception avec status (FRS)
 *  -   Voir un bon de reception en particuluer (FRS)
 */

import NouveauBonReception from '../../../pages/bon-reception/NouveauBonReception.vue';
import ModifierBonReception from '../../../pages/bon-reception/ModifierBonReception.vue';
import VoirBonReception from '../../../pages/bon-reception/VoirBonReception.vue';
import ListeBonReception from '../../../pages/bon-reception/ListeBonReception.vue';

const routes = [
    {
        path: '/bon-reception/nouveau',
        name: 'bon-reception.nouveau',
        component: NouveauBonReception,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/bon-reception/liste',
        name: 'bon-reception.liste',
        component: ListeBonReception,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/bon-reception/voir/:id',
        name: 'bon-reception.voir',
        component: VoirBonReception,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/bon-reception/modifier/:id',
        name: 'bon-reception.modifier',
        component: ModifierBonReception,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
]

export default routes.map(route => {
    return { ...route }
});
