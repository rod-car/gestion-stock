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

const NouveauFournisseur = require('../../../pages/fournisseur/NouveauFournisseur.vue');
const ModifierFournisseur = require('../../../pages/fournisseur/ModifierFournisseur.vue');
const VoirFournisseur = require('../../../pages/fournisseur/VoirFournisseur.vue');
const ListeFournisseur = require('../../../pages/fournisseur/ListeFournisseur.vue');
const NouveauCategorie = require('../../../pages/fournisseur/categorie/NouveauCategorie.vue');
const ListeCategorie = require('../../../pages/fournisseur/categorie/ListeCategorie.vue');
const ModifierCategorie = require('../../../pages/fournisseur/categorie/ModifierCategorie.vue');

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
