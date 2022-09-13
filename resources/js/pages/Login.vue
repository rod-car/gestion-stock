<template>
    <div class="login-area login-s2 m-0">
        <div class="container">
            <div class="login-box ptb--100">
                <form method="POST" class="shadow-lg" action="">
                    <div class="login-form-head">
                        <h4>Se connecter</h4>
                        <p>Vous devez vous connecter pour acceder a l'application</p>

                        <div v-if="loading" class="alert alert-success mt-3">
                            {{ loadingIndicator }}
                        </div>

                        <div v-if="errorMessage" class="alert alert-danger mt-3">
                            Exception: {{ errorMessage }}
                        </div>

                        <div v-if="errors.login && !loading" class="alert alert-danger mt-3">
                            {{ errors.login[0] }}
                        </div>

                    </div>
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="email">Adresse email ou nom d'utilisateur</label>
                            <input type="email" name="email" id="email" v-model="form.email" @input="input('email')">
                            <i class="ti-email"></i>
                            <div class="text-danger" v-if="errors.email">
                                {{ errors.email[0] }}
                            </div>
                        </div>
                        <div class="form-gp">
                            <label for="password">Mot de passe</label>
                            <input type="password" id="password" name="password" v-model="form.password" @input="input('password')">
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
import { computed, onMounted, Ref, ref } from 'vue';
import router from '../router/router';

interface Form {
    email: String,
    password: String,
    remember: Boolean | any,
};

interface Errors {
    email: Array<string> | null,
    password: Array<string> | null,
};

export default {
    setup () {
        const form = ref({
            email: '',
            password: '',
            remember: false
        } as Form);

        const errors = ref({ email: null, password: null } as Errors);
        const errorMessage: Ref<string | null> = ref(null);
        const loading: Ref<Boolean> = ref(false);
        const indicator: Ref<String> = ref("Chargement...");

        const loadingIndicator = computed(() => {
            return loading.value === true ? indicator.value : '';
        });

        const login = async (): Promise<any> => {
            try {
                loading.value = true

                await axios.get('/sanctum/csrf-cookie')
                let response = await axios.post('api/auth/login', form.value)

                store.state.user.token = response.data.token
                localStorage.setItem('auth_token', response.data.token)

                indicator.value = "Connecté. Redirection en cours..."
                router.push('dashboard')
            } catch(err: any) {
                if (err.response && err.response.data.errors) errors.value = err.response.data.errors
                else errorMessage.value = err.response.data.message
                loading.value = false;
            }
        }

        onMounted(() => {
            const inputs = document.querySelectorAll('.form-gp input') as NodeListOf<HTMLInputElement>
            inputs.forEach((input) => {
                input.addEventListener('focus', () => {
                    input.parentElement?.classList.add('focused')
                });

                input.addEventListener('focusout', () => {
                    if (input.value.length === 0) {
                        input.parentElement?.classList.remove('focused');
                    }
                });
            })
        })

        const input = (key: string) => {
            if (errors.value[key] && errors.value[key].length > 0) errors.value[key] = null
        }

        return {
            form, loading, loadingIndicator, login, errors, errorMessage, input,
        };
    }
};

</script>
