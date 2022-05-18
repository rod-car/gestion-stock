<template>
    <div>
        <div id="preloader">
            <div class="loader"></div>
        </div>

        <!-- login area start -->
        <div class="login-area login-s2">
            <div class="container">
                <div class="login-box ptb--100">
                    <form method="POST" class="shadow-lg" action="{{ route('login') }}">
                        <div class="login-form-head">
                            <h4>Se connecter</h4>
                            <p>Vous devez vous connecter pour acceder a l'application</p>
                        </div>
                        <div class="login-form-body">
                            <div class="form-gp">
                                <label for="exampleInputEmail1">Adresse email</label>
                                <input type="email" name="email" id="exampleInputEmail1" v-model="form.email">
                                <i class="ti-email"></i>
                                <div class="text-danger" v-if="errors.email">
                                    {{ errors.email[0] }}
                                </div>
                            </div>
                            <div class="form-gp">
                                <label for="exampleInputPassword1">Mot de passe</label>
                                <input type="password" id="exampleInputPassword1" name="password" v-model="form.password">
                                <i class="ti-lock"></i>
                                <div class="text-danger" v-if="errors.password">
                                    {{ errors.password[0] }}
                                </div>
                            </div>
                            <div class="row mb-4 rmber-area">
                                <div class="col-6">
                                    <div class="custom-control custom-checkbox mr-sm-2">
                                        <input v-model="form.remember" type="checkbox" name="remember" class="custom-control-input me-2" id="customControlAutosizing">
                                        <label class="custom-control-label m-0" for="customControlAutosizing">Se souvenir de moi</label>
                                    </div>
                                </div>
                                <div class="col-6 text-right">
                                    <a href="#">
                                        Mot de passe oublié
                                    </a>
                                </div>
                            </div>
                            <div class="submit-btn-area">
                                <button id="form_submit" type="submit" @click.prevent="logIn">Se connecter <i class="ti-arrow-right"></i></button>
                            </div>
                            <div class="form-footer text-center mt-5">
                                <p class="text-muted">Pas encore de compte ? <a href="register.html">Créer un compte</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    data() {
        return {
            form: {
                email: null,
                password: null,
                remember: false
            },
            errors: {}
        }
    },

    methods: {
        async logIn () {
            try
            {
                await axios.get('/sanctum/csrf-cookie')
                await axios.post('/api/auth/login', this.form)
                window.location = '/'
            }
            catch (error)
            {
                this.errors = error.response.data.errors
            }
        }
    },

    created() {
        /*axios.get('/api/user').then(response => {

        }).catch (error => {

        })*/
    },
}

</script>
