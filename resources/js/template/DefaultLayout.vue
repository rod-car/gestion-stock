<template>
    <div>
        <vue-progress-bar></vue-progress-bar>

        <div id="preloader">
            <div class="loader"></div>
        </div>

        <sidebar-menu class="sidebar" @update:collapsed="onCollapse" :menu="menu" width="290px" :showOneChild="true"
            theme='grey-theme' @item-click="onItemClick" v-if="isConnected" />

        <div class="main-content" id="view" :class="[{ 'collapsed': collapsed, 'no-width': !isConnected }]">
            <!-- header area start -->
            <div v-if="isConnected" class="header-area mb-5">
                <div class="row align-items-center">
                    <!-- nav and search button -->
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="search-box pull-left">
                            <form action="#">
                                <input type="text" name="search" placeholder="Search..." required>
                                <i class="ti-search"></i>
                            </form>
                        </div>
                    </div>
                    <!-- profile info & task notification -->
                    <div class="col-md-6 col-sm-4 clearfix">
                        <ul class="notification-area pull-right d-flex align-items-center">
                            <!-- <li id="full-view"><i class="ti-fullscreen"></i></li>
                            <li id="full-view-exit"><i class="ti-zoom-out"></i></li>
                            <li class="dropdown">
                                <i class="ti-bell dropdown-toggle" data-toggle="dropdown">
                                    <span>2</span>
                                </i>
                                <div class="dropdown-menu bell-notify-box notify-box">
                                    <span class="notify-title">You have 3 new notifications <a href="#">view all</a></span>
                                    <div class="nofity-list">
                                        <a href="#" class="notify-item">
                                            <div class="notify-thumb"><i class="ti-key btn-danger"></i></div>
                                            <div class="notify-text">
                                                <p>You have Changed Your Password</p>
                                                <span>Just Now</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown">
                                <i class="fa fa-envelope-o dropdown-toggle" data-toggle="dropdown"><span>3</span></i>
                                <div class="dropdown-menu notify-box nt-enveloper-box">
                                    <span class="notify-title">You have 3 new notifications <a href="#">view all</a></span>
                                    <div class="nofity-list">
                                        <a href="#" class="notify-item">
                                            <div class="notify-thumb">
                                                <img src="assets/images/author/author-img1.jpg" alt="image">
                                            </div>
                                            <div class="notify-text">
                                                <p>Aglae Mayer</p>
                                                <span class="msg">Hey I am waiting for you...</span>
                                                <span>3:15 PM</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </li> -->
                            <li>
                                <i class="fa fa-sign-out" @click="logOut"></i>
                            </li>
                            <li class="dropdown">
                                <i class="ti ti-user me-2" data-toggle="dropdown"></i>
                                <span class="text-uppercase text-muted">{{ user === null ? "Chargement..." :
                                    user.nom_personnel + ' ' + user.prenoms_personnel }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <router-view class="ps-2 pe-2" v-slot="{ Component }">
                <transition name="fade" mode="out-in">
                    <component :is="Component"></component>
                </transition>
            </router-view>
        </div>

        <footer v-if="isConnected">
            <div class="footer-area">
                <p>© {{ infoEntreprise.generale.nom }} - {{
                    infoEntreprise.generale.assujeti ? "Assujeti a la TVA" :
                    "Non assujeti a la TVA"
                }} - {{ new Date().getFullYear().toString() }}.</p>
            </div>
        </footer>

        <div v-if="isConnected" class="offset-area">
            <div class="offset-close"><i class="ti-close"></i></div>
            <ul class="nav offset-menu-tab">
                <li><a class="active" data-toggle="tab" href="#activity">Activity</a></li>
                <li><a data-toggle="tab" href="#settings">Settings</a></li>
            </ul>
            <div class="offset-content tab-content">
                <div id="activity" class="tab-pane fade in show active">
                    <div class="recent-activity">
                        <div class="timeline-task">
                            <div class="icon bg1">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <div class="tm-title">
                                <h4>Rashed sent you an email</h4>
                                <span class="time"><i class="ti-time"></i>09:35</span>
                            </div>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse distinctio itaque at.</p>
                        </div>
                    </div>
                </div>
                <div id="settings" class="tab-pane fade">
                    <div class="offset-settings">
                        <h4>General Settings</h4>
                        <div class="settings-list">
                            <div class="s-settings">
                                <div class="s-sw-title">
                                    <h5>Notifications</h5>
                                    <div class="s-swtich">
                                        <input type="checkbox" id="switch1" />
                                        <label for="switch1">Toggle</label>
                                    </div>
                                </div>
                                <p>Keep it 'On' When you want to get all the notification.</p>
                            </div>
                            <div class="s-settings">
                                <div class="s-sw-title">
                                    <h5>Show recent activity</h5>
                                    <div class="s-swtich">
                                        <input type="checkbox" id="switch2" />
                                        <label for="switch2">Toggle</label>
                                    </div>
                                </div>
                                <p>The for attribute is necessary to bind our custom checkbox with the input.</p>
                            </div>
                            <div class="s-settings">
                                <div class="s-sw-title">
                                    <h5>Show your emails</h5>
                                    <div class="s-swtich">
                                        <input type="checkbox" id="switch3" />
                                        <label for="switch3">Toggle</label>
                                    </div>
                                </div>
                                <p>Show email so that easily find you.</p>
                            </div>
                            <div class="s-settings">
                                <div class="s-sw-title">
                                    <h5>Show Task statistics</h5>
                                    <div class="s-swtich">
                                        <input type="checkbox" id="switch4" />
                                        <label for="switch4">Toggle</label>
                                    </div>
                                </div>
                                <p>The for attribute is necessary to bind our custom checkbox with the input.</p>
                            </div>
                            <div class="s-settings">
                                <div class="s-sw-title">
                                    <h5>Notifications</h5>
                                    <div class="s-swtich">
                                        <input type="checkbox" id="switch5" />
                                        <label for="switch5">Toggle</label>
                                    </div>
                                </div>
                                <p>Use checkboxes when looking for yes or no answers.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">

import axiosClient from '../axios';
import store from '../store';
import useAbility from '../services/AbilityServices';
import { computed, defineComponent, Ref, ref } from 'vue';

interface User {
    id: number | null,
    role: number | null,
    nom_personnel: string | null,
    prenoms_personnel: string | null
}

const { permissions, getPermissions } = useAbility()

const logoImg = {
    setup() {
        return {
            src: '/images/app-logo.png'
        }
    },
    template: '<img :src="src" class="w-100 mt-4 mb-4 pe-5 ps-5"><hr class="bg-light ms-5 me-5">'
}

export default defineComponent({
    setup() {
        const collapsed: Ref<boolean> = ref(false);
        const infoEntreprise = computed(() => {
            return store.state.infoEntreprise
        })

        return {
            permissions,
            getPermissions,
            collapsed,
            infoEntreprise,
        }
    },

    mounted() {
        this.$Progress.finish();
    },

    created() {
        this.$Progress.start();
        this.$router.beforeEach((to, from, next) => {
            if (this.isConnected) {
                axiosClient.get('abilities').then(response => {
                    this.$ability.update([
                        { subject: 'all', action: response.data }
                    ])

                    if (to.meta.gate !== undefined && to.meta.gate !== null && this.$can(to.meta.gate) === false) {
                        // Si pas de privilège necessaire
                        this.$router.push('/403')
                    }
                }).catch(err => {
                    console.error("Erreur ajax : ", err.response.data.message)
                })
            }

            if (to.meta.progress !== undefined) {
                let meta = to.meta.progress;
                this.$Progress.parseMeta(meta);
            }
            this.$Progress.start();
            next();
        });

        this.$router.afterEach((to, from) => {
            this.$Progress.finish();
        });
    },

    methods: {
        onItemClick(event, item) {
            if (item.logout === true) {
                this.logOut();
            }
        },

        /**
         * Permet de deconnecter un utilisateur
         *
         * @return  {Promise}  Redirection permanente vers la page login
         **/
        async logOut(): Promise<any> {
            await axiosClient.post('/auth/logout')
            this.resetUser()
            this.$router.push('/login')
        },


        /**
         * Si le menu se collapse
         *
         * @param   {boolean}  c  True or False
         *
         * @return  {void}
         */
        onCollapse(c: boolean): void {
            this.collapsed = c;
        },

        /**
         * Mettre l'utilisateur connecté dans le store
         *
         * @return  {void}
         */
        resetUser(): void {
            store.state.user.token = null
            store.state.user.data = { id: null, role: null, nom_personnel: null, prenoms_personnel: null }
            localStorage.removeItem('auth_token')
        },


    },

    computed: {
        /**
         * Permet de detecter si un utilisateur est connecté ou non
         *
         * @return  {Boolean}  True si connecté, False sinon
         */
        isConnected(): boolean {
            return store.state.user.token === null ? false : true;
        },

        /**
         * Utilisateur connecté
         *
         * @return  {User}  L'utilisateur connecté
         */
        user(): User {
            return store.getters.user
        },


        /**
         * Sidebar
         *
         * @return  {Array}
         */
        menu(): Array<any> {
            return [
                {
                    header: true,
                    hiddenOnCollapse: true,
                    component: logoImg,
                },
                {
                    href: '/dashboard',
                    title: 'Dashboard',
                    icon: 'fa fa-bar-chart'
                },
                {
                    header: "Dépot",
                    hidden: !this.$can('add_point_vente') && !this.$can('view_point_vente') && !this.$can('add_entrepot') && !this.$can('view_entrepot'),
                    hiddenOnCollapse: true,
                },
                {
                    title: 'Point de vente',
                    icon: 'fa fa-home',
                    hidden: !this.$can('add_point_vente') && !this.$can('view_point_vente'),
                    child: [
                        {
                            title: 'Ajouter nouveau',
                            href: '/point-de-vente/nouveau',
                            icon: 'fa fa-plus',
                            hidden: !this.$can('add_point_vente'),
                        },
                        {
                            title: 'Liste',
                            href: '/point-de-vente/liste',
                            icon: 'fa fa-list',
                            hidden: !this.$can('view_point_vente'),
                        },
                    ]
                },
                {
                    title: 'Entrepôt',
                    icon: 'fa fa-home',
                    hidden: !this.$can('add_entrepot') && !this.$can('view_entrepot'),
                    child: [
                        {
                            title: 'Ajouter nouveau',
                            href: '/entrepot/nouveau',
                            icon: 'fa fa-plus',
                            hidden: !this.$can('add_entrepot'),
                        },
                        {
                            title: 'Liste',
                            href: '/entrepot/liste',
                            icon: 'fa fa-list',
                            hidden: !this.$can('view_entrepot'),
                        },
                    ]
                },
                // Menu pour la gestion de client et fournisseur
                // -----------------------------------------------------------------------------------------------------
                {
                    header: "Clients & Fournisseurs",
                    hiddenOnCollapse: true,
                    hidden: false,
                },
                {
                    title: 'Client',
                    icon: 'fa fa-users',
                    hidden: false,
                    child: [
                        {
                            href: '/client/nouveau',
                            title: 'Nouveau client',
                            icon: 'fa fa-plus',
                            class: 'fw-regular',
                            // hidden: !this.$can('add_user'),
                        },
                        {
                            href: '/client/liste',
                            title: 'Liste des clients',
                            icon: 'fa fa-list',
                            // hidden: !this.$can('view_user'),
                        },
                        {
                            title: 'Les catégories',
                            icon: 'fa fa-tasks',
                            child: [
                                {
                                    href: '/client/categorie/nouveau',
                                    title: 'Nouveau',
                                    icon: 'fa fa-plus',
                                    class: 'fw-regular',
                                    // hidden: !this.$can('add_user'),
                                },
                                {
                                    href: '/client/categorie/liste',
                                    title: 'Liste',
                                    icon: 'fa fa-list',
                                    class: 'fw-regular',
                                    // hidden: !this.$can('add_user'),
                                },
                            ],
                            // hidden: !this.$can('manage_roles_and_functions'),
                        },
                    ]
                },
                {
                    title: 'Fournisseurs',
                    icon: 'fa fa-users',
                    hidden: false,
                    child: [
                        {
                            href: '/fournisseur/nouveau',
                            title: 'Nouveau fournisseur',
                            icon: 'fa fa-plus',
                            class: 'fw-regular',
                            // hidden: !this.$can('add_user'),
                        },
                        {
                            href: '/fournisseur/liste',
                            title: 'Liste des fournisseurs',
                            icon: 'fa fa-list',
                            // hidden: !this.$can('view_user'),
                        },
                        {
                            title: 'Les catégories',
                            icon: 'fa fa-tasks',
                            child: [
                                {
                                    href: '/fournisseur/categorie/nouveau',
                                    title: 'Nouveau',
                                    icon: 'fa fa-plus',
                                    class: 'fw-regular',
                                    // hidden: !this.$can('add_user'),
                                },
                                {
                                    href: '/fournisseur/categorie/liste',
                                    title: 'Liste',
                                    icon: 'fa fa-list',
                                    class: 'fw-regular',
                                    // hidden: !this.$can('add_user'),
                                },
                            ],
                            // hidden: !this.$can('manage_roles_and_functions'),
                        },
                    ]
                },
                // -----------------------------------------------------------------------------------------------------
                // Menu pour la gestion de l'article
                // -----------------------------------------------------------------------------------------------------
                {
                    header: "Article",
                    hiddenOnCollapse: true,
                    hidden: false,
                },
                {
                    title: 'Article',
                    icon: 'fa fa-gift',
                    hidden: false,
                    child: [
                        {
                            href: '/article/nouveau',
                            title: 'Nouvel article',
                            icon: 'fa fa-plus',
                            class: 'fw-regular',
                            // hidden: !this.$can('add_user'),
                        },
                        {
                            href: '/article/liste',
                            title: 'Liste des articles',
                            icon: 'fa fa-list',
                            // hidden: !this.$can('view_user'),
                        },
                        {
                            title: 'Les catégories',
                            icon: 'fa fa-tasks',
                            child: [
                                {
                                    href: '/article/categorie/nouveau',
                                    title: 'Nouveau',
                                    icon: 'fa fa-plus',
                                    class: 'fw-regular',
                                    // hidden: !this.$can('add_user'),
                                },
                                {
                                    href: '/article/categorie/liste',
                                    title: 'Liste',
                                    icon: 'fa fa-list',
                                    class: 'fw-regular',
                                    // hidden: !this.$can('add_user'),
                                },
                            ],
                            // hidden: !this.$can('manage_roles_and_functions'),
                        },

                    ]
                },
                {
                    title: 'Devis',
                    icon: 'fa fa-file',
                    hidden: false,
                    child: [
                        {
                            href: '/devis/fournisseur/liste',
                            title: 'Approvisionnement',
                            icon: 'fa fa-arrow-right',
                            // hidden: !this.$can('view_devis'),
                        },
                        {
                            href: '/devis/client/liste',
                            title: 'Vente',
                            icon: 'fa fa-arrow-left',
                            // hidden: !this.$can('view_devis'),
                        },
                    ]
                },
                // --------------------------------------------------------------
                {
                    title: 'Commande',
                    icon: 'fa fa-file',
                    hidden: false,
                    child: [
                        {
                            href: '/commande/fournisseur/liste',
                            title: 'Approvisionnement',
                            icon: 'fa fa-arrow-right',
                            // hidden: !this.$can('view_commande'),
                        },
                        {
                            href: '/commande/client/liste',
                            title: 'Vente',
                            icon: 'fa fa-arrow-left',
                            // hidden: !this.$can('view_commande'),
                        },
                    ]
                },
                {
                    title: 'Bon de livraison',
                    icon: 'fa fa-file',
                    hidden: false,
                    child: [
                        {
                            href: '/bon-reception/liste',
                            title: 'Fournisseur',
                            icon: 'fa fa-arrow-right',
                            // hidden: !this.$can('view_commande'),
                        },
                        {
                            href: '/bon-livraison/liste',
                            title: 'Client',
                            icon: 'fa fa-arrow-left',
                            // hidden: !this.$can('view_commande'),
                        },
                    ]
                },
                {
                    title: "Transfert d'article",
                    icon: 'fa fa-exchange',
                    hidden: false,
                    child: [
                        {
                            href: '/transfert-article/nouveau',
                            title: 'Nouveau transfert',
                            icon: 'fa fa-plus',
                            class: 'fw-regular',
                            // hidden: !this.$can('add_user'),
                        },
                        {
                            href: '/transfert-article/liste',
                            title: "Liste des transferts d'article",
                            icon: 'fa fa-list',
                            // hidden: !this.$can('view_user'),
                        },
                    ]
                },
                // ---------------------------------------------------------------------------------------
                {
                    header: "Personnel",
                    hiddenOnCollapse: true,
                    hidden: !this.$can('manage_roles_and_functions') && !this.$can('view_user') && !this.$can('add_user'),
                },
                {
                    title: 'Personnel',
                    icon: 'fa fa-users',
                    hidden: !this.$can('manage_roles_and_functions') && !this.$can('view_user') && !this.$can('add_user'),
                    child: [
                        {
                            href: '/personnel/nouveau',
                            title: 'Nouveau personnel',
                            icon: 'fa fa-plus',
                            class: 'fw-regular',
                            hidden: !this.$can('add_user'),
                        },
                        {
                            href: '/personnel/liste',
                            title: 'Liste des personnel',
                            icon: 'fa fa-list',
                            hidden: !this.$can('view_user'),
                        },
                        {
                            href: '/personnel/fonctions',
                            title: 'Les fonctions & rôles',
                            icon: 'fa fa-tasks',
                            hidden: !this.$can('manage_roles_and_functions'),
                        },
                    ]
                },
                {
                    header: "Paramètres",
                    hiddenOnCollapse: true,
                    hidden: !this.$can('manage_settings'),
                },
                {
                    title: 'Paramètres',
                    icon: 'fa fa-cog',
                    hidden: !this.$can('manage_settings'),
                    child: [
                        {
                            title: 'Devise',
                            icon: 'fa fa-money',
                        },
                        {
                            href: '/parametres/entreprise',
                            title: 'Infos de l\'entreprise',
                            icon: 'fa fa-info-circle',
                        },
                        {
                            href: '/parametres/etiquette/liste',
                            title: 'La liste des étiquettes',
                            icon: 'fa fa-tag',
                        },
                    ]
                },
                {
                    header: "Mon compte",
                    hiddenOnCollapse: true,
                },
                {
                    title: 'Déconnexion',
                    logout: true,
                    icon: 'fa fa-sign-out',
                },
            ];
        }
    }
});
</script>


<style scoped>
#view {
    padding-left: 300px;
    transition: all;
    transition-duration: .3s;
}

#view.collapsed {
    transition-duration: .5s;
    padding-left: 80px;
}

#view.no-width {
    padding: 0 !important;
    margin: 0 !important;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-active {
    opacity: 0;
}
</style>
