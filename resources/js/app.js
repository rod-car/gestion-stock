/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('./functions/string')

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 * Include the Popper.js library, since Boostrap 4 requires it
 */
/*try {
    window.$ = window.jQuery = require('jquery');
    window.Popper = Popper;
} catch (e) {}*/

import { createApp } from 'vue'
import router from './components/router/router';
import DefaultLayoutComponent from './components/template/DefaultLayoutComponent.vue';
import Login from './components/pages/Login.vue';

import VueSimpleAlert from "vue3-simple-alert";
import VueProgressBar from "@aacassandra/vue3-progressbar";

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



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

window.SimpleAlert = VueSimpleAlert

createApp({
    components: {
        DefaultLayoutComponent,
        Login,
    },
})
    .use(router)
    .use(VueProgressBar, options)
    .mount('#app');
