import { createRouter, createWebHistory  } from 'vue-router';
import Home from "../components/home/Home";
// import Register from "../components/auth/register/Register";
// import Login from "../components/auth/login/Login";
// import PasswordReset from "../components/auth/reset/PasswordReset";
// import PasswordUpdate from "../components/auth/password-update/PasswordUpdate";

const router = createRouter({
    linkActiveClass: 'active',
    history: createWebHistory(),
    scrollBehavior(to, from, savedPosition) {
        return { left: 0, top: 0 };
    },
    routes: [
        { path: '/', component: Home, name: 'Home' },
        // { path: '/register', component: Register, name: 'Register' },
        // { path: '/login', component: Login, name: 'Login' },
        // { path: '/password/reset', component: PasswordReset, name: 'Reset' },
        // { path: '/password/reset/:token', component: PasswordUpdate, name: 'PasswordUpdate',
        //     beforeEnter: (to, from, next) =>
        //     {
        //         if(!to.query.email || !to.params.token) {
        //             next('/password/reset')
        //         }
        //         next();
        //     }
        // },
    ]
})

export default router