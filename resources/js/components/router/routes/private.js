import NouveauPersonnel from '../../pages/personnels/NouveauPersonnel.vue';
import ListePersonnel from '../../pages/personnels/ListePersonnel.vue';

const routes = [
    {
        path: '/personnel/nouveau',
        name: 'gestion des personnels.personnel.nouveau',
        component: NouveauPersonnel
    },
    {
        path: '/personnel/liste',
        name: 'gestion des personnels.personnel.liste',
        component: ListePersonnel
    }
];

export default routes.map(route => {
    return { ...route, meta: { public: false } }
});
