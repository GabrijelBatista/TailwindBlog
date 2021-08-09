import { createWebHistory, createRouter } from "vue-router";
import store from './store/index'

import HomePage from "./components/HomePage.vue";
import AdminLogin from "./components/AdminLogin.vue";
import About from "./components/About.vue";
import Article from "./components/Article.vue";
import AddArticle from "./components/AddArticle.vue";


const routes = [
  {
    path: "/",
    name: "Home",
    component: HomePage,
  },
  {
    path: "/admin-login",
    name: "Login",
    component: AdminLogin,
  },
  {
    path: "/about",
    name: "About",
    component: About,
  },
  {
    path: "/article/:title",
    name: "Article",
    component: Article,
  },
    {
        path: "/add-article",
        name: "AddArticle",
        component: AddArticle,
        meta: {
            requiresAuth: true
        }
    },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth) {
        if (!store.getters['getUser']) {
            next({path: '/admin-login'})
        } else {
            next()
        }
    }
    else {
        next()
    }
});
export default router;
