<template>
    <div>
        <vue-progress-bar></vue-progress-bar>

        <div id="preloader">
            <div class="loader"></div>
        </div>

        <sidebar-menu
            class="sidebar"
            @update:collapsed="onCollapse"
            :menu="menu"
            width="290px"
            :showOneChild="true"
            theme='grey-theme'
        />

        <div class="main-content" id="view" :class="[{'collapsed' : collapsed}]">
            <!-- header area start -->
            <div class="header-area">
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
                        <ul class="notification-area pull-right">
                            <li id="full-view"><i class="ti-fullscreen"></i></li>
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
                            </li>
                            <li class="settings-btn">
                                <i class="ti-settings"></i>
                            </li>
                            <li class="dropdown">
                                <i class="ti ti-user" data-toggle="dropdown"></i>

                                <div class="dropdown-menu bell-notify-box notify-box">
                                    <span class="notify-title">{{ user === null ? "Loading" : user.nom_personnel + ' ' + user.prenoms_personnel }} <a href="#">Mon compte</a></span>
                                    <div class="nofity-list">
                                        <a href="#" @click="logOut()" class="notify-item">
                                            <div class="notify-thumb"><i class="fa fa-cog btn-primary"></i></div>
                                            <div class="notify-text">
                                                <p>Paramètres</p>
                                                <span>Paramètres du compte</span>
                                            </div>
                                        </a>
                                        <a href="#" @click="logOut()" class="notify-item">
                                            <div class="notify-thumb"><i class="fa fa-sign-out btn-danger"></i></div>
                                            <div class="notify-text">
                                                <p>Se deconnecter</p>
                                                <span>Quitter l'app</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <router-view class="mt-5 ps-2 pe-2" v-slot="{ Component }">
                <transition name="fade" mode="out-in">
                    <component :is="Component"></component>
                </transition>
            </router-view>
        </div>

        <footer>
            <div class="footer-area">
                <p>© Copyright 2018. All right reserved.</p>
            </div>
        </footer>

        <div class="offset-area">
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

<script>

    import axiosClient from '../axios';
    import store from '../store';
    import useAbility from '../services/AbilityServices';

    const { permissions, getPermissions }  = useAbility()

    const logoImg = {
        data() {
            return {
                src: '/images/app-logo.png'
            }
        },
        template: '<img :src="src" class="w-100 mt-4 mb-4 pe-5 ps-5"><hr class="bg-light ms-5 me-5">'
    }

    export default {
        setup() {
            return {
                permissions,
                getPermissions,
            }
        },

        data() {
            return {
                collapsed: false,
                className: 'hidden',
            }
        },

        mounted() {
            this.$Progress.finish();
        },

        created() {
            this.className = 'hidden'
            this.$Progress.start();

            this.$router.beforeEach((to, from, next) => {

                axiosClient.get('abilities').then(response => {
                    this.$ability.update([
                        { subject: 'all', action: response.data }
                    ])

                    if (to.meta.gate !== undefined && this.$can(to.meta.gate) === false) {
                        // Si pas de privilège necessaire
                        this.$router.push('/403')
                    }
                }).catch(err => {
                    console.error("Erreur ajax : ", err.response.data.message)
                })

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
            /**
             * Permet de deconnecter un utilisateur
             *
             * @return  {void}  Redirection permanente vers la page login
             **/
            async logOut () {
                await axiosClient.post('/auth/logout')
                this.resetUser()
                // this.$router.push('/login')
                window.location.href = '/login'
            },

            onCollapse(c) {
                this.collapsed = c;
            },

            /**
             * Mettre l'utilisateur connecté dans le store
             *
             * @return  {void}
             */
            resetUser () {
                store.state.user.token = null
                store.state.user.data = {}
                localStorage.removeItem('auth_token')
            },
        },

        computed: {
            /**
             * Permet de detecter si un utilisateur est connecté ou non
             *
             * @return  {Boolean}  True si connecté, False sinon
             */
            isConnected () {
                return store.state.user.token === null ? false : true;
            },

            /**
             * Utilisateur connecté
             *
             * @return  {Object}  L'utilisateur connecté
             */
            user () {
                return store.getters.user
            },

            menu () {
                return [
                    {
                        header: true,
                        hiddenOnCollapse: true,
                        component: logoImg,
                    },
                    {
                        href: '/',
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
                                title: 'Nouveau article',
                                icon: 'fa fa-plus',
                                class: 'fw-regular',
                                // hidden: !this.$can('add_user'),
                            },
                            {
                                href: '/article/liste',
                                title: 'Liste des article',
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
                        title: 'Dévis',
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
                                href: '/point-de-vente/liste',
                                title: 'Dévise',
                                icon: 'fa fa-money',
                            },
                            {
                                href: '/parametres/entreprise',
                                title: 'Infos de l\'entreprise',
                                icon: 'fa fa-info-circle',
                            },
                        ]
                    },
                ];
            }
        }
    }
</script>


<style>

#view {
    padding-left: 300px;
    transition: all;
    transition-duration: .3s;
}

#view.collapsed {
    transition-duration: .5s;
    padding-left: 80px;
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
