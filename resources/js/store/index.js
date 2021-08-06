import { createStore } from "vuex";
import createPersistedState from "vuex-persistedstate";

export default createStore({
    state: {
        user: null,
        categories: null,
    },
    actions: {

    },
    getters: {
        getUser: state => state.user,
        getCategories: state => state.categories,
    },
    mutations: {
        setCategories(state, categories) {
            state.categories=categories;
        },
        setUser(state, user) {
            state.user=user;
        }
    },
    plugins: [createPersistedState()],
});
