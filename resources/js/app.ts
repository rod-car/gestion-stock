require('./bootstrap');

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

import Maska from 'maska';

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

const app = createApp({
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

app.use(Maska);
app.config.globalProperties.$SimpleAlert = VueSimpleAlert
app.mount('#app');

declare module '@vue/runtime-core' {
    interface ComponentCustomProperties {
        $const: typeof router;
        $Progress: typeof VueProgressBar;
        $ability: typeof ability;
        $can: any;
        SimpleAlert: VueSimpleAlert;
    }
}

export { }

