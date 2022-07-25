<template>
    <div class="login-area login-s2">
        <div class="container">
            <div class="login-box ptb--100">
                <form method="POST" class="shadow-lg" action="">
                    <div class="login-form-head">
                        <h4>Se connecter</h4>
                        <p>Vous devez vous connecter pour acceder a l'application</p>

                        <div v-if="loading" class="alert alert-success mt-3">
                            {{ loadingIndicator }}
                        </div>

                        <div v-if="!Array.isArray(errors)" class="alert alert-danger mt-3">
                            Impossible de se connecter a la base de données...
                        </div>

                    </div>
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="exampleInputEmail1">Adresse email ou nom d'utilisateur</label>
                            <input type="email" name="login" id="exampleInputEmail1" v-model="form.login">
                            <i class="ti-email"></i>
                            <div class="text-danger" v-if="errors.login">
                                {{ errors.login[0] }}
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
                            <button id="form_submit" type="submit" @click.prevent="login">Se connecter <i class="ti-arrow-right"></i></button>
                        </div>
                        <div class="form-footer text-center mt-5">
                            <p class="text-muted">Pas encore de compte ? <a href="#">Créer un compte</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script lang="ts">

import store from '../store';
import axios from 'axios'
import { computed, defineComponent, Ref, ref } from 'vue';

interface Form {
    login: String,
    password: String,
    remember: Boolean | any,
};

interface Errors {
    login: Array<string> | null,
    password: Array<string> | null,
};

export default defineComponent({
    setup () {
        const form = ref({
            login: '',
            password: '',
            remember: false
        } as Form);

        const errors = ref({ login: null, password: null } as Errors);
        const loading: Ref<Boolean> = ref(false);
        const indicator: Ref<String> = ref("Chargement...");

        const loadingIndicator = computed(() => {
            return loading.value === true ? indicator.value : '';
        });

        const login = async () => {
            try {
                loading.value = true

                await axios.get('/sanctum/csrf-cookie')
                let response = await axios.post('api/auth/login', form.value)

                store.state.user.token = response.data.token
                localStorage.setItem('auth_token', response.data.token)

                indicator.value = "Connecté. Redirection en cours..."
                window.location.href = "/dashboard"
            } catch(err: any) {
                if (err.response && err.response.data.errors) errors.value = err.response.data.errors
                else errors.value = err.response.data.message
                loading.value = false;
            }
        }

        return {
            form, loading, loadingIndicator, login, errors,
        };
    }
});


</script>
