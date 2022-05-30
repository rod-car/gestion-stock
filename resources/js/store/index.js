import axiosClient from '../axios';
import { createStore } from "vuex";

const store = createStore({
    state: {
        user: {
            data: {
                
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
        storeUser({ commit }, user) {
            commit('storeUser', user)
        }
    },
    mutations: {
        setRole: (state, role) => {
            state.user.data.role = role;
        },
        storeUser: (state, user) => {
            state.user.data = user
        }
    }
});

export default store;
