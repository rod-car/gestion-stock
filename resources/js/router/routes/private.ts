const NouveauPersonnel = require('../../pages/personnels/NouveauPersonnel.vue');
const ListePersonnel = require('../../pages/personnels/ListePersonnel.vue');
const ProfilPersonnel = require('../../pages/personnels/ProfilPersonnel.vue');
const ModifierPersonnel = require('../../pages/personnels/ModifierPersonnel.vue');
const Fonctions = require('../../pages/personnels/Fonctions.vue');

const routes = [
    {
        path: '/personnel/nouveau',
        name: 'gestion des personnels.personnel.nouveau',
        component: NouveauPersonnel,
        meta: {
            gate: 'add_user',
            requiresAuth: true,
        }
    },
    {
        path: '/personnel/liste',
        name: 'gestion des personnels.personnel.liste',
        component: ListePersonnel,
        meta: {
            requiresAuth: true,
            gate: 'add_user',
        }
    },
    {
        path: '/personnel/profile/:id',
        name: 'gestion-des-personnels.personnel.profil',
        component: ProfilPersonnel,
        meta: {
            requiresAuth: true,
            gate: 'add_user',
        }
    },
    {
        path: '/personnel/modifier/:id',
        name: 'gestion-des-personnels.personnel.modifier',
        component: ModifierPersonnel,
        meta: {
            requiresAuth: true,
            gate: 'edit_user',
        }
    },
    {
        path: '/personnel/fonctions',
        name: 'gestion-des-personnels.personnel.fonctions',
        component: Fonctions,
        meta: {
            requiresAuth: true,
            gate: 'manage_roles_and_functions',
        }
    }
];

export default routes.map(route => {
    return { ...route }
});
