<template>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-uppercase text-info">Nouveau personnel</h5>
                    <router-link to="/personnel/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des personnelles</router-link>
                </div>
            </div>

            <div class="card-body">
                <div class="text-center" v-show="loading">Chargement</div>

                <Alert type="success" :message="success" />
                <Alert type="danger" :message="errors.message" />

                <form action="" method="post">
                    <h5 class="mb-3">Informations générales</h5>

                    <div class="row mb-2">
                        <div class="col-xl-6">
                            <Input v-model="personnel.nom_personnel" :error="errors.nom_personnel" :required="true">Nom du personnel</Input>
                        </div>

                        <div class="col-xl-6">
                            <Input v-model="personnel.prenoms_personnel" :error="errors.prenoms_personnel">Prénoms du personnel</Input>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-xl-6">
                            <Input v-model="personnel.adresse_personnel" :error="errors.adresse_personnel" :required="true">Adresse du personnel</Input>
                        </div>
                        <div class="col-xl-6">
                            <Input v-model="personnel.contact_personnel" :error="errors.contact_personnel" :required="true">Contact du personnel</Input>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-xl-6">
                            <Input v-model="personnel.cin_personnel" :error="errors.cin_personnel">CIN du personnel</Input>
                        </div>
                        <div class="col-xl-6">
                            <Input v-model="personnel.email" :error="errors.email">Email du personnel</Input>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-xl-12">
                            <label for="fonctions">Fonctions du personnel</label>
                            <Multiselect
                                label="nom_fonction" valueProp="id" :multiple="true" v-model="personnel.fonctions"
                                :options="fonctions" mode="tags" :closeOnSelect="false" :clearOnSelect="false"
                                :searchable="true" placeholder="Selectionner les fonctions"
                                @select="getAllPermissions"
                                @deselect="getAllPermissions"
                            />
                        </div>
                    </div>

                    <h5 class="mb-3 mt-4">Informations de compte d'utilisateur</h5>

                    <div class="row mb-2">
                        <div class="col-xl-12">
                            <input type="checkbox" v-model="personnel.hasAccount" id="hasAccount" class="form-check-input me-3" />
                            <label for="hasAccount" class="form-label">Cocher ici pour créer un compte utilisateur pour le personnel</label>
                        </div>
                    </div>

                    <div v-if="personnel.hasAccount" class="row mb-2">
                        <div class="col-xl-4">
                            <Input v-model="personnel.username" :error="errors.username" :required="true">Nom d'utilisateur</Input>
                        </div>
                        <div class="col-xl-4">
                            <Input v-model="personnel.password" type="password" :error="errors.password" :required="true">Definir le mot de passe (password par defaut)</Input>
                        </div>
                        <div class="col-xl-4">
                            <Input v-model="personnel.password_confirmation" type="password" :error="errors.password_confirmation" :required="true">Confirmer le mot de passe (password par defaut)</Input>
                        </div>
                    </div>

                    <div v-if="personnel.hasAccount">
                        <h5 class="mb-3 mt-4">Informations des permissions</h5>

                        <div class="row mb-2">
                            <div class="col-xl-12">
                                <input type="checkbox" v-model="personnel.hasRole" id="hasRole" class="form-check-input me-3" />
                                <label for="hasRole" class="form-label">Cocher ici pour associer un (des) permissions au personnel</label>
                            </div>
                        </div>
                    </div>

                    <transition name="fade">
                        <div class="mb-2 row" v-if="personnel.hasRole && personnel.hasAccount">
                            <div class="col-xl-12">
                                <Multiselect
                                    label="description" valueProp="id" :multiple="true" v-model="personnel.roles"
                                    :options="roles" mode="tags" :closeOnSelect="false" :clearOnSelect="false"
                                    :searchable="true" placeholder="Selectionner les permissions"
                                />
                            </div>
                        </div>
                    </transition>

                    <div class="row mb-2 mt-3">
                        <div class="col-xl-12 d-flex justify-content-end">
                            <SaveBtn @click.prevent="save">Enregistrer</SaveBtn>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>

import usePersonnelles from '../../../services/PersonnelServices';
import useRoles from '../../../services/RoleServices';
import Input from '../../html/Input.vue';
import Alert from '../../html/Alert.vue';
import SaveBtn from '../../html/SaveBtn.vue';

import pagination from 'laravel-vue-pagination'
import Multiselect from '@vueform/multiselect'
import useFonctions from '../../../services/FonctionServices';
import axiosClient from '../../../axios';

const { errors, success, createPersonnel, resetFlashMessages } = usePersonnelles();
const { fonction, fonctions, getFonction, getFonctions } = useFonctions();
const { roles, getRoles, findRoles } = useRoles();

export default {
    components: {
        Input, Alert, SaveBtn, pagination, Multiselect,
    },
    data() {
        return {
            personnel: {
                nom_personnel: null,
                prenoms_personnel: null,
                contact_personnel: null,
                cin_personnel: null,
                adresse_personnel: null,
                email: null,
                username: null,
                password: 'password',
                password_confirmation: 'password',
                roles: [],
                fonctions: [],
                hasAccount: false,
                hasRole: false,
            },
        }
    },
    setup() {
        return {
            errors, success, createPersonnel, roles, getRoles,
            fonction, fonctions, getFonction, getFonctions,
        };
    },
    methods: {
        /**
         * Permet d'enregistrer un nouveau personnel
         *
         * @return  {Object}  Objet contenant le nouveau personnel
         */
        async save () {
            await createPersonnel(this.personnel);

            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });

            if (success.value !== null) {
                setTimeout(() => {
                    this.resetFields();
                }, 500);
            }
        },

        /**
         * Reinitialiser toutes les champs après enregoistrement
         *
         * @return  {void}
         */
        resetFields () {
            this.personnel = {
                nom_personnel: null,
                prenoms_personnel: null,
                contact_personnel: null,
                cin_personnel: null,
                adresse_personnel: null,
                email: null,
                username: null,
                password: 'password',
                password_confirmation: 'password',
                roles: [],
                fonctions: [],
                hasRole: false,
                hasAccount: false
            };
        },

        searchRole (e) {
            setTimeout(() => {
                let query = e.target.value
                findRoles(query)
            }, 500)
        },

        getAllPermissions () {
            let fonctionIds = this.personnel.fonctions
            axiosClient.get('permissions-fonction', { params: fonctionIds }).then(response => {
                this.personnel.roles = response.data
            }).catch (error => {
                alert('Error')
            })
        }
    },
    mounted() {
        resetFlashMessages(); // Efface les messages de succes et d'erreurs
        getRoles(1, 0); // Recuperer toutes les roles et le mettre dans la variable réactive roles
        getFonctions(null)
    },
}

</script>


<style scoped>
    .pagination{
        margin-top: 20px;
        margin-bottom: 0;
    }
</style>
