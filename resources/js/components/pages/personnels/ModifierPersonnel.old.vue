<template>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="text-center" v-show="loading">Chargement</div>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="text-uppercase text-info">Nouveau personnel</h5>
                    <router-link to="/personnel/liste" class="btn btn-primary"><i class="fa fa-list me-2"></i>Liste des personnelles</router-link>
                </div>

                <Alert type="success" :message="success" />
                <Alert type="danger" :message="errors.message" />

                <h5 class="mb-3">Remplir les informations du personnel</h5>

                <form action="" method="post">
                    <div class="row mb-2">
                        <div class="col-xl-6">
                            <Input v-model="form.nom_personnel" :error="errors.nom_personnel">Nom du personnel</Input>
                        </div>

                        <div class="col-xl-6">
                            <Input v-model="form.prenoms_personnel" :error="errors.prenoms_personnel">Prénoms du personnel</Input>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-xl-6">
                            <Input v-model="form.adresse_personnel" :error="errors.adresse_personnel">Adresse du personnel</Input>
                        </div>
                        <div class="col-xl-6">
                            <Input v-model="form.contact_personnel" :error="errors.contact_personnel">Contact du personnel</Input>
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
                    <div class="row mb-2 mt-3">
                        <div class="col-xl-12 d-flex justify-content-end">
                            <SaveBtn :click="save">Enregistrer</SaveBtn>
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
import SaveBtn from '../../html/SaveBtn.vue';

const { errors, loading, success, personnel, getPersonnel, updatePersonnel, resetFlashMessages } = usePersonnelles();

export default {
    components: {
        Input,
        Alert,
        SaveBtn,
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
                roles: [],
            },
        }
    },
    setup() {
        return {
            errors,
            success,
            loading,
            personnel,
        };
    },
    methods: {
        /**
         * Permet d'enregistrer un nouveau personnel
         *
         * @return  {Object}  Objet contenant le nouveau personnel
         */
        async save () {
            updatePersonnel(this.form).then(() => {
                this.$router.push('/personnel/profile/' + this.form.id);
            });
        },
    },
    mounted() {
        resetFlashMessages();

        let id = parseInt(this.$route.params.id);
        getPersonnel(id).then(() => {
            this.form = {
                id: personnel.value.id,
                nom_personnel: personnel.value.nom_personnel,
                prenoms_personnel: personnel.value.prenoms_personnel,
                contact_personnel: personnel.value.contact_personnel,
                cin_personnel: personnel.value.cin_personnel,
                adresse_personnel: personnel.value.adresse_personnel,
                email: personnel.value.email,
            };
        });
    },
}

</script>
