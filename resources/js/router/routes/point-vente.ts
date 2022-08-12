/**
 * Listé ici tous les routes qui conerne la gestion de point de vente
 * Cette liste de routes est ensuite concatené par la route global (router.js dans le dossier router)
 * Tous les routes present dans ce fichier sont privée, L'utilisateur doit être connecté
 *
 * Liste des routes:
 *  -   Creer Nouveau point de vente
 *  -   Liste de tous les points de vente
 *  -   Voir un point de vente en particulier
 *  -   Modifier un point de vente
 *  -   Ajouter et modifier les responsables d'un poin de vente
 *  -   Ajouter et modifier les personnelles qui travaillent dans un point de vente
 */

import NouveauPointVente  from '../../pages/point-vente/NouveauPointVente.vue';
import ModifierPointVente  from '../../pages/point-vente/ModifierPointVente.vue';
import ListePointVente  from '../../pages/point-vente/ListePointVente.vue';
import VoirPointVente  from '../../pages/point-vente/VoirPointVente.vue';
import GererResponsable  from '../../pages/point-vente/GererResponsable.vue';
import GererPersonnel  from '../../pages/point-vente/GererPersonnel.vue';

const routes = [
    {
        path: '/point-de-vente/nouveau',
        name: 'depot.point-de-vente.nouveau',
        component: NouveauPointVente,
        meta: {
            requiresAuth: true,
            gate: 'add_point_vente',
        }
    },
    {
        path: '/point-de-vente/liste',
        name: 'depot.point-de-vente.liste',
        component: ListePointVente,
        meta: {
            requiresAuth: true,
            gate: 'view_point_vente',
        }
    },
    {
        path: '/point-de-vente/voir/:id',
        name: 'point-de-vente.voir',
        component: VoirPointVente,
        meta: {
            requiresAuth: true,
            gate: 'view_point_vente',
        }
    },
    {
        path: '/point-de-vente/modifier/:id',
        name: 'point-de-vente.modifier',
        component: ModifierPointVente,
        meta: {
            requiresAuth: true,
            gate: 'edit_point_vente',
        }
    },
    {
        path: '/point-de-vente/:id/responsables',
        name: 'point-de-vente.gerer-responsables',
        component: GererResponsable,
        meta: {
            requiresAuth: true,
        }
    },
    {
        path: '/point-de-vente/:id/personnelles',
        name: 'point-de-vente.gerer-personnelles',
        component: GererPersonnel,
        meta: {
            requiresAuth: true,
        }
    },
]

export default routes.map(route => {
    return { ...route/*, meta: { public: false }*/ }
});
