<template>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="text-center" v-show="loading">Chargement</div>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="text-info">Liste des fonctions</h5>

                    <Transition name="slide-fade">
                        <button v-if="editing === false" @click.prevent="showNewForm" v-bind:class="isCreating ? 'btn btn-danger' : 'btn btn-primary'">
                            <span v-if="isCreating"><i class="fa fa-close me-2"></i>Fermer</span>
                            <span v-else><i class="fa fa-plus me-2"></i>Ajouter une nouvelle</span>
                        </button>
                    </Transition>
                </div>

                <Alert type="success" :message="success" />
                <Alert type="danger" :message="errors" />

                <Transition name="slide-fade">
                    <div v-if="creating" class="mt-3 shadow-lg p-3 mb-5 bg-body rounded">
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-xl-12 mb-3">
                                    <Input v-model="form.nom_fonction" :error="errors.nom_fonction" :required="true">Nom de la fonction</Input>
                                </div>

                                <div class="col-xl-12 mb-3">
                                    <label class="form-label" for="permissions">Fonctions inclus s'il y en a</label>
                                    <Multiselect
                                        label="nom_fonction" valueProp="id" :multiple="true"
                                        v-model="form.enfants" :options="enfants" mode="tags"
                                        :closeOnSelect="false" :clearOnSelect="false" :searchable="true"
                                        placeholder="Selectionner les fonctions"
                                        @close="groupPermissions"
                                    />
                                </div>

                                <div class="col-xl-12 mb-3">
                                    <label class="form-label" for="permissions">Selectionner les permissions (<span class="text-danger">*</span>)</label>
                                    <Multiselect
                                        label="description" valueProp="id" :multiple="true"
                                        v-model="form.permissions['Default']" :options="roles" mode="tags"
                                        :closeOnSelect="false" :clearOnSelect="false" :searchable="true"
                                        placeholder="Selectionner les permissions"
                                    />
                                </div>

                                <div class="col-xl-12 mb-3" v-for="(item, key, index) in groups" :key="index">
                                    <label class="form-label" for="permissions">Permissions en tant que {{ key }}</label>
                                    <Multiselect
                                        label="description" valueProp="id" :multiple="true"
                                        v-model="form.permissions[key]" :options="item" mode="tags"
                                        :closeOnSelect="false" :clearOnSelect="false" :searchable="true"
                                        placeholder="Selectionner les permissions"
                                    />
                                </div>

                                <div class="col-xl-12 mb-3">
                                    <Input type="textarea" v-model="form.description_fonction" :error="errors.description_fonction">Description de la fonction</Input>
                                </div>
                                <div class="col-xl-12 mb-3 d-flex justify-content-end">
                                    <SaveBtn @click.prevent="save">Enregistrer</SaveBtn>
                                </div>
                            </div>
                        </form>
                    </div>
                </Transition>

                <div v-if="editing" class="mt-3 shadow-lg p-3 mb-5 bg-body rounded">
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-xl-12 mb-3">
                                <Input v-model="form.nom_fonction" :error="errors.nom_fonction" :required="true">Nom de la fonction</Input>
                            </div>

                            <div class="col-xl-12 mb-3">
                                <label class="form-label" for="permissions">Fonctions inclus s'il y en a</label>
                                <Multiselect
                                    label="nom_fonction" valueProp="id" :multiple="true"
                                    v-model="form.enfants" :options="enfants" mode="tags"
                                    :closeOnSelect="false" :clearOnSelect="false" :searchable="true"
                                    placeholder="Selectionner les fonctions"
                                />
                            </div>

                            <div class="col-xl-12 mb-3">
                                <label class="form-label" for="permissions">Selectionner les permissions</label>
                                <Multiselect
                                    label="description" valueProp="id" :multiple="true" v-model="form.permissions"
                                    :options="roles" mode="tags" :closeOnSelect="false" :clearOnSelect="false"
                                    :searchable="true" placeholder="Selectionner les permissions"
                                />
                            </div>

                            <div class="col-xl-12 mb-3">
                                <Input type="textarea" v-model="form.description_fonction" :error="errors.description_fonction">Description de la fonction</Input>
                            </div>

                            <div class="col-xl-12 mb-3 d-flex justify-content-end">
                                <button @click.prevent="isEditing = false" class="btn btn-danger me-2"><i class="fa fa-close me-2"></i>Annuler</button>
                                <SaveBtn @click.prevent="update">Mettre a jour</SaveBtn>
                            </div>
                        </div>
                    </form>
                </div>

                <Transition name="fade">
                    <table class="table table-striped table-hover">
                        <thead class="text-uppercase">
                            <tr>
                                <th>ID</th>
                                <th>Libelle</th>
                                <th>Description</th>
                                <th>Nombre de personnel</th>
                                <th>Permissions</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody v-if="loading">
                            <tr>
                                <td class="text-center text-info" colspan="4">Chargement des données</td>
                            </tr>
                        </tbody>
                        <tbody v-if="!loading">
                            <tr v-for="fonction in fonctions.data" v-bind:key="fonction.id">
                                <td>{{ fonction.id }}</td>
                                <td>{{ fonction.nom_fonction }}</td>
                                <td>{{ fonction.description_fonction ?? "Aucune description" }}</td>
                                <td>{{ fonction.personnelles_count === 0 ? "Aucune personnel" : fonction.personnelles_count }}</td>
                                <td>
                                    <span v-for="permission in fonction.permissions" :key="permission.id" class="badge bg-success me-2">{{ permission.description }}</span>
                                </td>

                                <td class="d-flex justify-content-between">
                                    <EditBtn v-if="creating === false" @click.prevent="editFonction(fonction.id)" />
                                    <form action="" method="post">
                                        <DeleteBtn type="danger" @click.prevent="confirmDeletion(fonction.id)" />
                                    </form>
                                </td>
                            </tr>
                            <tr v-if="fonctions.data && fonctions.data.length === 0">
                                <td class="text-center" colspan="6">Aucune fonction définie</td>
                            </tr>
                        </tbody>
                    </table>
                </Transition>

                <div class="pagination">
                    <pagination align="center" :data="fonctions" @pagination-change-page="getFonctions"></pagination>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import pagination from 'laravel-vue-pagination'
import useFonctions from '../../../services/FonctionServices';
import DeleteBtn from '../../html/DeleteBtn';
import Alert from '../../html/Alert.vue';
import Input from '../../html/Input.vue';
import SaveBtn from '../../html/SaveBtn.vue';
import EditBtn from '../../html/EditBtn.vue';

import Multiselect from '@vueform/multiselect'
import useRoles from '../../../services/RoleServices';
import axiosClient from '../../../axios';

const { success, errors, fonction, fonctions, deleteFonction, getFonction, updateFonction, getFonctions, createFonction, resetFlashMessages } = useFonctions();
const { roles, getRoles } = useRoles();

export default {
    data() {
        return {
            form: {
                nom_fonction: null,
                description_fonction: null,
                permissions: [],
                enfants: [],
            },
            isCreating: false,
            isEditing: false,
            groups: null ,
            selectedValue: [],
        }
    },
    components: {
        pagination, DeleteBtn, Alert, Input, SaveBtn, EditBtn, Multiselect,
    },
    setup() {
        return {
            errors, success, fonction, fonctions, roles,
            deleteFonction, getFonction, updateFonction, getFonctions, resetFlashMessages, createFonction, getRoles,
        };
    },
    computed: {
        creating () { return this.isCreating }, // En cours de création - Afficher le formulaire d'ajout
        editing () { return this.isEditing } // En cours de modification - Afficher le formulaire d'édition
    },

    mounted() {
        getFonctions().then(() => {
            this.enfants = fonctions.value.data
        })
        resetFlashMessages()
        getRoles(null, 0);
    },

    methods: {
        /**
         * Confirmer la suppresion d'un personnel
         *
         * @param   {integr}  id  Identifiant du personnel
         *
         * @return  {void}
         */
        confirmDeletion (id) {
            SimpleAlert.confirm("Voulez-vous supprimer cette fonction ?", "Question", "question").then(() => {
                deleteFonction(id)
                getFonctions()
                SimpleAlert.alert("Supprimé avec success", "Message", "success")
            }).catch (error => {
                if (error !== undefined) {
                    SimpleAlert.alert("Impossible de supprimer l'utilisateur", "Erreur", "error")
                }
            });
        },

        /**
         * Permet d'enregistrer une fonction
         *
         * @return  {void}
         */
        async save () {
            await createFonction(this.form)
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });

            if (success.value !== null) {
                setTimeout(() => {
                    this.resetForm();
                }, 500);
            }
        },

        /**
         * Permet d'enregistrer une fonction
         *
         * @return  {void}
         */
        update () {
            updateFonction(this.form)

            this.resetForm()
            this.isEditing = false
            getFonctions() // Mettre a jour la listes des fonctions

            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        },


        /**
         * Affiche et reinitialise les champs d'ajout
         *
         * @return  {void}
         */
        showNewForm () {
            this.isCreating = !this.isCreating
            this.resetForm()
        },

        /**
         * Permet de réinitialiser les champs
         *
         * @return  {void}
         */
        resetForm () {
            this.form = {
                nom_fonction: null,
                description_fonction: null,
                permissions: [],
                enfants: [],
            }
        },

        /**
         * Permet de modifier une fonction
         *
         * @param   {Integer}  id  Identigfiant de la fonction
         *
         * @return  {void}
         */
        editFonction (id) {
            this.editId = id
            getFonction(id).then((response) => {
                this.form = {
                    nom_fonction: fonction.value.nom_fonction,
                    description_fonction: fonction.value.description_fonction,
                    permissions: fonction.value.permissionIds,
                }

                this.isEditing = true
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            })

            getFonctions().then(() => {
                let enfants = fonctions.value.data.filter((item) => {
                    return item.id !== id
                })
                this.enfants = enfants
            })
        },

        groupPermissions () {
            axiosClient.get('/permissions-groups', { params: this.form.enfants }).then(response => {
                this.groups = response.data

                Object.keys(this.groups).forEach(key => {
                    this.form.permissions[key] = this.groups[key].map(el => el.id)
                })

                this.form.permissions = Object.assign({}, this.form.permissions)
            }).catch(error => {
                console.log(error)
            })
        }
    },
}
</script>

<style scoped>
    .pagination{
        margin-top: 20px;
        margin-bottom: 0;
    }

    .slide-fade-enter-active {
        transition: all 0.3s ease-out;
    }

    .slide-fade-leave-active {
        transition: all 0.3s cubic-bezier(1, 0.5, 0.8, 1);
    }

    .slide-fade-enter-from,
    .slide-fade-leave-to {
        transform: translateY(-20px);
        opacity: 0;
    }

    .slide-down {
        transition: all 2s ease-out;
    }
</style>

<style src="@vueform/multiselect/themes/default.css"></style>
