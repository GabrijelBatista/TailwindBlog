import { createStore } from "vuex";
import createPersistedState from "vuex-persistedstate";

export default createStore({
    state: {
        user: null,
        categories: null,
        articles: null,
        selected_article: null,
        editing_article: false,
        display_articles: null,
        selected_category: 1000,
        sort : 'Newest'
    },
    actions: {

    },
    getters: {
        getUser: state => state.user,
        getCategories: state => state.categories,
        getArticles: state => state.articles,
        getSelectedArticle: state => state.selected_article,
        getSelectedCategory: state => state.selected_category,
        getEditingArticle: state => state.editing_article,
        getDisplayArticles: state => state.display_articles,
        getSort: state => state.sort
    },
    mutations: {
        setCategories(state, categories) {
            state.categories=categories;
        },
        setArticles(state, articles) {
            state.articles=articles;
        },
        setSelectedArticle(state, selected_article) {
            state.selected_article=selected_article;
        },
        setUser(state, user) {
            state.user=user;
        },
        setEditingArticle(state, value) {
            state.editing_article=value;
        },
        setDisplayArticles(state, display_articles) {
            state.display_articles=display_articles;
        },
        setSelectedCategory(state, id) {
            state.selected_category=id;
        },
        setSort(state, sort) {
            state.sort=sort;
        },
    },
    plugins: [createPersistedState({
        storage: window.sessionStorage,
    })],
});
