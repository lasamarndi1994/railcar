import { createWebHistory, createRouter } from "vue-router";


import Dasboard from "../components/Dashboard";
import Register from '../components/auth/Register';
import Login from '../components/auth/Login'

export const routes = [{
        name: 'dashboard',
        path: '/dashboard',
        component: Dasboard
    }, {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: 'login',
        path: '/',
        component: Login
    },
];
const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});
// router.beforeEach(to, from, next) => {
//     if (window.Laravel.isLoggedin) {
//         return next('dashboard');
//     }
//     next();
// }




export default router;