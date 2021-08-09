import { createRouter, createWebHistory  } from 'vue-router';
import Home from "../components/home/Home";
import Login from "../components/login/Login";

const router = createRouter({
    linkActiveClass: 'active',
    history: createWebHistory(),
    scrollBehavior(to, from, savedPosition) {
        return { left: 0, top: 0 };
    },
    routes: [
        { path: '/', component: Home, name: 'Home' },
        { path: '/login', component: Login, name: 'Login' },
    ]
})

export default router