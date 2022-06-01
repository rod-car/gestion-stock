<template>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="text-center" v-show="loading">Chargement</div>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="text-uppercase text-info">Liste des fonctions</h5>
                    <button @click="showForm" class="btn btn-primary"><i class="fa fa-plus me-2"></i>Ajouter nouveau</button>
                </div>

                <Alert type="success" :message="success" />
                <Alert type="danger" :message="errors" />

                {{ form.permissions }}

                <div class="mt-3 mb-3">
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-xl-12 mb-3">
                                <Input v-model="form.nom_fonction" :error="errors.nom_fonction" :required="true">Nom de la fonction</Input>
                            </div>
                            <div class="col-xl-12 mb-3">
                                <Input type="textarea" v-model="form.description_fonction" :error="errors.description_fonction">Description de la fonction</Input>
                            </div>
                            <div class="col-xl-12 mb-3">
                                <label class="form-label" for="permissions">Selectionner les permissions</label>
                                <Multiselect
                                    label="description"
                                    valueProp="id"
                                    :multiple="true"
                                    v-model="form.permissions"
                                    :options="roles"
                                    mode="tags"
                                    :closeOnSelect="false"
                                    :clearOnSelect="false"
                                    :searchable="true"
                                    placeholder="Selectionner les permissions"
                                />
                            </div>
                            <div class="col-xl-12 mb-3 d-flex justify-content-end">
                                <SaveBtn @click.prevent="save">Enregistrer</SaveBtn>
                            </div>
                        </div>
                    </form>

                    {{ roles }}
                </div>

                <table class="table table-striped table-hover">
                    <thead class="text-uppercase">
                        <tr>
                            <th>ID</th>
                            <th>Libelle</th>
                            <th>Description</th>
                            <th>Nombre de personnel</th>
                            <th>Roles</th>
                            <th>Actions</th>
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
                            <td>{{ fonction.description }}</td>
                            <td>{{ "En cours de debogage" }}</td>
                            <td>{{ "10 personnel" }}</td>

                            <td class="d-inline-flex">
                                <!--router-link :to="{ name: 'gestion-des-personnels.personnel.profil', params: { id: personnelle.id }}" class="btn btn-primary btn-sm me-2"><i class="fa fa-eye"></i></router-link-->
                                <!--router-link v-if="$can('edit_user')" :to="{ name: 'gestion-des-personnels.personnel.modifier', params: { id: personnelle.id }}" class="btn btn-info btn-sm me-2"><i class="fa fa-edit"></i></router-link-->
                                <form action="" method="post">
                                    <DeleteBtn type="danger" @click.prevent="confirmDeletion(fonction.id)"/>
                                </form>
                            </td>
                        </tr>
                        <tr v-if="fonctions.data && fonctions.data.length === 0">
                            <td class="text-center" colspan="6">Aucune fonction définie</td>
                        </tr>
                    </tbody>
                </table>

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

import Multiselect from '@vueform/multiselect'
import useRoles from '../../../services/RoleServices';

const { success, errors, fonctions, deleteFonction, getFonctions, createFonction, resetFlashMessages } = useFonctions();
const { roles, getRoles } = useRoles();

export default {
    data() {
        return {
            form: {
                nom_fonction: null,
                description_fonction: null,
                permissions: [],
            },
            options: [
                { id: 1, description_fonction: "Rakoto" },
                { id: 2, description_fonction: "Rabe" },
            ],
        }
    },
    components: {
        pagination, DeleteBtn, Alert, Input, SaveBtn, Multiselect,
    },
    setup() {
        return {
            errors, success, fonctions, roles,
            deleteFonction, getFonctions, resetFlashMessages, createFonction, getRoles,
        };
    },
    mounted() {
        getFonctions()
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
            /*SimpleAlert.fire({
                title: "Question",
                message: 'Supprimer ce personnel ?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui, supprimer',
                confirmButtonClass: 'btn btn-danger',
                cancelButtonText: 'Non, annuler'
            })*/

            SimpleAlert.confirm("Voulez-vous supprimer ce personnel ?", "Question", "question").then(() => {
                deleteFonction(id)
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
        save () {
            createFonction(this.form)
        }
    },
}
</script>

<style scoped>
    .pagination{
        margin-top: 20px;
        margin-bottom: 0;
    }
</style>

<style src="@vueform/multiselect/themes/default.css"></style>
