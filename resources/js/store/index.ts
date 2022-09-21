import axiosClient from '../axios';
import { createStore } from "vuex";

type Entreprise = {
    id?: number|null,
    generale: {
        nom: string,
        nif?: string | null,
        email: string | null,
        contact?: string | null,
        assujeti: boolean
    },
    devise?: null
}

const val: Entreprise = {
    generale: {
        nom: 'Anonyme entreprise',
        email: 'anonyme@gmail.com',
        assujeti: true,
    }
}

const store = createStore({
    state: {
        user: {
            data: {
                id: null,
                role: null,
                nom_personnel: null,
                prenoms_personnel: null,
            },
            token: localStorage.getItem('auth_token')
        },
        infoEntreprise: val
    },
    getters: {
        user (state) {
            return state.user.data
        },
        infoEntreprise(state) {
            return state.infoEntreprise
        },
        isAssujeti(state) {
            return state.infoEntreprise.generale.assujeti
        }
    },
    actions: {
        getRole({ commit }) {
            axiosClient.get('getRole')
                .then( res => {
                    commit('setRole', res.data.role);
                })
                .catch( err => console.log(err));
        },
        getUser({ commit }) {
            axiosClient.get('connected-user')
                .then(res => {
                    commit('setUser', res.data);
                })
                .catch(err => {
                    // Si l'utilisateur n'est pas connecté
                    if (err.response.status === 401) {
                        store.state.user.token = null
                        store.state.user.data = { id: null, role: null, nom_personnel: null, prenoms_personnel: null }
                        localStorage.removeItem('auth_token')
                    } else {
                        console.error(`Erreur ajax: ${err.response.data.message}`);
                    }

                });
        },
        getEntrepriseInformations({ commit }) {
            axiosClient.get('parametres/generale')
                .then(res => {
                    commit('setInfoEntreprise', res.data);
                })
                .catch(err => {
                    // Si l'utilisateur n'est pas connecté
                    if (err.response.status === 401) {
                        throw new Error("Utilisateur non connecté");
                    } else {
                        throw new Error("Une autre erreur : " + err);
                    }

                });
        },
    },
    mutations: {
        setRole: (state, role) => {
            state.user.data.role = role;
        },
        setUser: (state, user) => {
            state.user.data = user
        },
        setInfoEntreprise: (state, info) => {
            state.infoEntreprise = info
        }
    }
});

export default store;
