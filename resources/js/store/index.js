import { createStore } from "vuex";
import createPersistedState from "vuex-persistedstate";

export default createStore({
    state: {
        user: null,
    },
    actions: {

    },
    getters: {
        getUser: state => state.user,
    },
    mutations: {
        setUser(state, user) {
            state.user=user;
        }
    },
    plugins: [createPersistedState()],
});
