<template>
    <div class="col-xl-12">
        <div v-if="errors.message">
            <div class="card">
                <div class="card-body text-center">
                    <h1>404</h1>
                    <h3>Page introuvable</h3>
                </div>
            </div>
        </div>

        <div v-if="errors.length === 0" class="card">
            <div class="card-body">
                <div class="text-center" v-show="loading">Chargement</div>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="text-info">Information du personnel</h5>
                    <router-link v-if="personnel.id && $can('edit_user')" :to="{ name: 'gestion-des-personnels.personnel.modifier', params: { id: personnel.id }}" class="btn btn-primary btn-sm me-2"><i class="fa fa-edit me-2"></i>Modifier</router-link>
                </div>

                <div class="row mb-2">
                    <div class="col-xl-6">
                        <label for="" class="form-label">Nom & prénoms du personnel</label>
                        <label for="" class="form-control">{{ personnel.nom_personnel }}</label>
                    </div>
                    <div class="col-xl-6">
                        <label for="" class="form-label">Prénoms du personnel</label>
                        <label for="" class="form-control">{{ personnel.prenoms_personnel ?? "Non défini" }}</label>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-xl-6">
                        <label for="" class="form-label">Adresse du personnel</label>
                        <label for="" class="form-control">{{ personnel.adresse_personnel }}</label>
                    </div>
                    <div class="col-xl-6">
                        <label for="" class="form-label">Contact du personnel</label>
                        <label for="" class="form-control">{{ personnel.contact_personnel }}</label>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-xl-6">
                        <label for="" class="form-label">CIN du personnel</label>
                        <label for="" class="form-control">{{ personnel.cin_personnel ?? "Aucun CIN" }}</label>
                    </div>
                    <div class="col-xl-6">
                        <label for="" class="form-label">Email du personnel</label>
                        <label for="" class="form-control">{{ personnel.email ?? "Aucune adresse email" }}</label>
                    </div>
                </div>


                <div class="row mb-2">
                    <div clas="col-xl-12">
                        <label for="" class="form-label">Le (s) fonction (s) du personnel</label>
                        <div class="form-control">
                            <span v-for="fonction in personnel.fonctions" :key="fonction.id" class="badge bg-primary me-2">{{ fonction.nom_fonction }}</span>
                        </div>
                    </div>
                </div>

                <div class="row" v-if="personnel.roles && personnel.roles.length > 0">
                    <div class="col-xl-12">
                        <label for="" class="form-label">Liste des roles - {{ personnel.roles.length }} rôle(s) au total</label>
                        <ol class="list-group list-group-numbered">
                            <li v-for="role in personnel.roles" v-bind:key="role.id" class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">{{ role.description }}</div>
                                </div>
                                <span class="badge bg-primary rounded-pill"><i class="fa fa-check"></i></span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import usePersonnelles from '../../services/PersonnelServices'

const { personnel, errors, loading, getPersonnel } = usePersonnelles();

export default {
    setup() {
        return {
            errors,
            loading,
            personnel,
            getPersonnel,
        };
    },
    mounted() {
        let id = parseInt(this.$route.params.id);
        getPersonnel(id);
    },
}
</script>
