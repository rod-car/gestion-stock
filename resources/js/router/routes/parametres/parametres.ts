/**
 * Listé ici tous les routes qui conerne lag gestion des paramètres de l'application
 * Cette liste de routes est ensuite concatené par la route global (router.js dans le dossier router)
 * Tous les routes present dans ce fichier sont privée, L'utilisateur doit être connecté
 *
 * Liste des routes:
 *  -   Gerer les devis de l'argent
 *  -   Gerer les informations de l'entreprise
 */

import InformationEntreprise from '../../../pages/parametre/InformationEntreprise.vue';
import ListeEtiquette from '../../../pages/etiquette/ListeEtiquette.vue'
import NouveauEtiquette from '../../../pages/etiquette/NouveauEtiquette.vue'
import ModifierEtiquette from '../../../pages/etiquette/ModifierEtiquette.vue'

const routes = [
    {
        path: '/parametres/entreprise',
        name: 'parametres.entreprise',
        component: InformationEntreprise,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/parametres/etiquette/liste',
        name: 'parametres.etiquette',
        component: ListeEtiquette,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/parametres/etiquette/nouveau',
        name: 'parametres.etiquette.nouveau',
        component: NouveauEtiquette,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    },
    {
        path: '/parametres/etiquette/modifier/:id',
        name: 'parametres.etiquette.modifier',
        component: ModifierEtiquette,
        meta: {
            requiresAuth: true,
            // gate: 'add_entrepot',
        }
    }
]

export default routes.map(route => {
    return { ...route }
});
