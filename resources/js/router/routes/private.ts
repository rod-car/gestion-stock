import NouveauPersonnel from '../../pages/personnels/NouveauPersonnel.vue';
import ListePersonnel from '../../pages/personnels/ListePersonnel.vue';
import ProfilPersonnel from '../../pages/personnels/ProfilPersonnel.vue';
import ModifierPersonnel from '../../pages/personnels/ModifierPersonnel.vue';
import Fonctions from '../../pages/personnels/Fonctions.vue';

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
