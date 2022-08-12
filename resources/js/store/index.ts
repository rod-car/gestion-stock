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
                .catch( err => console.error("Erreur d'ajout des user", err));
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
