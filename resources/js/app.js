require('./bootstrap');

require('./functions/string')

import { createApp } from 'vue'
import router from './components/router/router';
import DefaultLayoutComponent from './components/template/DefaultLayoutComponent.vue';
import Login from './components/pages/Login.vue';

import VueSimpleAlert from "vue3-simple-alert";
import VueProgressBar from "@aacassandra/vue3-progressbar";

import { abilitiesPlugin } from '@casl/vue';
import ability from './services/ability';

import VueSidebarMenu from 'vue-sidebar-menu'
// import 'vue-sidebar-menu/dist/vue-sidebar-menu.css'

const options = {
    color: "#58BFD9",
    failedColor: "#874b4b",
    thickness: "5px",
    transition: {
        speed: "1s",
        opacity: "0.6s",
        termination: 300,
    },
    autoRevert: true,
    location: "top",
    inverse: false,
    disableGlobalInstance: false,
};

window.SimpleAlert = VueSimpleAlert

createApp({
    components: {
        DefaultLayoutComponent,
        Login,
    },
})
    .use(router)
    .use(VueProgressBar, options)
    .use(abilitiesPlugin, ability, {
        useGlobalProperties: true
    })
    .use(VueSidebarMenu)
    .mount('#app');
