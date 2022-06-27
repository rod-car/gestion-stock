/**
 * Listé ici tous les routes qui conerne la gestion de l'entrepôt
 * Cette liste de routes est ensuite concatené par la route global (router.js dans le dossier router)
 * Tous les routes present dans ce fichier sont privée, L'utilisateur doit être connecté
 *
 * Liste des routes:
 *  -   Creer un nouveau entrepôt
 *  -   Liste de tous les entrepôts
 *  -   Voir une entrepôt en particuluer
 *  -   Modifier un etrepôt
 *  -   Ajouter et modifier les responsables d'un entrepôt
 *  -   Ajouter et modifier les personnelles qui travaillent dans un entrepôt
 */

import NouveauEntrepot from '../../pages/entrepot/NouveauEntrepot.vue';
import ModifierEntrepot from '../../pages/entrepot/ModifierEntrepot.vue';
import ListeEntrepot from '../../pages/entrepot/ListeEntrepot.vue';
import VoirEntrepot from '../../pages/entrepot/VoirEntrepot.vue';
import GererResponsable from '../../pages/entrepot/GererResponsable.vue';
import GererPersonnel from '../../pages/entrepot/GererPersonnel.vue';

const routes = [
    {
        path: '/entrepot/nouveau',
        name: 'depot.entrepot.nouveau',
        component: NouveauEntrepot,
        meta: {
            requiresAuth: true,
            gate: 'add_entrepot',
        }
    },
    {
        path: '/entrepot/liste',
        name: 'depot.entrepot.liste',
        component: ListeEntrepot,
        meta: {
            requiresAuth: true,
            gate: 'view_entrepot',
        }
    },
    {
        path: '/entrepot/voir/:id',
        name: 'entrepot.voir',
        component: VoirEntrepot,
        meta: {
            requiresAuth: true,
            gate: 'view_entrepot',
        }
    },
    {
        path: '/entrepot/modifier/:id',
        name: 'entrepot.modifier',
        component: ModifierEntrepot,
        meta: {
            requiresAuth: true,
            gate: 'edit_entrepot',
        }
    },
    {
        path: '/entrepot/:id/responsables',
        name: 'entrepot.gerer-responsables',
        component: GererResponsable,
        meta: {
            requiresAuth: true,
        }
    },
    {
        path: '/entrepot/:id/personnelles',
        name: 'entrepot.gerer-personnelles',
        component: GererPersonnel,
        meta: {
            requiresAuth: true,
        }
    },
]

export default routes.map(route => {
    return { ...route }
});
