import { createRouter, createWebHistory  } from 'vue-router';

//Support agent specific routes
import Dashboard from "../components/dashboard/Dashboard";
import TicketsOverview from "../components/tickets/tickets-overview/TicketsOverview";

//User specific routes
import SupportCenter from "../components/SupportCenter/SupportCenter";

//Shared routes

const router = createRouter({
    linkActiveClass: 'active',
    history: createWebHistory(),
    scrollBehavior(to, from, savedPosition) {
        return { left: 0, top: 0 };
    },
    routes: [
        { path: '/dashboard', component: Dashboard, name: 'Dashboard', meta: { title: 'Dashboard'} },
        { path: '/tickets-overview', component: TicketsOverview, name: 'TicketsOverview', meta: { title: 'Tickets Overview'} },
        { path: '/support-center', component: SupportCenter, name: 'SupportCenter', meta: { title: 'Support Center'} },
    ]
})

export default router