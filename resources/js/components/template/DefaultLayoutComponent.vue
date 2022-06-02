<template>
    <div>
        <vue-progress-bar></vue-progress-bar>
        <!-- preloader area start -->
        <div id="preloader">
            <div class="loader"></div>
        </div>
        <!-- preloader area end -->
        <!-- page container area start -->
        <div v-bind:class="isConnected ? '' : 'ps-0'" class="page-container">
            <!-- sidebar menu area start -->
            <div v-if="isConnected" class="sidebar-menu">
                <div class="sidebar-header">
                    <div class="logo">
                        <router-link to="/" class="w-75" style="max-width:100%!important"><img src="/images/app-logo.png" alt="logo"></router-link>
                    </div>
                </div>
                <div class="main-menu">
                    <div class="menu-inner">
                        <nav>
                            <ul class="metismenu" id="menu">
                                <li class="">
                                    <a href="javascript:void(0)"><i class="ti-dashboard" aria-expanded="true"></i><span>dashboard</span></a>
                                    <ul class="collapse">
                                        <li class=""><router-link to="/dashboard">Dashboard</router-link></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript:void(0)" aria-expanded="true"><i class="ti-shopping-cart"></i><span>Article</span></a>
                                    <ul class="collapse">
                                        <li><router-link to="/article/nouveau"><i class="fa fa-plus-circle me-2"></i>Nouveau</router-link></li>
                                        <li><router-link to="/article/liste"><i class="fa fa-list me-2"></i>Listes</router-link></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-list-alt"></i><span>Catégories</span></a>
                                    <ul class="collapse">
                                        <li><router-link to="/article/nouveau"><i class="fa fa-plus-circle me-2"></i>Nouveau</router-link></li>
                                        <li><router-link to="/article/liste"><i class="fa fa-list me-2"></i>Listes</router-link></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-home"></i><span>Point de vente</span></a>
                                    <ul class="collapse">
                                        <li><router-link to="/point-de-vente/nouveau"><i class="fa fa-plus-circle me-2"></i>Nouveau</router-link></li>
                                        <li><router-link to="/point-de-vente/liste"><i class="fa fa-list me-2"></i>Listes</router-link></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" aria-expanded="true"><i class="ti-home"></i><span>Entrepôt</span></a>
                                    <ul class="collapse">
                                        <li><router-link to="/entrepot/nouveau"><i class="fa fa-plus-circle me-2"></i>Nouveau</router-link></li>
                                        <li><router-link to="/entrepot/liste"><i class="fa fa-list me-2"></i>Listes</router-link></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-users"></i><span>Fournisseurs</span></a>
                                    <ul class="collapse">
                                        <li><router-link to="/entrepot/nouveau"><i class="fa fa-plus-circle me-2"></i>Nouveau</router-link></li>
                                        <li><router-link to="/entrepot/liste"><i class="fa fa-list me-2"></i>Listes</router-link></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-users"></i><span>Clients</span></a>
                                    <ul class="collapse">
                                        <li><router-link to="/entrepot/nouveau"><i class="fa fa-plus-circle me-2"></i>Nouveau</router-link></li>
                                        <li><router-link to="/entrepot/liste"><i class="fa fa-list me-2"></i>Listes</router-link></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-user"></i><span>Gestion des personnels</span></a>
                                    <ul class="collapse">
                                        <li v-if="$can('add_user')"><router-link to="/personnel/nouveau"><i class="fa fa-plus-circle me-2"></i>Nouveau personnel</router-link></li>
                                        <li v-if="$can('view_user')"><router-link to="/personnel/liste"><i class="fa fa-list me-2"></i>Liste des personnelles</router-link></li>
                                        <li v-if="$can('manage_roles_and_functions')"><router-link to="/personnel/fonctions"><i class="fa fa-tasks me-2"></i>Les fonctions & rôles</router-link></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-gear"></i><span>Paramètres</span></a>
                                    <ul class="collapse">
                                        <li><router-link to="/entrepot/nouveau"><i class="fa fa-dollar me-2"></i>Devis</router-link></li>
                                        <li><router-link to="/entrepot/liste"><i class="fa fa-dollar me-2"></i>Format d'argent</router-link></li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <!-- sidebar menu area end -->
            <!-- main content area start -->
            <div class="main-content">
                <!-- header area start -->
                <div v-if="isConnected" class="header-area">
                    <div class="row align-items-center">
                        <!-- nav and search button -->
                        <div class="col-md-6 col-sm-8 clearfix">
                            <div class="nav-btn pull-left">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
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

                <div class="main-content-inner">
                    <router-view v-bind:class="isConnected ? 'mt-5' : ''"></router-view>
                </div>
            </div>
            <!-- main content area end -->
            <!-- footer area start-->
            <footer v-if="isConnected">
                <div class="footer-area">
                    <p>© Copyright 2018. All right reserved. Template by <a href="https://colorlib.com/wp/">Colorlib</a>.</p>
                </div>
            </footer>
            <!-- footer area end-->
        </div>
        <!-- page container area end -->
        <!-- offset area start -->
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
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse distinctio itaque at.
                            </p>
                        </div>
                        <div class="timeline-task">
                            <div class="icon bg2">
                                <i class="fa fa-check"></i>
                            </div>
                            <div class="tm-title">
                                <h4>Added</h4>
                                <span class="time"><i class="ti-time"></i>7 Minutes Ago</span>
                            </div>
                            <p>Lorem ipsum dolor sit amet consectetur.
                            </p>
                        </div>
                        <div class="timeline-task">
                            <div class="icon bg2">
                                <i class="fa fa-exclamation-triangle"></i>
                            </div>
                            <div class="tm-title">
                                <h4>You missed you Password!</h4>
                                <span class="time"><i class="ti-time"></i>09:20 Am</span>
                            </div>
                        </div>
                        <div class="timeline-task">
                            <div class="icon bg3">
                                <i class="fa fa-bomb"></i>
                            </div>
                            <div class="tm-title">
                                <h4>Member waiting for you Attention</h4>
                                <span class="time"><i class="ti-time"></i>09:35</span>
                            </div>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse distinctio itaque at.
                            </p>
                        </div>
                        <div class="timeline-task">
                            <div class="icon bg3">
                                <i class="ti-signal"></i>
                            </div>
                            <div class="tm-title">
                                <h4>You Added Kaji Patha few minutes ago</h4>
                                <span class="time"><i class="ti-time"></i>01 minutes ago</span>
                            </div>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse distinctio itaque at.
                            </p>
                        </div>
                        <div class="timeline-task">
                            <div class="icon bg1">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <div class="tm-title">
                                <h4>Ratul Hamba sent you an email</h4>
                                <span class="time"><i class="ti-time"></i>09:35</span>
                            </div>
                            <p>Hello sir , where are you, i am egerly waiting for you.
                            </p>
                        </div>
                        <div class="timeline-task">
                            <div class="icon bg2">
                                <i class="fa fa-exclamation-triangle"></i>
                            </div>
                            <div class="tm-title">
                                <h4>Rashed sent you an email</h4>
                                <span class="time"><i class="ti-time"></i>09:35</span>
                            </div>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse distinctio itaque at.
                            </p>
                        </div>
                        <div class="timeline-task">
                            <div class="icon bg2">
                                <i class="fa fa-exclamation-triangle"></i>
                            </div>
                            <div class="tm-title">
                                <h4>Rashed sent you an email</h4>
                                <span class="time"><i class="ti-time"></i>09:35</span>
                            </div>
                        </div>
                        <div class="timeline-task">
                            <div class="icon bg3">
                                <i class="fa fa-bomb"></i>
                            </div>
                            <div class="tm-title">
                                <h4>Rashed sent you an email</h4>
                                <span class="time"><i class="ti-time"></i>09:35</span>
                            </div>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse distinctio itaque at.
                            </p>
                        </div>
                        <div class="timeline-task">
                            <div class="icon bg3">
                                <i class="ti-signal"></i>
                            </div>
                            <div class="tm-title">
                                <h4>Rashed sent you an email</h4>
                                <span class="time"><i class="ti-time"></i>09:35</span>
                            </div>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse distinctio itaque at.
                            </p>
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

    import axiosClient from '../../axios';
    import store from '../../store';
    import useAbility from '../../services/AbilityServices';

    const { permissions, getPermissions }  = useAbility()

    export default {
        setup() {
            return {
                permissions,
                getPermissions,
            }
        },

        components: {

        },

        mounted() {
            this.$Progress.finish();
        },

        created() {
            this.$Progress.start();

            this.$router.beforeEach((to, from, next) => {

                axiosClient.get('abilities').then(response => {
                    this.$ability.update([
                        { subject: 'all', action: response.data }
                    ])

                    if (to.meta.gate !== undefined && this.$can(to.meta.gate) === false) { // Si pas de privilège necessaire
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
                this.$router.push('/login')
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
        }
    }
</script>
