<template>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="text-center" v-show="loading">Chargement</div>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="text-uppercase text-info">Liste des personnelles</h5>
                    <router-link to="/personnel/nouveau" class="btn btn-primary"><i class="fa fa-user-plus me-2"></i>Ajouter nouveau</router-link>
                </div>
                <div class="single-table">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="text-uppercase bg-secondary">
                                <tr class="text-white">
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
                                    <th class="text-center text-info" colspan="4">Chargement des données</th>
                                </tr>
                            </tbody>
                            <tbody v-show="!loading">
                                <tr v-for="personnelle in personnelles.data" v-bind:key="personnelle.id">
                                    <th scope="row">{{ personnelle.id }}</th>
                                    <th scope="row">{{ personnelle.nom_personnel }}</th>
                                    <th scope="row">{{ personnelle.prenoms_personnel }}</th>
                                    <th scope="row">{{ personnelle.adresse_personnel }}</th>
                                    <th scope="row">{{ personnelle.email }}</th>
                                    <th scope="row">{{ personnelle.contact_personnel }}</th>
                                    <th scope="row">{{ personnelle.cin_personnel }}</th>
                                    <th scope="row">{{ "En cours de developpement" }}</th>
                                    <th scope="row">{{ personnelle.created_at }}</th>
                                    <td class="d-inline-flex">
                                        <router-link :to="{ name: 'gestion-des-personnels.personnel.profil', params: { id: personnelle.id }}" class="btn btn-primary btn-sm me-2"><i class="fa fa-eye"></i></router-link>
                                        <router-link :to="{ name: 'gestion-des-personnels.personnel.modifier', params: { id: personnelle.id }}" class="btn btn-info btn-sm me-2"><i class="fa fa-edit"></i></router-link>
                                        <router-link class="btn btn-danger btn-sm" to="/"><i class="fa fa-trash"></i></router-link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination">
                        <pagination align="center" :data="personnelles" @pagination-change-page="getPersonnelles"></pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import pagination from 'laravel-vue-pagination'
import usePersonnelles from '../../../services/PersonnelServices';

const { personnelles, getPersonnelles } = usePersonnelles();

export default {
    components: {
        pagination,
    },
    setup() {
        return {
            personnelles,
            getPersonnelles,
        };
    },
    mounted() {
        getPersonnelles();
    },
}
</script>

<style scoped>
    .pagination{
        margin-top: 20px;
        margin-bottom: 0;
    }
</style>
