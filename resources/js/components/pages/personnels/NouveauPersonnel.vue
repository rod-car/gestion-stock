<template>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="text-center" v-show="loading">Chargement</div>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="text-uppercase text-info">Liste des personnelles</h5>
                    <router-link to="/personnel/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des personnelles</router-link>
                </div>

                <Alert type="success" :message="success" />

                <h5 class="mb-3">Remplir les informations du personnel</h5>

                <form action="" method="post">
                    <div class="row mb-2">
                        <div class="col-xl-6">
                            <Input v-model="personnel.nom_personnel" placeholder="Nom du personnel" :error="errors.nom_personnel">Nom du personnel</Input>
                        </div>

                        <div class="col-xl-6">
                            <Input v-model="personnel.prenoms_personnel" placeholder="Nom du personnel" :error="errors.prenoms_personnel">Prénoms du personnel</Input>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-xl-6">
                            <Input v-model="personnel.adresse_personnel" placeholder="Nom du personnel" :error="errors.adresse_personnel">Adresse du personnel</Input>
                        </div>
                        <div class="col-xl-6">
                            <Input v-model="personnel.contact_personnel" placeholder="Nom du personnel" :error="errors.contact_personnel">Contact du personnel</Input>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-xl-6">
                            <Input v-model="personnel.cin_personnel" placeholder="Nom du personnel" :error="errors.cin_personnel">CIN du personnel</Input>
                        </div>
                        <div class="col-xl-6">
                            <Input v-model="personnel.email" placeholder="Nom du personnel" :error="errors.email">Email du personnel</Input>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-xl-12">
                            <Input v-model="personnel.password" type="password" placeholder="Nom du personnel" :error="errors.password">Definir le mot de passe (password)</Input>
                        </div>
                    </div>
                    <div class="row mb-2 mt-3">

                        <!--SaveBtn @click.prevent="save">Enregistrer</SaveBtn-->
                        <div class="col-xl-12 d-flex justify-content-end">
                            <button class="btn btn-primary" @click.prevent="save"><i class="fa fa-save me-2"></i>Enregistrer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>

import usePersonnelles from '../../../services/PersonnelServices';
import Input from '../../html/Input.vue';
import Alert from '../../html/Alert.vue';
import { ref } from 'vue';

const { errors, success, createPersonnel } = usePersonnelles();

export default {
    components: {
        Input,
        Alert,
    },
    data() {
        return {
            personnel: {
                nom_personnel: "New",
                prenoms_personnel: "User",
                contact_personnel: "0324543212",
                cin_personnel: "301071023456",
                adresse_personnel: "Tanambao 5",
                email: "user@example.com",
                password: "password",
            },
            test: ref("Valeur"),
        }
    },
    setup() {
        return {
            errors,
            success,
            createPersonnel,
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
        }
    },
    mounted() {

    },
}

</script>
