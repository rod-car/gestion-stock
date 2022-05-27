<template>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="text-center" v-show="loading">Chargement</div>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="text-uppercase text-info">Liste des personnelles</h5>
                    <router-link to="/personnel/nouveau" class="btn btn-primary"><i class="fa fa-user-plus me-2"></i>Ajouter nouveau</router-link>
                </div>

                <Alert type="success" :message="success" />
                <Alert type="danger" :message="errors" />

                <table class="table table-striped table-hover">
                    <thead class="text-uppercase">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Prénoms</th>
                            <th scope="col">Adresse</th>
                            <th scope="col">Adresse email</th>
                            <th scope="col">Contact</th>
                            <th scope="col">CIN</th>
                            <th scope="col">Fonction / Type</th>
                            <th scope="col">Date de création</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody v-show="loading">
                        <tr>
                            <td class="text-center text-info" colspan="4">Chargement des données</td>
                        </tr>
                    </tbody>
                    <tbody v-show="!loading">
                        <tr v-for="personnelle in personnelles.data" v-bind:key="personnelle.id">
                            <td scope="row">{{ personnelle.id }}</td>
                            <td scope="row">{{ personnelle.nom_personnel }}</td>
                            <td scope="row">{{ personnelle.prenoms_personnel }}</td>
                            <td scope="row">{{ personnelle.adresse_personnel }}</td>
                            <td scope="row">{{ personnelle.email ?? "Aucune" }}</td>
                            <td scope="row">{{ personnelle.contact_personnel }}</td>
                            <td scope="row">{{ personnelle.cin_personnel ?? "Aucune" }}</td>
                            <td scope="row">{{ "En cours de developpement" }}</td>
                            <td scope="row">{{ personnelle.created_at }}</td>
                            <td class="d-inline-flex">
                                <router-link :to="{ name: 'gestion-des-personnels.personnel.profil', params: { id: personnelle.id }}" class="btn btn-primary btn-sm me-2"><i class="fa fa-eye"></i></router-link>
                                <router-link :to="{ name: 'gestion-des-personnels.personnel.modifier', params: { id: personnelle.id }}" class="btn btn-info btn-sm me-2"><i class="fa fa-edit"></i></router-link>
                                <form action="" method="post">
                                    <DeleteBtn type="danger" @click.prevent="deletePersonnel(personnelle.id)"/>
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
import usePersonnelles from '../../../services/PersonnelServices';
import DeleteBtn from '../../html/DeleteBtn';
import Alert from '../../html/Alert.vue';

const { success, errors, personnelles, deletePersonnel, getPersonnelles, resetFlashMessages } = usePersonnelles();

export default {
    components: {
        pagination,
        DeleteBtn,
        Alert,
    },
    data() {
        return {
            deletinId: null,
        }
    },
    setup() {
        return {
            errors,
            success,
            personnelles,
            deletePersonnel,
            getPersonnelles,
            resetFlashMessages,
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
        confirmDeletion (id) {
            this.deletinId = id;
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
