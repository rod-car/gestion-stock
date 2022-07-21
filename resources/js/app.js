require('./bootstrap');

require('./functions/string')

import { createApp } from 'vue'
import router from './router/router';
import DefaultLayout from './template/DefaultLayout.vue';
import Login from './pages/Login.vue';

import VueSimpleAlert from "vue3-simple-alert";
import VueProgressBar from "@aacassandra/vue3-progressbar";

import { abilitiesPlugin } from '@casl/vue';
import ability from './services/ability';

import VueSidebarMenu from 'vue-sidebar-menu'
import Message from 'vue-m-message'
import 'vue-m-message/dist/style.css'

// Plugins de datepicker
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

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

Date.prototype.addDays = function (days) {
    const date = new Date(this.valueOf());
    date.setDate(date.getDate() + days);
    return date;
};

createApp({
    components: {
        DefaultLayout,
        Login,
        Datepicker,
    },
})
    .use(router)
    .use(VueProgressBar, options)
    .use(abilitiesPlugin, ability, {
        useGlobalProperties: true
    })
    .use(VueSidebarMenu)
    .use(Message)
    .mount('#app');
