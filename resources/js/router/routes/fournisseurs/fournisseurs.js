/**
 * Listé ici tous les routes qui conerne la gestion de fournisseur
 * Cette liste de routes est ensuite concatené par la route global (router.js dans le dossier router)
 * Tous les routes present dans ce fichier sont privée, L'utilisateur doit être connecté
 *
 * Liste des routes:
 *  -   Creer un nouveau fournisseur
 *  -   Liste de tous les fournisseurs
 *  -   Voir une fournisseur en particuluer
 *  -   Modifier un etrepôt
 *  -   Ajouter et modifier les responsables d'un fournisseur
 *  -   Ajouter et modifier les personnelles qui travaillent dans un fournisseur
 */

import NouveauFournisseur from '../../../pages/fournisseur/NouveauFournisseur.vue';
import ModifierFournisseur from '../../../pages/fournisseur/ModifierFournisseur.vue';
import VoirFournisseur from '../../../pages/fournisseur/VoirFournisseur.vue';
import ListeFournisseur from '../../../pages/fournisseur/ListeFournisseur.vue';
import NouveauCategorie from '../../../pages/fournisseur/categorie/NouveauCategorie.vue';
import ListeCategorie from '../../../pages/fournisseur/categorie/ListeCategorie.vue';
import ModifierCategorie from '../../../pages/fournisseur/categorie/ModifierCategorie.vue';

const routes = [
    {
        path: '/fournisseur/nouveau',
        name: 'fournisseur.nouveau',
        component: NouveauFournisseur,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/fournisseur/liste',
        name: 'fournisseur.liste',
        component: ListeFournisseur,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/fournisseur/voir/:id',
        name: 'fournisseur.voir',
        component: VoirFournisseur,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/fournisseur/modifier/:id',
        name: 'fournisseur.modifier',
        component: ModifierFournisseur,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/fournisseur/categorie/nouveau',
        name: 'fournisseur.categorie.nouveau',
        component: NouveauCategorie,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/fournisseur/categorie/modifier/:id',
        name: 'fournisseur.categorie.modifier',
        component: ModifierCategorie,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/fournisseur/categorie/liste',
        name: 'fournisseur.categorie.liste',
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
