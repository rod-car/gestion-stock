import { createRouter, createWebHistory } from 'vue-router';
import Home from '../pages/Home.vue';
import About from '../pages/About.vue';
import Dashboard from '../pages/Dashboard.vue';

const routes = [
    {
        path: '/about',
        name: 'app.test',
        component: About,
    },
    {
        path: '/dashboard',
        name: 'app.dashboard',
        component: Dashboard,
    },
    {
        path: '/',
        name: 'app.index',
        component: Home
    }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router
