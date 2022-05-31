import NouveauPersonnel from '../../pages/personnels/NouveauPersonnel.vue';
import ListePersonnel from '../../pages/personnels/ListePersonnel.vue';
import ProfilPersonnel from '../../pages/personnels/ProfilPersonnel.vue';
import ModifierPersonnel from '../../pages/personnels/ModifierPersonnel.vue';

const routes = [
    {
        path: '/personnel/nouveau',
        name: 'gestion des personnels.personnel.nouveau',
        component: NouveauPersonnel,
        meta: {
            gate: 'add_user',
        }
    },
    {
        path: '/personnel/liste',
        name: 'gestion des personnels.personnel.liste',
        component: ListePersonnel
    },
    {
        path: '/personnel/profile/:id',
        name: 'gestion-des-personnels.personnel.profil',
        component: ProfilPersonnel
    },
    {
        path: '/personnel/modifier/:id',
        name: 'gestion-des-personnels.personnel.modifier',
        component: ModifierPersonnel,
        meta: {
            gate: 'edit_user',
        }
    }
];

export default routes.map(route => {
    return { ...route/*, meta: { public: false }*/ }
});
