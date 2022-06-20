<template>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="text-center" v-show="loading">Chargement</div>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="text-info">Liste des personnelles</h5>
                    <router-link v-if="$can('add_user')" to="/personnel/nouveau" class="btn btn-primary"><i class="fa fa-user-plus me-2"></i>Ajouter nouveau</router-link>
                </div>

                <Alert type="success" :message="success" />
                <Alert type="danger" :message="errors" />

                <table class="table table-striped table-hover">
                    <thead class="text-uppercase">
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénoms</th>
                            <th>Adresse</th>
                            <th>Adresse email</th>
                            <th>Contact</th>
                            <th>CIN</th>
                            <th>Fonction / Type</th>
                            <th>Date de création</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody v-if="loading">
                        <tr>
                            <td class="text-center text-info" colspan="10">Chargement des données</td>
                        </tr>
                    </tbody>
                    <tbody v-if="!loading">
                        <tr v-for="(personnelle, index) in personnelles.data" v-bind:key="personnelle.id">
                            <td>{{ personnelle.id }}</td>
                            <td>{{ personnelle.nom_personnel }}</td>
                            <td>{{ personnelle.prenoms_personnel }}</td>
                            <td>{{ personnelle.adresse_personnel }}</td>
                            <td>{{ personnelle.email ?? "Aucune" }}</td>
                            <td>{{ personnelle.contact_personnel }}</td>
                            <td>{{ personnelle.cin_personnel ?? "Aucune" }}</td>
                            <td>
                                <span v-for="fonction in personnelle.fonctions" :key="fonction.id" class="badge bg-primary me-2">{{ fonction.nom_fonction }}</span>
                            </td>
                            <td>{{ personnelle.created_at }}</td>
                            <td class="d-inline-flex">
                                <router-link :to="{ name: 'gestion-des-personnels.personnel.profil', params: { id: personnelle.id }}" class="btn btn-primary btn-sm me-2"><i class="fa fa-eye"></i></router-link>
                                <router-link v-if="$can('edit_user')" :to="{ name: 'gestion-des-personnels.personnel.modifier', params: { id: personnelle.id }}" class="btn btn-info btn-sm me-2"><i class="fa fa-edit"></i></router-link>
                                <form v-if="$can('delete_user')" action="" method="post">
                                    <DeleteBtn type="danger" @click.prevent="confirmDeletion(personnelle.id, index)"/>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="pagination">
                    <pagination align="center" :data="personnelles" @pagination-change-page="getPersonnelles"></pagination>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import pagination from 'laravel-vue-pagination'
import usePersonnelles from '../../services/PersonnelServices';
import DeleteBtn from '../../components/html/DeleteBtn';
import Alert from '../../components/html/Alert.vue';

const { success, errors, loading, personnelles, deletePersonnel, getPersonnelles, resetFlashMessages } = usePersonnelles();

export default {
    components: {
        pagination,
        DeleteBtn,
        Alert,
    },
    setup() {
        return {
            errors, success, personnelles, loading,
            deletePersonnel, getPersonnelles, resetFlashMessages,
        };
    },
    mounted() {
        getPersonnelles()
        resetFlashMessages()
    },
    methods: {
        /**
         * Confirmer la suppresion d'un personnel
         *
         * @param   {integr}  id  Identifiant du personnel
         *
         * @return  {void}
         */
        confirmDeletion (id, index) {
            SimpleAlert.confirm("Voulez-vous supprimer ce personnel ?", "Question", "question").then(() => {
                deletePersonnel(id)
                personnelles.value.data.splice(index)
                SimpleAlert.alert("Supprimé avec succes", "Message", "success")
            }).catch (error => {
                if (error !== undefined) {
                    SimpleAlert.alert("Impossible de supprimer l'utilisateur", "Erreur", "error")
                }
            });
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
