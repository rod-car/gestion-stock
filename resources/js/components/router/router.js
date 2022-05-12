import { createRouter, createWebHistory } from 'vue-router';
import ExampleComponent from '../ExampleComponent.vue'
import TestComponent from '../TestComponent.vue'

const routes = [
    {
        path: '/test',
        name: 'app.test',
        component: TestComponent,
    },
    {
        path: '/',
        name: 'app.index',
        component: ExampleComponent
    }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router
