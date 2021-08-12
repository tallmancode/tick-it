import { createRouter, createWebHistory  } from 'vue-router';
import Dashboard from "../components/dashboard/Dashboard";

const router = createRouter({
    linkActiveClass: 'active',
    history: createWebHistory(),
    scrollBehavior(to, from, savedPosition) {
        return { left: 0, top: 0 };
    },
    routes: [
        { path: '/dashboard', component: Dashboard, name: 'Dashboard' },
    ]
})

export default router