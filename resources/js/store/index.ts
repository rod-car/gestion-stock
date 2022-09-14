import axiosClient from '../axios';
import { createStore } from "vuex";

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
        }
    },
    getters: {
        user (state) {
            return state.user.data
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
    },
    mutations: {
        setRole: (state, role) => {
            state.user.data.role = role;
        },
        setUser: (state, user) => {
            state.user.data = user
        }
    }
});

export default store;
