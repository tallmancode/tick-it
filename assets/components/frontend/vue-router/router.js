import { createRouter, createWebHistory  } from 'vue-router';
import Home from "../components/home/Home";
import Login from "../components/login/Login";

import ComplexQueries from "../components/complex-queries/ComplexQueries";

import FileManipulation from "../components/file-manipulation/FileManipulation";

const router = createRouter({
    linkActiveClass: 'active',
    history: createWebHistory(),
    scrollBehavior(to, from, savedPosition) {
        return { left: 0, top: 0 };
    },
    routes: [
        { path: '/', component: Home, name: 'Home' },
        { path: '/login', component: Login, name: 'Login' },
        { path: '/complex-queries', component: ComplexQueries, name: 'ComplexQueries' },
        { path: '/file-manipulation', component: FileManipulation, name: 'FileManipulation' },
    ]
})

export default router