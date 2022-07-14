<template>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-info">Modifier personnel</h5>
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
                            <Input v-model="form.nom_personnel" :error="errors.nom_personnel" :required="true">Nom du personnel</Input>
                        </div>

                        <div class="col-xl-6">
                            <Input v-model="form.prenoms_personnel" :error="errors.prenoms_personnel">Prénoms du personnel</Input>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-xl-6">
                            <Input v-model="form.adresse_personnel" :error="errors.adresse_personnel" :required="true">Adresse du personnel</Input>
                        </div>
                        <div class="col-xl-6">
                            <Input v-model="form.contact_personnel" :error="errors.contact_personnel" :required="true">Contact du personnel</Input>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-xl-6">
                            <Input v-model="form.cin_personnel" :error="errors.cin_personnel">CIN du personnel</Input>
                        </div>
                        <div class="col-xl-6">
                            <Input v-model="form.email" :error="errors.email">Email du personnel</Input>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-xl-12">
                            <label for="fonctions">Fonctions du personnel</label>
                            <Multiselect
                                label="nom_fonction" valueProp="id" :multiple="true" v-model="form.fonctions"
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
                            <input type="checkbox" @change="checkAccount" v-model="form.hasAccount" id="hasAccount" class="form-check-input me-3" />
                            <label for="hasAccount" class="form-label">{{ getAccountText }}</label>
                        </div>
                    </div>

                    <div v-if="form.hasAccount" class="row mb-2">
                        <div class="col-xl-4">
                            <Input v-model="form.username" :error="errors.username" :required="true">Nom d'utilisateur</Input>
                        </div>
                        <div class="col-xl-4">
                            <Input v-model="form.password" type="password" :error="errors.password" :required="true">Definir le mot de passe (password par defaut)</Input>
                        </div>
                        <div class="col-xl-4">
                            <Input v-model="form.password_confirmation" type="password" :error="errors.password_confirmation" :required="true">Confirmer le mot de passe (password par defaut)</Input>
                        </div>
                    </div>

                    <div v-if="form.hasAccount">
                        <h5 class="mb-3 mt-4">Informations des rôles</h5>

                        <div class="row mb-2">
                            <div class="col-xl-12">
                                <input type="checkbox" @change="checkRole" v-model="form.hasRole" id="hasRole" class="form-check-input me-3" />
                                <label for="hasRole" class="form-label">{{ getRoleText }}</label>
                            </div>
                        </div>
                    </div>

                    <transition name="fade">
                        <div class="mb-2 row" v-if="form.hasRole && form.hasAccount">
                            <div class="col-xl-12 mb-3">
                                <Multiselect
                                    label="description" valueProp="id" :multiple="true" v-model="form.permissions['Default']"
                                    :options="roles" mode="tags" :closeOnSelect="false" :clearOnSelect="false"
                                    :searchable="true" placeholder="Selectionner les permissions"
                                />
                            </div>

                            <div class="col-xl-12 mb-3" v-for="(item, key, index) in permissionGroups" :key="index">
                                <label class="form-label" for="permissions">Permissions en tant que {{ key }}</label>
                                <Multiselect
                                    label="description" valueProp="id" :multiple="true"
                                    v-model="form.permissions[key]" :options="item" mode="tags"
                                    :closeOnSelect="false" :clearOnSelect="false" :searchable="true"
                                    :placeholder="'Selectionner les permissions en tant que ' + key"
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

import usePersonnelles from '../../services/PersonnelServices';
import useRoles from '../../services/RoleServices';
import useFonctions from '../../services/FonctionServices';
import Input from '../../components/html/Input.vue';
import Alert from '../../components/html/Alert.vue';
import SaveBtn from '../../components/html/SaveBtn.vue';

import pagination from 'laravel-vue-pagination'
import Multiselect from '@vueform/multiselect';
import axiosClient from '../../axios'

const { errors, success, getPersonnel, resetFlashMessages, personnel, updatePersonnel } = usePersonnelles();
const { roles, getRoles } = useRoles();
const { fonction, fonctions, getFonction, getFonctions } = useFonctions();

export default {
    components: {
        Input, Alert, SaveBtn, pagination, Multiselect
    },
    data() {
        return {
            form: {
                id: null,
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
                permissions: [],
                fonctions: [],
                hasAccount: false,
                hasRole: false,
            },
            permissionGroups: [],
            old: [],
        }
    },
    setup() {
        return {
            errors, success, roles, getRoles, getPersonnel, personnel, updatePersonnel,
            fonction, fonctions, getFonction, getFonctions,
        };
    },
    computed: {
        getAccountText() {
            if (this.form.hasAccount) return "Décocher cette case pour supprimer le compte de l'utilisateur"
            else return "Cocher cette case pour ajouter un compte utilisateur"
        },
        getRoleText() {
            if (this.form.hasRole) return "Decocher ici pour supprimer toute les rôles du personnel"
            else return "Cocher ici pour associer un (des) rôles au personnel"
        }
    },
    methods: {
        /**
         * Permet d'enregistrer un nouveau personnel
         *
         * @return  {Object}  Objet contenant le nouveau personnel
         */
        save () {
            updatePersonnel(this.form).then(() => {
                if (success.value !== null) this.$router.push('/personnel/profile/' + this.form.id);
            });
        },

        checkAccount (e) {
            if (e.target.checked === false) {
                this.form.hasRole = false;
                this.form.roles = [];
            }
        },

        checkRole (e) {
            if (e.target.checked === false) this.form.roles = []
        },

        getAllPermissions () {
            let fonctionIds = this.form.fonctions
            fonctionIds = fonctionIds.filter(el => this.old.indexOf(el) === -1)

            axiosClient.get('/permissions-groups', { params: fonctionIds }).then(response => {
                this.permissionGroups = response.data
                if (Object.keys(this.permissionGroups).length > 0) {
                    Object.keys(this.permissionGroups).forEach(key => {
                        this.form.permissions[key] = this.permissionGroups[key].map(el => el.id)
                        this.form.permissions[key] = this.form.permissions[key].filter((v, i, a) => a.indexOf(v) === i)
                    })
                } else {
                    const def = this.form.permissions["Default"]

                    if (def !== undefined) this.form.permissions = { Default: def }
                    else this.form.permissions = []
                }

                this.form.permissions = Object.assign({}, this.form.permissions)
            }).catch(error => {
                console.log(error)
            })

            /*let fonctionIds = this.form.fonctions
            axiosClient.get('permissions-fonction', { params: fonctionIds }).then(response => {
                this.form.roles = response.data
            }).catch (error => {
                console.error(error);
            })*/
        }
    },
    mounted() {
        resetFlashMessages(); // Efface les messages de succes et d'erreurs
        let id = parseInt(this.$route.params.id); // Recuperer l'id du personnel dans l'url

        getPersonnel(id).then(() => {
            this.form = {
                id: personnel.value.id,
                nom_personnel: personnel.value.nom_personnel,
                prenoms_personnel: personnel.value.prenoms_personnel,
                contact_personnel: personnel.value.contact_personnel,
                cin_personnel: personnel.value.cin_personnel,
                adresse_personnel: personnel.value.adresse_personnel,
                email: personnel.value.email,
                username: personnel.value.username,
                password: personnel.value.password ?? 'password',
                password_confirmation: personnel.value.password ?? 'password',
            };

            this.form.hasAccount = personnel.value.username !== null
            this.form.permissions =  { Default: personnel.value.roles.map(item => item.id) }
            this.form.fonctions = personnel.value.fonctions.map(item => item.id)
            this.form.hasRole = personnel.value.roles.length > 0

            this.old = this.form.fonctions
        }); // Recuperer le personnel

        getRoles(1, 0); // Recuperer toutes les roles et le mettre dans la variable réactive roles
        getFonctions(null)
    },
}

</script>
